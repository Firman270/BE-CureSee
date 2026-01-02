<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        // validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // cari user admin
        $admin = User::where('email', $request->email)
            ->where('role', 'admin')
            ->first();

        if (!$admin) {
            return response()->json([
                'error' => 'Admin tidak ditemukan'
            ], 404);
        }

        // cek password
        if (!Hash::check($request->password, $admin->password)) {
            return response()->json([
                'error' => 'Password salah'
            ], 401);
        }

        // buat token
        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Login admin berhasil',
            'token'   => $token,
            'user'    => [
                'id'    => $admin->id,
                'email' => $admin->email,
                'name'  => $admin->name,
                'role'  => $admin->role,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}
