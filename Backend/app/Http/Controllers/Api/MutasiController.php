<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembelianDetail;
use App\Models\PenjualanDetail;
use App\Models\ServiceDetail;

class MutasiController extends Controller {
    public function index() {
        // Gabungkan Pembelian (Masuk)
        $pembelian = PembelianDetail::with(['pembelian.karyawan', 'pembelian.distributor', 'sparepart'])->get()->map(function($d) {
            return [
                'id' => 'B-' . $d->id_pembelian_detail,
                'tanggal' => $d->pembelian->tanggal_beli,
                'user' => ['name' => $d->pembelian->karyawan->name ?? 'Sistem'],
                'sparepart' => $d->sparepart,
                'tipe' => 'Masuk',
                'qty' => $d->qty_masuk,
                'harga_modal' => $d->harga_beli,
                'bukti_foto' => null, // Sudah dihapus fiturnya
                'keterangan' => 'Pembelian dari ' . ($d->pembelian->distributor->nama_distributor ?? 'Distributor')
            ];
        });

        // Gabungkan Penjualan Umum (Keluar)
        $penjualan = PenjualanDetail::with(['penjualan.karyawan', 'sparepart'])->get()->map(function($d) {
            return [
                'id' => 'J-' . $d->id_penj_detail,
                'tanggal' => $d->penjualan->tanggal_penjualan,
                'user' => ['name' => $d->penjualan->karyawan->name ?? 'Sistem'],
                'sparepart' => $d->sparepart,
                'tipe' => 'Keluar',
                'qty' => $d->qty,
                'harga_modal' => null, // Sembunyikan harga jual/modal di mutasi
                'bukti_foto' => null,
                'keterangan' => 'Penjualan Umum kepada ' . $d->penjualan->nama_pembeli_umum
            ];
        });

        // Gabungkan Service (Keluar)
        $service = ServiceDetail::with(['service.karyawan', 'service.kendaraan.pelanggan', 'sparepart'])->get()->map(function($d) {
            return [
                'id' => 'S-' . $d->id_service_detail,
                'tanggal' => $d->created_at,
                'user' => ['name' => $d->service->karyawan->name ?? 'Sistem'],
                'sparepart' => $d->sparepart,
                'tipe' => 'Keluar',
                'qty' => $d->qty,
                'harga_modal' => null,
                'bukti_foto' => null,
                'keterangan' => 'Servis (' . ($d->service->kendaraan->nomor_polisi ?? '-') . ')'
            ];
        });

        // Merge all and sort by date descending
        $history = collect()->concat($pembelian)->concat($penjualan)->concat($service)
            ->sortByDesc('tanggal')->values();

        return response()->json($history);
    }
}
