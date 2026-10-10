<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MutasiController extends Controller {
    public function index() {
        // PEMBELIAN: Barang Masuk (SQL langsung, jauh lebih cepat dari load semua model)
        $pembelian = DB::table('pembelian_detail as pd')
            ->join('pembelian as p', 'pd.id_pembelian', '=', 'p.id_pembelian')
            ->join('sparepart as sp', 'pd.kode_barang', '=', 'sp.kode_barang')
            ->leftJoin('karyawan as k', 'p.id_karyawan', '=', 'k.id_karyawan')
            ->leftJoin('distributor as d', 'p.id_distributor', '=', 'd.id_distributor')
            ->select(
                DB::raw("CONCAT('B-', pd.id_pembelian_detail) as id"),
                'p.tanggal_beli as tanggal',
                'k.name as user_name',
                'sp.kode_barang',
                'sp.nama_barang',
                'sp.harga',
                DB::raw("'Masuk' as tipe"),
                'pd.qty_masuk as qty',
                'pd.harga_beli as harga_modal',
                DB::raw("CONCAT('Pembelian dari ', COALESCE(d.nama_distributor, 'Distributor')) as keterangan")
            )
            ->get();

        // PENJUALAN: Barang Keluar Umum
        $penjualan = DB::table('penjualan_detail as pd')
            ->join('penjualan as p', 'pd.id_penjualan', '=', 'p.id_penjualan')
            ->join('sparepart as sp', 'pd.kode_barang', '=', 'sp.kode_barang')
            ->leftJoin('karyawan as k', 'p.id_karyawan', '=', 'k.id_karyawan')
            ->select(
                DB::raw("CONCAT('J-', pd.id_penj_detail) as id"),
                'p.tanggal_penjualan as tanggal',
                'k.name as user_name',
                'sp.kode_barang',
                'sp.nama_barang',
                'sp.harga',
                DB::raw("'Keluar' as tipe"),
                'pd.qty as qty',
                DB::raw('NULL as harga_modal'),
                DB::raw("CONCAT('Penjualan Umum kepada ', p.nama_pembeli_umum) as keterangan")
            )
            ->get();

        // SERVICE: Barang Keluar untuk Servis (Hanya servis yang sudah Selesai/stok dipotong)
        $service = DB::table('service_detail as sd')
            ->join('service as s', 'sd.id_service', '=', 's.id_service')
            ->join('sparepart as sp', 'sd.kode_barang', '=', 'sp.kode_barang')
            ->leftJoin('karyawan as k', 's.id_karyawan', '=', 'k.id_karyawan')
            ->leftJoin('kendaraan as kd', 's.id_kendaraan', '=', 'kd.id_kendaraan')
            ->where('s.status', '=', 'Selesai')
            ->select(
                DB::raw("CONCAT('S-', sd.id_service_detail) as id"),
                'sd.created_at as tanggal',
                'k.name as user_name',
                'sp.kode_barang',
                'sp.nama_barang',
                'sp.harga',
                DB::raw("'Keluar' as tipe"),
                'sd.qty as qty',
                DB::raw('NULL as harga_modal'),
                DB::raw("CONCAT('Servis (', COALESCE(kd.nomor_polisi, '-'), ')') as keterangan")
            )
            ->get();

        // Format seragam
        $format = function($row, $type) {
            return [
                'id'         => $row->id,
                'tanggal'    => $row->tanggal,
                'user'       => ['name' => $row->user_name ?? 'Sistem'],
                'sparepart'  => [
                    'kode_barang' => $row->kode_barang,
                    'nama_barang' => $row->nama_barang,
                    'harga'       => $row->harga,
                ],
                'tipe'       => $row->tipe,
                'qty'        => $row->qty,
                'harga_modal'=> $row->harga_modal,
                'keterangan' => $row->keterangan,
            ];
        };

        $history = collect()
            ->concat($pembelian->map(fn($r) => $format($r, 'B')))
            ->concat($penjualan->map(fn($r) => $format($r, 'J')))
            ->concat($service->map(fn($r) => $format($r, 'S')))
            ->sortByDesc('tanggal')
            ->values();

        return response()->json($history);
    }
}
