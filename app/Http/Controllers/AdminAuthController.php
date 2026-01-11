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
<<<<<<< HEAD
        $token = $admin->createToken('admin-token')->plainTextToken;
=======
        return response()->json([
    'token' => $admin->createToken('admin-token')->plainTextToken,
    'role' => 'admin'
]);
>>>>>>> 5c6469d (push kode awal)

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
<<<<<<< HEAD
=======


>>>>>>> 5c6469d (push kode awal)
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
<<<<<<< HEAD
=======

    // LIST SEMUA USER
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

    // HAPUS USER
    public function destroy(Request $request, $id)
{
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
>>>>>>> 5c6469d (push kode awal)
}
