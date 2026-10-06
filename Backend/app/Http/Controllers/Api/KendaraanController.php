<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        return response()->json(Kendaraan::with('pelanggan')->get());
    }

    public function store(Request $request)
    {
        // Hapus spasi dan jadikan huruf besar agar pencarian dan relasi selalu konsisten
        if ($request->has('nomor_polisi')) {
            $request->merge([
                'nomor_polisi' => strtoupper(str_replace(' ', '', $request->nomor_polisi))
            ]);
        }

        $request->validate([
            'nomor_polisi' => 'required|string|max:11|unique:kendaraan,nomor_polisi',
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'model' => 'required|string|max:50',
        ]);
        
        $kendaraan = Kendaraan::create([
            'nomor_polisi' => $request->nomor_polisi,
            'pelanggan_id' => $request->pelanggan_id,
            'model' => $request->model
        ]);

        return response()->json(['status' => 'success', 'data' => $kendaraan]);
    }

    public function show($id)
    {
        return response()->json(Kendaraan::with('pelanggan')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        
        $request->validate([
            'pelanggan_id' => 'exists:pelanggan,id',
            'model' => 'string|max:50',
        ]);
        
        $kendaraan->update($request->all());
        return response()->json(['status' => 'success', 'data' => $kendaraan]);
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->delete();
        return response()->json(['status' => 'success']);
    }
}
