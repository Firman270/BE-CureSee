<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // 1️ pastikan email verified
        if (!$request->firebase_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Email belum diverifikasi'
            ], 401);
        }

        // 2️ cek user
        $user = User::where('email', $request->firebase_email)->first();

        // 3️ create jika belum ada
        if (!$user) {
            $user = User::create([
                'firebase_uid' => $request->firebase_uid,
                'email'        => $request->firebase_email,
                'name'         => $request->input('name', 'User'),
                'gender'       => $request->input('gender'),
                'age'          => $request->input('age'),
                'role'         => 'user',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registrasi & sinkronisasi berhasil',
            'user' => $user
        ], 201);
    }
}

