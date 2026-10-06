<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServicePhoto;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    // Fetch list of services
    public function index()
    {
        $services = Service::with('kendaraan.pelanggan')->orderBy('created_at', 'desc')->get();
        return response()->json($services);
    }

    // Pendaftaran Servis Baru (Pelanggan + Service)
    public function store(Request $request)
    {
        if ($request->has('nomor_polisi')) {
            $request->merge([
                'nomor_polisi' => strtoupper(str_replace(' ', '', $request->nomor_polisi))
            ]);
        }

        $request->validate([
            'nomor_polisi' => 'required|exists:kendaraan,nomor_polisi',
            'keluhan' => 'required|string',
        ]);

        // Buat Servis
        $service = Service::create([
            'nomor_polisi' => $request->nomor_polisi,
            'user_id' => $request->user()->id,
            'keluhan' => $request->keluhan,
            'status' => 'Menunggu',
            'total_biaya' => 0,
            'tanggal_masuk' => now()->toDateString(),
        ]);

        return response()->json(['status' => 'success', 'data' => $service]);
    }

    // Detail Servis (beserta komponen lengkap)
    public function show($id)
    {
        $service = Service::with([
            'kendaraan.pelanggan',
            'serviceDetails.sparepart',
            'servicePhoto',
            'warranty'
        ])->findOrFail($id);

        return response()->json($service);
    }

    // Upload Foto Before / After
    public function uploadPhotos(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'foto_before' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,heic,heif|max:15360',
            'foto_after'  => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,heic,heif|max:15360',
        ], [
            'foto_before.mimes' => 'Format foto before tidak didukung.',
            'foto_before.max' => 'Ukuran foto before maksimal 15MB.',
            'foto_after.mimes' => 'Format foto after tidak didukung.',
            'foto_after.max' => 'Ukuran foto after maksimal 15MB.',
        ]);

        // Find existing photo record or create one
        $servicePhoto = $service->servicePhoto ?? new ServicePhoto(['service_id' => $service->id]);

        \Log::info('Upload request received', [
            'has_before' => $request->hasFile('foto_before'),
            'has_after' => $request->hasFile('foto_after'),
            'all' => $request->all()
        ]);

        if (!$servicePhoto->exists) {
            $servicePhoto->foto_before = '';
            $servicePhoto->foto_after = '';
        }

        if ($request->hasFile('foto_before')) {
            $path = $request->file('foto_before')->store('photos', 'public');
            $servicePhoto->foto_before = '/storage/' . $path;
        }

        if ($request->hasFile('foto_after')) {
            $path = $request->file('foto_after')->store('photos', 'public');
            $servicePhoto->foto_after = '/storage/' . $path;
        }

        $servicePhoto->save();

        return response()->json(['status' => 'success', 'data' => $servicePhoto]);
    }

    // Tambah Sparepart ke Servis (Bagian A)
    public function addSparepart(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'sparepart_id' => 'required|exists:sparepart,id',
            'qty' => 'required|integer|min:1'
        ]);

        $sparepart = Sparepart::findOrFail($request->sparepart_id);

        // Cek stok
        if ($sparepart->stok_sekarang < $request->qty) {
            return response()->json(['message' => 'Stok tidak mencukupi! Sisa stok: ' . $sparepart->stok_sekarang], 400);
        }

        $subtotal = $sparepart->harga * $request->qty;

        $detail = ServiceDetail::create([
            'service_id' => $service->id,
            'sparepart_id' => $sparepart->id,
            'qty' => $request->qty,
            'subtotal' => $subtotal
        ]);

        // Update Total Biaya Service
        $service->total_biaya += $subtotal;



        $service->save();

        return response()->json(['status' => 'success', 'data' => $detail]);
    }

    // Hapus detail servis jika salah input
    public function removeSparepart($id, $detailId)
    {
        $service = Service::findOrFail($id);
        $detail = ServiceDetail::where('service_id', $service->id)->findOrFail($detailId);

        // Kurangi total biaya
        $service->total_biaya -= $detail->subtotal;
        $service->save();

        $detail->delete();

        return response()->json(['status' => 'success']);
    }

    // Selesaikan Servis (Bagian C)
    public function finishService(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        if ($service->status === 'Selesai') {
            return response()->json(['message' => 'Servis ini sudah berstatus Selesai.'], 400);
        }

        $request->validate([
            'tanggal_garansi' => 'nullable|date'
        ]);

        $service->status = 'Selesai';
        $service->tanggal_selesai = now()->toDateString();
        $service->save(); // Ini akan memicu ServiceObserver yang membuat garansi 30 hari

        // Jika user menginputkan tanggal khusus, timpa tanggal bawaannya
        if ($request->filled('tanggal_garansi')) {
            $service->warranty()->update([
                'tanggal_berakhir' => $request->tanggal_garansi
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Servis berhasil diselesaikan! Stok telah dipotong dan garansi diterbitkan otomatis.']);
    }

    // Custom Endpoint: Buka Kembali Nota (Revisi)
    public function reopenService($id)
    {
        $service = Service::findOrFail($id);

        if ($service->status !== 'Selesai') {
            return response()->json(['message' => 'Hanya nota yang sudah selesai yang bisa direvisi.'], 400);
        }

        // Ini akan memicu ServiceObserver untuk melakukan restorasi stok gudang
        $service->status = 'Dikerjakan';
        $service->tanggal_selesai = null;
        
        // Tandai bahwa ini direvisi
        $newNote = "[SISTEM - " . now()->format('Y-m-d H:i') . "] Nota direvisi / dibuka kembali oleh admin.";
        $service->catatan = trim($service->catatan . "\n\n" . $newNote);
        
        $service->save();

        return response()->json([
            'status' => 'success', 
            'message' => 'Nota berhasil dibuka kembali (Revisi). Stok barang telah dikembalikan ke gudang!'
        ]);
    }

    // Custom Endpoint: Update Garansi Manual
    public function updateWarranty(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $warranty = $service->warranty;

        if (!$warranty) {
            return response()->json(['message' => 'Garansi belum terbit. Selesaikan servis terlebih dahulu.'], 400);
        }

        $request->validate([
            'tanggal_berakhir' => 'required|date',
            'status_garansi' => 'required|string'
        ]);

        $warranty->update([
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status_garansi' => $request->status_garansi
        ]);

        return response()->json(['status' => 'success', 'data' => $warranty]);
    }

    // Custom Endpoint: Update Status Servis Secara Manual (Menunggu / Dikerjakan)
    public function updateStatus(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        if ($service->status === 'Selesai') {
            return response()->json(['message' => 'Servis yang sudah selesai tidak dapat diubah statusnya.'], 400);
        }

        $request->validate([
            'status' => 'required|in:Menunggu,Dikerjakan'
        ]);

        $service->status = $request->status;
        $service->save();

        return response()->json(['status' => 'success', 'message' => 'Status servis berhasil diperbarui']);
    }

    // Custom Endpoint: Ajukan Klaim Garansi In-Place
    public function claimWarranty(Request $request, $id)
    {
        $service = Service::with('warranty')->findOrFail($id);

        if ($service->status !== 'Selesai') {
            return response()->json(['message' => 'Servis belum selesai!'], 400);
        }

        if (!$service->warranty || $service->warranty->status_garansi !== 'Aktif') {
            return response()->json(['message' => 'Garansi tidak aktif atau sudah hangus.'], 400);
        }

        $request->validate([
            'catatan_klaim' => 'required|string',
            'tanggal_garansi_baru' => 'required|date'
        ]);

        DB::transaction(function () use ($service, $request) {
            // Update Nota Servis Lama dengan catatan baru
            $newNote = "[KLAIM GARANSI - " . now()->format('Y-m-d H:i') . "]\n" . $request->catatan_klaim;
            $service->catatan = trim($service->catatan . "\n\n" . $newNote);
            $service->save();

            // Ubah tanggal garansi, biarkan status tetap Aktif agar bisa diklaim lagi kalau perlu
            $service->warranty->update([
                'tanggal_berakhir' => $request->tanggal_garansi_baru
            ]);
        });

        return response()->json([
            'status' => 'success', 
            'message' => 'Klaim Garansi Berhasil Dicatat pada Nota ini.'
        ]);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['status' => 'success', 'message' => 'Servis berhasil dihapus.']);
    }
}
