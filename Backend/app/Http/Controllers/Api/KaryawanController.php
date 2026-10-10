<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller {
    public function index() { return Karyawan::all(); }
    public function store(Request $request) {
        $request->validate(['name' => 'required', 'username' => 'required|unique:karyawan', 'password' => 'required', 'jabatan' => 'required']);
        $karyawan = new Karyawan($request->all());
        $karyawan->password = Hash::make($request->password);
        $karyawan->save();
        return response()->json($karyawan, 201);
    }
    public function show($id) { return Karyawan::findOrFail($id); }
    public function update(Request $request, $id) {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($request->except(['password']));
        if ($request->has('password')) {
            $karyawan->password = Hash::make($request->password);
            $karyawan->save();
        }
        return response()->json($karyawan);
    }
    public function destroy($id) {
        Karyawan::destroy($id);
        return response()->json(null, 204);
    }
}
