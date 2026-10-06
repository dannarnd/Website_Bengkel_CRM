<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Sparepart;
use App\Models\Pelanggan;

class DashboardController extends Controller {
    public function index() {
        return response()->json([
            'data' => [
                'total_servis' => Service::count(),
                'total_pelanggan' => Pelanggan::count(),
                'total_sparepart' => Sparepart::count(),
                'critical_stok' => Sparepart::whereRaw('stok <= batas_minimum')->select('nama_barang', 'stok as stok_sekarang', 'batas_minimum')->get()
            ]
        ]);
    }
}
