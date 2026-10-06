<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        return response()->json(Sparepart::all());
    }

    public function getNextCode($prefix)
    {
        // Cari kode_barang yang dimulai dengan prefix, lalu ambil yang memiliki kode terbesar
        $lastSparepart = Sparepart::where('kode_barang', 'like', $prefix . '%')
            ->orderBy('kode_barang', 'desc')
            ->first();

        if (!$lastSparepart) {
            // Jika belum ada barang dengan prefix tersebut, mulai dari 001
            return response()->json(['next_code' => $prefix . '001']);
        }

        // Ambil 3 angka terakhir
        $lastCode = $lastSparepart->kode_barang;
        $numberPart = substr($lastCode, strlen($prefix));
        
        // Pastikan itu angka
        if (is_numeric($numberPart)) {
            $nextNumber = intval($numberPart) + 1;
            $nextCode = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        } else {
            // Fallback jika aneh
            $nextCode = $prefix . '001';
        }

        return response()->json(['next_code' => $nextCode]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:10|unique:sparepart,kode_barang',
            'nama_barang' => 'required|string',
            'harga' => 'required|numeric',
            'stok_sekarang' => 'required|integer',
            'batas_minimum' => 'required|integer',
        ]);
        $sparepart = Sparepart::create($request->all());
        return response()->json(['status' => 'success', 'data' => $sparepart]);
    }

    public function show($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return response()->json($sparepart);
    }

    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $request->validate([
            'kode_barang' => 'string|max:10|unique:sparepart,kode_barang,'.$id,
            'nama_barang' => 'string',
            'harga' => 'numeric',
            'batas_minimum' => 'integer',
        ]);
        
        // KUNCI STOK: Ambil semua data kecuali stok_sekarang untuk update
        $data = $request->except(['stok_sekarang']);
        $sparepart->update($data);
        
        return response()->json(['status' => 'success', 'data' => $sparepart]);
    }

    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();
        return response()->json(['status' => 'success']);
    }
}
