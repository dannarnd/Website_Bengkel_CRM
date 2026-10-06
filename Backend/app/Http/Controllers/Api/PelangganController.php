<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller {
    public function index() { return Pelanggan::all(); }
    public function store(Request $request) {
        $request->validate(['nama_pelanggan' => 'required', 'nomor_hp' => 'required']);
        return response()->json(Pelanggan::create($request->all()), 201);
    }
    public function show($id) { return Pelanggan::findOrFail($id); }
    public function update(Request $request, $id) {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());
        return response()->json($pelanggan);
    }
    public function destroy($id) {
        Pelanggan::destroy($id);
        return response()->json(null, 204);
    }
}
