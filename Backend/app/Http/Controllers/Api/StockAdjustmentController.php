<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;

class StockAdjustmentController extends Controller
{
    /**
     * Mengambil riwayat mutasi stok
     */
    public function index()
    {
        $adjustments = StockAdjustment::with(['sparepart', 'user'])
                        ->orderBy('tanggal', 'desc')
                        ->get();
        return response()->json($adjustments);
    }

    /**
     * Menyimpan data barang keluar secara manual (Pembelian Langsung)
     */
    public function storeBarangKeluar(Request $request)
    {
        $request->validate([
            'sparepart_id' => 'required|exists:sparepart,id',
            'qty'          => 'required|integer|min:1',
            'keterangan'   => 'required|string',
        ]);

        $sparepart = Sparepart::findOrFail($request->sparepart_id);

        if ($sparepart->stok_sekarang < $request->qty) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal: Stok tidak mencukupi untuk dikeluarkan!'
            ], 400);
        }

        // Kurangi stok manual (Non-Service)
        $sparepart->stok_sekarang -= $request->qty;
        $sparepart->save();

        // Catat riwayat audit
        $adjustment = StockAdjustment::create([
            'sparepart_id' => $sparepart->id,
            'user_id'      => $request->user()->id,
            'qty'          => $request->qty,
            'tipe'         => 'Keluar',
            'keterangan'   => $request->keterangan,
            'tanggal'      => now(),
        ]);

        // Pengecekan Warning Threshold
        $isCritical = false;
        if ($sparepart->stok_sekarang <= $sparepart->batas_minimum) {
            $isCritical = true;
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Stok berhasil dikeluarkan/dibeli langsung.',
            'data'    => $adjustment,
            // Jika status kritis, sertakan pesan peringatan
            'alert'   => $isCritical ? "PERINGATAN STOK KRITIS! Sisa {$sparepart->nama_barang} tinggal {$sparepart->stok_sekarang} unit." : null
        ]);
    }

    /**
     * Menyimpan data barang masuk secara manual (Restock)
     */
    public function storeBarangMasuk(Request $request)
    {
        $request->validate([
            'items'        => 'required|json',
            'keterangan'   => 'required|string',
            'bukti_foto'   => 'nullable|file|max:15360', // Maksimal 15MB, jenis file dibebaskan agar HEIC/iPhone bisa masuk
        ]);

        $items = json_decode($request->items, true);

        if (!is_array($items) || count($items) === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Daftar barang tidak valid atau kosong.'
            ], 400);
        }

        // Validasi struktur tiap item di dalam array
        foreach ($items as $item) {
            if (!isset($item['sparepart_id']) || !isset($item['qty']) || !isset($item['harga_modal'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pastikan semua baris item memiliki Sparepart, Qty, dan Harga Modal yang terisi.'
                ], 400);
            }
        }

        // Handle Upload Foto (1 foto untuk semua item dalam 1 batch)
        $buktiPath = null;
        if ($request->hasFile('bukti_foto')) {
            $buktiPath = $request->file('bukti_foto')->store('bukti_stok', 'public');
        }

        $userId = $request->user()->id;
        $tanggal = now();
        $savedAdjustments = [];

        // Lakukan looping untuk menambah stok dan mencatat riwayat
        foreach ($items as $item) {
            $sparepart = Sparepart::findOrFail($item['sparepart_id']);
            
            // Tambah stok manual
            $sparepart->stok_sekarang += $item['qty'];
            $sparepart->save();

            // Catat riwayat audit
            $adjustment = StockAdjustment::create([
                'sparepart_id' => $sparepart->id,
                'user_id'      => $userId,
                'qty'          => $item['qty'],
                'tipe'         => 'Masuk',
                'keterangan'   => $request->keterangan,
                'harga_modal'  => $item['harga_modal'],
                'tanggal'      => $tanggal,
                'bukti_foto'   => $buktiPath,
            ]);

            $savedAdjustments[] = $adjustment;
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil menambahkan ' . count($items) . ' jenis barang ke stok.',
            'data'    => $savedAdjustments
        ]);
    }
}

