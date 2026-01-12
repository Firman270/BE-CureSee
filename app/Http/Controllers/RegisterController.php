<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class RegisterController extends Controller
{
    //
}

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

        $request->validate([
            'name'   => 'required|string|max:100',
            'gender' => 'nullable|in:L,P',
            'age'    => 'nullable|integer|min:1|max:120',
        ]);

        // 2️ cek user
        //$user = User::where('email', $request->firebase_email)->first();
        $user = User::where('firebase_uid', $request->firebase_uid)->first();
        // 3️ create jika belum ada
        // if (!$user) {
        //     $user = User::create([
        //         'firebase_uid' => $request->firebase_uid,
        //         'email'        => $request->firebase_email,
        //         'name'         => $request->input('name', 'User'),
        //         'gender'       => $request->input('gender'),
        //         'age'          => $request->input('age'),
        //         'role'         => 'user',
        //     ]);
        // }
        if (!$user) {
    $user = User::create([
        'firebase_uid' => $request->firebase_uid,
        'email'        => $request->firebase_email,
        'name'         => $request->input('name') ?? 'User',
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

