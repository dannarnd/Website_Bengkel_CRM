<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller {
    public function index() {
        return Distributor::all();
    }
    public function store(Request $request) {
        $request->validate([
            'nama_distributor' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);
        
        $last = Distributor::orderBy('id_distributor', 'desc')->first();
        if (!$last) {
            $newId = 'D001';
        } else {
            $num = (int) substr($last->id_distributor, 1);
            $newId = 'D' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        }
        
        $data = $request->all();
        $data['id_distributor'] = $newId;
        
        return response()->json(Distributor::create($data), 201);
    }
}
