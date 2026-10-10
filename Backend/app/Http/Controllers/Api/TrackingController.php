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
        
        $service = Service::with(['kendaraan.pelanggan', 'details.sparepart', 'photos', 'warranty'])
            ->where('id_kendaraan', $kendaraan->id_kendaraan)
            ->orderBy('created_at', 'desc')
            ->first();
            
        if (!$service) {
            return response()->json(['message' => 'Tidak ada riwayat servis'], 404);
        }
        
        $service_photo = [
            'foto_before' => null,
            'foto_after' => null
        ];
        foreach($service->photos as $photo) {
            if ($photo->tipe_foto === 'Sebelum') $service_photo['foto_before'] = $photo->photo_path;
            if ($photo->tipe_foto === 'Sesudah') $service_photo['foto_after'] = $photo->photo_path;
        }
        $service->setAttribute('service_photo', $service_photo);
        
        $catatanParts = explode("\n[", $service->catatan ?? '');
        $service->setAttribute('keluhan', $catatanParts[0] ?: '-');
        
        $publicLogs = [];
        if (count($catatanParts) > 1) {
            foreach (array_slice($catatanParts, 1) as $part) {
                if (str_starts_with($part, 'Klaim Garansi')) {
                    $publicLogs[] = $part;
                }
            }
        }
        $service->setAttribute('catatan', !empty($publicLogs) ? '[' . implode("\n[", $publicLogs) : null);
        $service->setAttribute('tanggal_masuk', $service->created_at);
        
        return response()->json([
            'data' => $service
        ]);
    }
}
