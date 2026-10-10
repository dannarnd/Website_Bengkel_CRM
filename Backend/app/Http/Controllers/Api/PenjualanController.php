<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller {
    public function index() {
        return Penjualan::with(['details.sparepart', 'karyawan'])
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();
    }

    public function store(Request $request) {
        $request->validate([
            'id_karyawan' => 'required',
            'nama_pembeli_umum' => 'required',
            'details' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            // Auto generate ID Penjualan
            $last = Penjualan::orderBy('id_penjualan', 'desc')->first();
            if (!$last) {
                $newId = 'J001';
            } else {
                $num = (int) substr($last->id_penjualan, 1);
                $newId = 'J' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
            }

            $penjualan = Penjualan::create([
                'id_penjualan' => $newId,
                'id_karyawan' => $request->id_karyawan,
                'nama_pembeli_umum' => $request->nama_pembeli_umum,
                'tanggal_penjualan' => now(),
                'total_bayar' => 0
            ]);

            $total = 0;
            foreach($request->details as $d) {
                $sp = Sparepart::findOrFail($d['kode_barang']);
                if ($sp->stok < $d['qty']) {
                    throw new \Exception("Stok {$sp->nama_barang} tidak mencukupi!");
                }

                $subtotal = $d['qty'] * $sp->harga; // Harga jual
                $total += $subtotal;
                
                PenjualanDetail::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'kode_barang' => $d['kode_barang'],
                    'qty' => $d['qty'],
                    'harga_jual' => $sp->harga,
                    'subtotal' => $subtotal
                ]);

                // Kurangi stok
                $sp->stok -= $d['qty'];
                $sp->save();
            }

            $penjualan->update(['total_bayar' => $total]);
            DB::commit();
            return response()->json(['message' => 'Barang keluar berhasil dicatat', 'penjualan' => $penjualan], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
