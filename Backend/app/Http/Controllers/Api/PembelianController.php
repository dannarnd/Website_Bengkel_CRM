<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller {
    public function index() {
        return Pembelian::with(['details.sparepart', 'distributor', 'karyawan'])
            ->orderBy('tanggal_beli', 'desc')
            ->get();
    }
    public function store(Request $request) {
        $request->validate([
            'id_distributor' => 'required',
            'id_karyawan' => 'required',
            'details' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            $pembelian = Pembelian::create([
                'id_distributor' => $request->id_distributor,
                'id_karyawan' => $request->id_karyawan,
                'tanggal_beli' => now(),
                'total_bayar' => 0
            ]);

            $total = 0;
            foreach($request->details as $d) {
                $subtotal = $d['qty_masuk'] * $d['harga_beli'];
                $total += $subtotal;
                
                PembelianDetail::create([
                    'id_pembelian' => $pembelian->id_pembelian,
                    'kode_barang' => $d['kode_barang'],
                    'qty_masuk' => $d['qty_masuk'],
                    'harga_beli' => $d['harga_beli'],
                    'subtotal' => $subtotal
                ]);

                // Tambah Stok
                $sp = Sparepart::findOrFail($d['kode_barang']);
                $sp->stok += $d['qty_masuk'];
                $sp->save();
            }
            $pembelian->update(['total_bayar' => $total]);
            DB::commit();
            return response()->json($pembelian, 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
