<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function profile(Request $request)
{
    // user dari middleware
    $user = $request->auth_user;

    if (!$user) {
        return response()->json([
            'error' => 'User tidak ditemukan dari middleware',
        ], 500);
    }

    return response()->json([
        'message' => 'Success',
        'user' => $user,
    ]);
}
//UPDATE PROFILE
public function updateProfile(Request $request)
{
    /** @var \App\Models\User $user */
    $user = $request->auth_user; // ini udah di-inject dari middleware

    if (!$user) {
        return response()->json([
            'error' => 'User tidak ditemukan dari token'
        ], 500);
    }

    // VALIDASI INPUT
    $validated = $request->validate([
        'name' => 'sometimes|string|max:150',
        'gender' => 'sometimes|in:L,P',
        'age' => 'sometimes|integer|min:1|max:100',
    ]);

    // UPDATE USER
    $user->update($validated);

    return response()->json([
        'message' => 'Profile updated',
        'user' => $user
    ]);
}
//UPLOAD AVATAR PROFIL
public function uploadAvatar(Request $request)
{
    /** @var \App\Models\User $user */
    $user = $request->auth_user;

    $request->validate([
        'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
    ]);

    $file = $request->file('avatar');
    $filename = 'avatar_' . $user->user_id . '_' . time() . '.' . $file->getClientOriginalExtension();

    // Simpan file
    $path = $file->storeAs('public/avatars', $filename);

    // Buat URL public
    $url = asset('storage/avatars/' . $filename);

    // Update user
    $user->update(['avatar_url' => $url]);

    return response()->json([
        'message' => 'Avatar updated',
        'avatar_url' => $url,
        'user' => $user
    ]);
}


}
