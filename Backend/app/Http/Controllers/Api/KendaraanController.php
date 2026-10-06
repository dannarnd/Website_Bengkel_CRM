<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller {
    public function index() { return Kendaraan::with('pelanggan')->get(); }
    public function store(Request $request) {
        $request->validate(['id_pelanggan' => 'required', 'nomor_polisi' => 'required|unique:kendaraan', 'merk_mobil' => 'required']);
        return response()->json(Kendaraan::create($request->all()), 201);
    }
    public function show($id) { return Kendaraan::with('pelanggan')->findOrFail($id); }
    public function update(Request $request, $id) {
        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->update($request->all());
        return response()->json($kendaraan);
    }
    public function destroy($id) {
        Kendaraan::destroy($id);
        return response()->json(null, 204);
    }
}
