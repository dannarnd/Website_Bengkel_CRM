<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username|alpha_dash',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,mekanik',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => strtolower($request->username),
            'email'    => strtolower($request->username) . '@doles.local', // dummy email agar kolom email tetap terisi
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return response()->json([
            'message' => 'Pegawai berhasil ditambahkan!',
            'data'    => $user
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $id . '|alpha_dash',
            'password' => 'nullable|string|min:6',
            'role'     => 'required|in:admin,mekanik',
        ]);

        $user->name     = $request->name;
        $user->username = strtolower($request->username);
        $user->email    = strtolower($request->username) . '@doles.local';
        $user->role     = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Pegawai berhasil diperbarui!',
            'data'    => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return response()->json(['message' => 'Anda tidak bisa menghapus akun Anda sendiri!'], 403);
        }

        $user->delete();
        return response()->json(['message' => 'Pegawai berhasil dihapus!']);
    }
}
