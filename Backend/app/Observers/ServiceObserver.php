<?php

namespace App\Observers;

use App\Models\Service;
use App\Models\StockAdjustment;
use App\Models\Warranty;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ServiceObserver
{
    /**
     * Handle the Service "updated" event.
     * Logika Otomasi (Smart Triggers) dieksekusi di sini agar controller tetap bersih.
     */
    public function updated(Service $service): void
    {
        // Pengecekan: Apakah status baru saja diubah menjadi 'Selesai'?
        if ($service->isDirty('status') && $service->status === 'Selesai') {
            
            // 1. SMART TRIGGER: Auto-Cut Stock
            foreach ($service->serviceDetails as $detail) {
                $sparepart = $detail->sparepart;
                
                if ($sparepart) {
                    // Kurangi stok barang
                    $sparepart->stok_sekarang -= $detail->qty;
                    $sparepart->save();

                    // Buat Audit Trail (Riwayat Keluar Barang)
                    StockAdjustment::create([
                        'user_id'      => $service->user_id,
                        'sparepart_id' => $sparepart->id,
                        'qty'          => $detail->qty,
                        'tipe'         => 'Keluar',
                        'keterangan'   => 'Servis Selesai - Kendaraan: ' . $service->nomor_polisi . ' (Nota #' . $service->id . ')',
                        'tanggal'      => now(),
                    ]);

                    // SMART TRIGGER: Warning Threshold
                    if ($sparepart->stok_sekarang <= $sparepart->batas_minimum) {
                        // Mencatat peringatan di log sistem. Pada aplikasi nyata, bisa memicu pengiriman Email/WhatsApp ke Admin.
                        Log::warning("PERINGATAN STOK KRITIS: {$sparepart->nama_barang} tersisa {$sparepart->stok_sekarang} unit. Segera restock!");
                    }
                }
            }

            // 2. SMART TRIGGER: Auto-Warranty
            // Mengecek apakah garansi belum terbit, agar tidak double
            if (!$service->warranty) {
                Warranty::create([
                    'service_id'       => $service->id,
                    'tanggal_mulai'    => Carbon::now()->toDateString(),
                    'tanggal_berakhir' => Carbon::now()->addDays(30)->toDateString(),
                    'status_garansi'   => 'Aktif',
                ]);
            }
        }

        // Pengecekan: Apakah status direvisi dari 'Selesai' kembali ke 'Dikerjakan'?
        if ($service->isDirty('status') && $service->getOriginal('status') === 'Selesai' && $service->status === 'Dikerjakan') {
            
            // SMART TRIGGER: Auto-Restore Stock
            foreach ($service->serviceDetails as $detail) {
                $sparepart = $detail->sparepart;
                
                if ($sparepart) {
                    // Kembalikan stok barang
                    $sparepart->stok_sekarang += $detail->qty;
                    $sparepart->save();

                    // Buat Audit Trail (Riwayat Masuk Barang)
                    StockAdjustment::create([
                        'user_id'      => $service->user_id,
                        'sparepart_id' => $sparepart->id,
                        'qty'          => $detail->qty,
                        'tipe'         => 'Masuk',
                        'keterangan'   => 'Retur Revisi Nota - Kendaraan: ' . $service->nomor_polisi . ' (Nota #' . $service->id . ')',
                        'tanggal'      => now(),
                    ]);
                }
            }
            
            // Menghapus garansi yang sudah terbit, karena nota dibuka lagi
            // Nanti garansi akan diterbitkan ulang saat diselesaikan lagi
            if ($service->warranty) {
                $service->warranty->delete();
            }
        }
    }
}
