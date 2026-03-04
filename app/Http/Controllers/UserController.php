<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // ===============================
    // GET PROFILE
    // ===============================
    public function profile(Request $request)
    {
        /** @var User $user */
        $user = $request->auth_user;

        if (!$user) {
            return response()->json([
                'error' => 'User tidak ditemukan dari middleware',
            ], 500);
        }

        return response()->json([
            'id'         => $user->id,
            'email'      => $user->email,
            'name'       => $user->name,
            'role'       => $user->role,
            'gender'     => $user->gender,
            'age'        => $user->age,
            'avatar_url'=> $user->avatar_url,
        ]);
    }

    // ===============================
    // UPDATE PROFILE
    // ===============================
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = $request->auth_user;

        if (!$user) {
            return response()->json([
                'error' => 'User tidak ditemukan dari token'
            ], 500);
        }

        // VALIDASI INPUT
        $validated = $request->validate([
            'name'   => 'sometimes|string|max:150',
            'gender' => 'sometimes|in:L,P',
            'age'    => 'sometimes|integer|min:1|max:100',
        ]);

        // UPDATE USER
        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated',
            'user' => $user
        ]);
    }

    // ===============================
    // UPLOAD AVATAR
    // ===============================
    public function uploadAvatar(Request $request)
    {
        /** @var User $user */
        $user = $request->auth_user;

        if (!$user) {
            return response()->json([
                'error' => 'User tidak ditemukan dari token'
            ], 401);
        }

        // VALIDASI FILE
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('avatar');

        // 🔥 PAKAI $user->id (BUKAN user_id)
        $filename = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        // SIMPAN KE storage/app/public/avatars
        $file->storeAs('public/avatars', $filename);

        // URL PUBLIK
        $url = asset('storage/avatars/' . $filename);

        // SIMPAN KE DATABASE
        $user->update([
            'avatar_url' => $url
        ]);

        return response()->json([
            'message' => 'Avatar updated',
            'avatar_url' => $url,
            'user' => $user
        ]);
    }
}