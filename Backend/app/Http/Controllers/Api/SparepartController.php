<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller {
    public function index() { return Sparepart::all(); }
    public function store(Request $request) {
        $request->validate(['nama_barang' => 'required', 'harga' => 'required|numeric', 'stok' => 'required|numeric', 'batas_minimum' => 'required|numeric']);
        return response()->json(Sparepart::create($request->all()), 201);
    }
    public function show($id) { return Sparepart::findOrFail($id); }
    public function update(Request $request, $id) {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->update($request->all());
        return response()->json($sparepart);
    }
    public function destroy($id) {
        Sparepart::destroy($id);
        return response()->json(null, 204);
    }
}
