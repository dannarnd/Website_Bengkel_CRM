<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\Service;

class TrackingController extends Controller {
    public function track(Request $request) {
        $request->validate([
            'nomor_polisi' => 'required',
            'nomor_hp' => 'required'
        ]);
        
        $nopol = strtoupper($request->nomor_polisi);
        $nohp = $request->nomor_hp;
        
        $kendaraan = Kendaraan::with('pelanggan')->where('nomor_polisi', $nopol)->first();
        if (!$kendaraan) {
            return response()->json(['message' => 'Kendaraan tidak ditemukan'], 404);
        }
        
        $hp_pelanggan = $kendaraan->pelanggan->nomor_hp;
        if (substr($hp_pelanggan, -4) !== $nohp) {
            return response()->json(['message' => '4 digit terakhir nomor HP tidak cocok'], 401);
        }
        
        $service = Service::with(['details.sparepart', 'photos', 'warranty'])
            ->where('id_kendaraan', $kendaraan->id_kendaraan)
            ->orderBy('created_at', 'desc')
            ->first();
            
        if (!$service) {
            return response()->json(['message' => 'Tidak ada riwayat servis'], 404);
        }
        
        return response()->json([
            'pelanggan' => $kendaraan->pelanggan,
            'kendaraan' => $kendaraan,
            'service' => $service
        ]);
    }
}
