<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // 1️⃣ pastikan email verified
        if (!$request->firebase_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Email belum diverifikasi'
            ], 401);
        }

        // 2️⃣ validasi input
        $validated = $request->validate([
            'name'   => 'required|string|max:100',
            'gender' => 'nullable|in:L,P',
            'age'    => 'nullable|integer|min:1|max:120',
        ]);

        // 3️⃣ cari user berdasarkan firebase_uid
        $user = User::where('firebase_uid', $request->firebase_uid)->first();

        if (!$user) {
            // 🔥 USER BARU → CREATE
            $user = User::create([
                'firebase_uid' => $request->firebase_uid,
                'email'        => $request->firebase_email,
                'name'         => $validated['name'],
                'gender'       => $validated['gender'] ?? null,
                'age'          => $validated['age'] ?? null,
                'role'         => 'user',
            ]);
        } else {
            // 🔥 USER SUDAH ADA → UPDATE DATA REGISTRASI
            $user->update([
                'name'   => $validated['name'],
                'gender' => $validated['gender'] ?? null,
                'age'    => $validated['age'] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registrasi & sinkronisasi berhasil',
            'user'    => $user
        ], 201);
    }
}
