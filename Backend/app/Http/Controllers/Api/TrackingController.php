<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Kendaraan;
use App\Models\Pelanggan;

class TrackingController extends Controller
{
    public function trackService(Request $request)
    {
        $request->validate([
            'nomor_polisi' => 'required|string',
            'nomor_hp' => 'required|string', // 4 digit terakhir
        ]);

        // Bersihkan spasi dan jadikan huruf besar agar pencarian akurat
        $nomor_polisi = str_replace(' ', '', strtoupper($request->nomor_polisi));
        
        // Cari kendaraan berdasarkan plat nomor, dan pastikan pemiliknya memiliki akhiran no hp yang cocok
        $kendaraan = Kendaraan::whereRaw("REPLACE(UPPER(nomor_polisi), ' ', '') = ?", [$nomor_polisi])
            ->whereHas('pelanggan', function($query) use ($request) {
                $query->where('nomor_hp', 'LIKE', '%' . $request->nomor_hp);
            })
            ->first();

        if (!$kendaraan) {
            return response()->json(['message' => 'Data kendaraan tidak ditemukan atau 4 digit Nomor HP tidak cocok.'], 404);
        }

        // Ambil riwayat servis terbaru untuk kendaraan ini
        $service = Service::where('nomor_polisi', $kendaraan->nomor_polisi)
            ->with(['kendaraan.pelanggan', 'serviceDetails.sparepart', 'servicePhoto', 'warranty'])
            ->latest()
            ->first();

        if (!$service) {
            return response()->json(['message' => 'Belum ada riwayat servis untuk kendaraan ini.'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $service]);
    }
}
