<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller {
    public function index() { return Sparepart::all(); }
    public function store(Request $request) {
        $request->validate([
            'kode_barang' => 'required|unique:sparepart',
            'nama_barang' => 'required', 
            'harga' => 'required|numeric', 
            'batas_minimum' => 'required|numeric'
        ]);
        
        $data = $request->all();
        $data['stok'] = 0; // Master barang selalu mulai dari 0

        return response()->json(Sparepart::create($data), 201);
    }
    public function show($id) { return Sparepart::findOrFail($id); }
    public function update(Request $request, $id) {
        $sparepart = Sparepart::findOrFail($id);
        
        // Mencegah perubahan stok secara manual melalui edit master barang
        $data = $request->except('stok'); 
        
        $sparepart->update($data);
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
