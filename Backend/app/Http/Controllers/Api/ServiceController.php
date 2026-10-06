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
        return Service::with(['kendaraan.pelanggan', 'karyawan', 'details.sparepart', 'photos', 'warranty'])->get();
    }
    public function show($id) {
        return Service::with(['kendaraan.pelanggan', 'karyawan', 'details.sparepart', 'photos', 'warranty'])->findOrFail($id);
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
        $service = Service::findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Hapus relasi (contoh: warranty, photos, details) yang cascade nya mungkin belum diset
            if($service->warranty) $service->warranty()->delete();
            $service->photos()->delete();
            $service->details()->delete();
            
            $service->delete();
            DB::commit();
            return response()->json(['message' => 'Servis berhasil dihapus']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
