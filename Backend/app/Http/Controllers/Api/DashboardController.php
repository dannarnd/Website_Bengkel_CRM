<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Sparepart;
use App\Models\Pelanggan;

class DashboardController extends Controller {
    public function index() {
        return response()->json([
            'total_service' => Service::count(),
            'total_pelanggan' => Pelanggan::count(),
            'total_pendapatan' => Service::where('status', 'Selesai')->sum('total_biaya'),
            'sparepart_kritis' => Sparepart::whereRaw('stok <= batas_minimum')->get()
        ]);
    }
}
