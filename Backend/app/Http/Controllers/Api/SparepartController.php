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
    
    public function generateNextCode($prefix) {
        // Cari kode terakhir yang diawali dengan $prefix
        $lastSparepart = Sparepart::where('kode_barang', 'like', $prefix . '%')
            ->orderBy('kode_barang', 'desc')
            ->first();
            
        if (!$lastSparepart) {
            $nextCode = $prefix . '001';
        } else {
            // Ambil 3 angka terakhir
            $lastNumber = (int) substr($lastSparepart->kode_barang, strlen($prefix));
            $nextNumber = $lastNumber + 1;
            $nextCode = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }
        
        return response()->json(['next_code' => $nextCode]);
    }
}
