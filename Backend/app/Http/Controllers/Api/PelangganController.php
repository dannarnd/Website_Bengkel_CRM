<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return response()->json(Pelanggan::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nomor_hp' => 'required|string',
        ]);
        $pelanggan = Pelanggan::create($request->all());
        return response()->json(['status' => 'success', 'data' => $pelanggan]);
    }

    public function show($id)
    {
        return response()->json(Pelanggan::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $request->validate([
            'nama' => 'string',
            'nomor_hp' => 'string',
        ]);
        $pelanggan->update($request->all());
        return response()->json(['status' => 'success', 'data' => $pelanggan]);
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return response()->json(['status' => 'success']);
    }
}
