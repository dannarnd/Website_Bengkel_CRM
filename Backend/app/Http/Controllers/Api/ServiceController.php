<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\Sparepart;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller {
    public function index() {
        // Hanya muat relasi ringan untuk tampilan list - JANGAN load details & photos (berat!)
        return Service::with(['kendaraan.pelanggan', 'karyawan', 'warranty'])
            ->select('id_service', 'id_kendaraan', 'id_karyawan', 'invoice_number', 'status', 'total_biaya', 'catatan', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function show($id) {
        $service = Service::with(['kendaraan.pelanggan', 'karyawan', 'details.sparepart', 'photos', 'warranty'])->findOrFail($id);
        
        $service_photo = [
            'foto_before' => null,
            'foto_after' => null
        ];
        
        foreach($service->photos as $photo) {
            if ($photo->tipe_foto === 'Sebelum') $service_photo['foto_before'] = $photo->photo_path;
            if ($photo->tipe_foto === 'Sesudah') $service_photo['foto_after'] = $photo->photo_path;
        }
        
        $service->setAttribute('service_photo', $service_photo);
        
        return $service;
    }
    
    public function uploadPhotos(Request $request, $id) {
        $service = Service::findOrFail($id);
        
        if ($request->hasFile('foto_before')) {
            $path = $request->file('foto_before')->store('services', 'public');
            \App\Models\ServicePhoto::updateOrCreate(
                ['id_service' => $id, 'tipe_foto' => 'Sebelum'],
                ['photo_path' => '/storage/' . $path]
            );
        }
        
        if ($request->hasFile('foto_after')) {
            $path = $request->file('foto_after')->store('services', 'public');
            \App\Models\ServicePhoto::updateOrCreate(
                ['id_service' => $id, 'tipe_foto' => 'Sesudah'],
                ['photo_path' => '/storage/' . $path]
            );
        }
        
        return response()->json(['message' => 'Upload berhasil']);
    }
    public function store(Request $request) {
        $request->validate([
            'id_kendaraan' => 'required',
            'spareparts' => 'array'
        ]);

        $id_karyawan = auth()->user()->id_karyawan ?? 'K001';
        $invoice_number = 'INV-' . date('Ym') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Jika invoice_number bentrok (sangat kecil kemungkinannya), loop atau gunakan uniqid
        while(Service::where('invoice_number', $invoice_number)->exists()) {
            $invoice_number = 'INV-' . date('Ym') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        DB::beginTransaction();
        try {
            $service = Service::create([
                'id_kendaraan' => $request->id_kendaraan,
                'id_karyawan' => $id_karyawan,
                'invoice_number' => $invoice_number,
                'status' => 'Menunggu',
                'total_biaya' => 0,
                'catatan' => $request->catatan
            ]);

            $total = 0;
            if ($request->has('spareparts')) {
                foreach($request->spareparts as $sp) {
                    $sparepart = Sparepart::findOrFail($sp['kode_barang']);
                    $subtotal = $sparepart->harga * $sp['qty'];
                    $total += $subtotal;
                    ServiceDetail::create([
                        'id_service' => $service->id_service,
                        'kode_barang' => $sp['kode_barang'],
                        'qty' => $sp['qty'],
                        'subtotal' => $subtotal
                    ]);
                }
            }
            $service->update(['total_biaya' => $total]);
            DB::commit();
            return response()->json($service->load('details'), 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function updateStatus(Request $request, $id) {
        $request->validate(['status' => 'required|in:Menunggu,Diproses,Selesai']);
        $service = Service::findOrFail($id);
        
        // Cek jika status berubah jadi selesai dan stok belum dipotong
        if ($request->status === 'Selesai' && $service->status !== 'Selesai') {
            DB::beginTransaction();
            try {
                // Potong stok
                foreach($service->details as $detail) {
                    $sp = Sparepart::findOrFail($detail->kode_barang);
                    $sp->stok -= $detail->qty;
                    $sp->save();
                }
                // Terbitkan garansi
                Warranty::create([
                    'id_service' => $service->id_service,
                    'tanggal_selesai' => now()->addDays(30),
                    'status' => 'Aktif'
                ]);
                $service->update(['status' => 'Selesai']);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => $e->getMessage()], 500);
            }
        } else {
            $service->update(['status' => $request->status]);
        }
        
        return response()->json($service);
    }
    
    public function destroy($id) {
        $service = Service::with('details')->findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Jika servis yang dihapus berstatus Selesai, kembalikan stok barang yang sudah terpotong
            if ($service->status === 'Selesai') {
                foreach ($service->details as $detail) {
                    $sp = Sparepart::find($detail->kode_barang);
                    if ($sp) {
                        $sp->stok += $detail->qty;
                        $sp->save();
                    }
                }
            }

            if ($service->warranty) $service->warranty()->delete();
            $service->photos()->delete();
            $service->details()->delete();
            
            $service->delete();
            DB::commit();
            return response()->json(['message' => 'Servis berhasil dihapus dan stok barang telah dikembalikan ke gudang']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addSparepart(Request $request, $id) {
        $request->validate([
            'kode_barang' => 'required',
            'qty' => 'required|numeric|min:1'
        ]);

        $service = Service::findOrFail($id);
        if ($service->status === 'Selesai') {
            return response()->json(['message' => 'Tidak dapat menambah barang pada servis yang sudah selesai. Silakan buka kembali nota terlebih dahulu.'], 400);
        }

        $sparepart = Sparepart::findOrFail($request->kode_barang);
        $subtotal = $sparepart->harga * $request->qty;

        // Cek apakah sparepart sudah ada di detail, jika ada tambahkan qty nya
        $existing = ServiceDetail::where('id_service', $id)->where('kode_barang', $request->kode_barang)->first();
        
        DB::beginTransaction();
        try {
            if ($existing) {
                $existing->qty += $request->qty;
                $existing->subtotal += $subtotal;
                $existing->save();
            } else {
                ServiceDetail::create([
                    'id_service' => $id,
                    'kode_barang' => $request->kode_barang,
                    'qty' => $request->qty,
                    'subtotal' => $subtotal
                ]);
            }
            
            $service->total_biaya += $subtotal;
            $service->save();
            
            DB::commit();
            return response()->json(['message' => 'Berhasil ditambahkan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function finish(Request $request, $id) {
        $request->validate([
            'tanggal_garansi' => 'required|date'
        ]);
        
        $service = Service::with('details')->findOrFail($id);
        if ($service->status === 'Selesai') {
            return response()->json(['message' => 'Servis ini sudah diselesaikan sebelumnya.'], 400);
        }
        
        DB::beginTransaction();
        try {
            // Potong stok
            foreach ($service->details as $detail) {
                $sp = Sparepart::findOrFail($detail->kode_barang);
                $sp->stok -= $detail->qty;
                $sp->save();
            }
            // Terbitkan garansi (update atau buat baru)
            Warranty::updateOrCreate(
                ['id_service' => $service->id_service],
                [
                    'tanggal_selesai' => $request->tanggal_garansi,
                    'status' => 'Aktif'
                ]
            );
            $service->update(['status' => 'Selesai']);
            DB::commit();
            return response()->json(['message' => 'Servis berhasil diselesaikan. Stok dipotong & Garansi diterbitkan.']);
        } catch (\Exception $e) {
            DB::rollback();
            \Illuminate\Support\Facades\Log::error("Finish service error: " . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function removeSparepart($id, $detail_id) {
        $service = Service::findOrFail($id);
        $detail = ServiceDetail::where('id_service', $id)->where('id_service_detail', $detail_id)->firstOrFail();
        
        DB::beginTransaction();
        try {
            // Jika servis berstatus Selesai, kembalikan stok barang yang dihapus
            if ($service->status === 'Selesai') {
                $sp = Sparepart::find($detail->kode_barang);
                if ($sp) {
                    $sp->stok += $detail->qty;
                    $sp->save();
                }
            }

            $service->total_biaya -= $detail->subtotal;
            if ($service->total_biaya < 0) $service->total_biaya = 0;
            $service->save();
            
            $detail->delete();
            DB::commit();
            return response()->json(['message' => 'Barang berhasil dihapus dan stok telah dikembalikan ke gudang']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reopen($id) {
        $service = Service::with(['details', 'warranty'])->findOrFail($id);
        
        if ($service->status !== 'Selesai') {
            return response()->json(['message' => 'Nota ini belum diselesaikan atau sudah dalam status revisi.'], 400);
        }

        DB::beginTransaction();
        try {
            // 1. Kembalikan semua stok barang yang sebelumnya terpotong ke gudang
            foreach ($service->details as $detail) {
                $sp = Sparepart::find($detail->kode_barang);
                if ($sp) {
                    $sp->stok += $detail->qty;
                    $sp->save();
                }
            }

            // 2. Hapus garansi yang sebelumnya terbit
            if ($service->warranty) {
                $service->warranty()->delete();
            }

            // 3. Kembalikan status servis ke "Diproses"
            $service->status = 'Diproses';

            // 4. Catat riwayat pembukaan nota di catatan
            $timestamp = now()->format('d/m/Y H:i');
            $userNama = auth()->user()->name ?? 'Admin';
            $log = "[Revisi/Buka Nota - {$timestamp}]: Nota dibuka kembali oleh {$userNama}. Semua stok barang telah dikembalikan ke gudang.";
            $service->catatan = $service->catatan ? $service->catatan . "\n" . $log : $log;
            $service->save();

            DB::commit();
            return response()->json(['message' => 'Nota berhasil dibuka kembali! Stok barang telah dikembalikan ke gudang dan status kembali menjadi Diproses.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Gagal membuka kembali nota: ' . $e->getMessage()], 500);
        }
    }

    public function claimWarranty(Request $request, $id) {
        $request->validate([
            'catatan_klaim' => 'required|string',
            'tanggal_garansi_baru' => 'nullable|date'
        ]);

        $service = Service::with('warranty')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Update atau buat garansi dengan status Diklaim
            if ($service->warranty) {
                $updateData = ['status' => 'Diklaim'];
                if ($request->filled('tanggal_garansi_baru')) {
                    $updateData['tanggal_selesai'] = $request->tanggal_garansi_baru;
                }
                $service->warranty->update($updateData);
            } else {
                Warranty::create([
                    'id_service' => $service->id_service,
                    'tanggal_selesai' => $request->tanggal_garansi_baru ?? now()->addDays(30),
                    'status' => 'Diklaim'
                ]);
            }

            // Tambahkan catatan riwayat klaim garansi pada service
            $timestamp = now()->format('d/m/Y H:i');
            $claimText = "[Klaim Garansi - {$timestamp}]: " . $request->catatan_klaim;
            if ($request->filled('tanggal_garansi_baru')) {
                $claimText .= " (Garansi diperpanjang s/d: {$request->tanggal_garansi_baru})";
            }
            $service->catatan = $service->catatan ? $service->catatan . "\n" . $claimText : $claimText;
            $service->save();

            DB::commit();
            return response()->json(['message' => 'Klaim garansi berhasil diproses dan dicatat dalam sistem.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Gagal memproses klaim garansi: ' . $e->getMessage()], 500);
        }
    }

    public function updateWarranty(Request $request, $id) {
        $request->validate([
            'tanggal_selesai' => 'required|date',
            'status' => 'required|in:Aktif,Selesai,Diklaim,Hangus,Habis'
        ]);

        $warranty = Warranty::where('id_service', $id)->firstOrFail();
        $warranty->update([
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Garansi berhasil diupdate']);
    }
}
