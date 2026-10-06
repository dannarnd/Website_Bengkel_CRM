<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Pelanggan;
use App\Models\Sparepart;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalServis = Service::count();
        $totalPelanggan = Pelanggan::count();
        $totalSparepart = Sparepart::count();

        // Query khusus untuk "Alert Threshold Widget" di Frontend
        $criticalStok = Sparepart::whereColumn('stok_sekarang', '<=', 'batas_minimum')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_servis' => $totalServis,
                'total_pelanggan' => $totalPelanggan,
                'total_sparepart' => $totalSparepart,
                'critical_stok' => $criticalStok
            ]
        ]);
    }
}
