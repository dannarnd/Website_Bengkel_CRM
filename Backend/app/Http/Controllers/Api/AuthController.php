<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function login(Request $request) {
        $request->validate(['username' => 'required', 'password' => 'required']);
        $karyawan = Karyawan::where('username', $request->username)->first();
        if (!$karyawan || !Hash::check($request->password, $karyawan->password)) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }
        $token = $karyawan->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $karyawan]);
    }
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
    public function me(Request $request) {
        return response()->json($request->user());
    }
}
