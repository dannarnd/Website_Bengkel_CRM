<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller {
    public function index() { return Pelanggan::all(); }
    public function store(Request $request) {
        $request->validate(['nama_pelanggan' => 'required', 'nomor_hp' => 'required']);
        
        $last = Pelanggan::orderBy('id_pelanggan', 'desc')->first();
        if (!$last) {
            $newId = 'PL001';
        } else {
            $num = (int) substr($last->id_pelanggan, 2);
            $newId = 'PL' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        }
        
        $data = $request->all();
        $data['id_pelanggan'] = $newId;
        
        return response()->json(Pelanggan::create($data), 201);
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
