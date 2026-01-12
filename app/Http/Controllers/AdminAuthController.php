<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    // =========================
    // ADMIN LOGIN
    // =========================
    public function login(Request $request)
    {
        // email wajib diisi dan harus format email, password wajib diisi
        $request->validate([
            'email'    => 'required|email', 
            'password' => 'required|string',
        ]);
        
        // cari admin di tabel User dengan role admin
        $admin = User::where('email', $request->email)
            ->where('role', 'admin')
            ->first();

        if (!$admin) {
            return response()->json([
                'error' => 'Admin tidak ditemukan'
            ], 404);
        }

        // cek password jadi pasword dari request di bandingkan dengan kode hash dari database
        if (!Hash::check($request->password, $admin->password)) {
            return response()->json([
                'error' => 'Password salah'
            ], 401);
        }

        // buat token sebagai security
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

    // =========================
    // ADMIN LOGOUT
    // =========================
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    // =========================
    // LIST SEMUA USER
    // =========================
    public function index()
    {
        $users = User::where('role', 'user')
            ->select('id', 'name', 'email', 'gender', 'age', 'created_at')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    // =========================
    // HAPUS USER
    // =========================
    public function destroy(Request $request, $id)
    {
        /** @var User $admin */
        $admin = $request->auth_user;

        $user = User::where('role', 'user')->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        // cegah admin hapus diri sendiri
        if ($admin && $admin->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa menghapus akun sendiri'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}
