<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // GET PROFILE
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
        ]);
    }


    // UPDATE PROFILE
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = $request->auth_user;

        if (!$user) {
            return response()->json([
                'error' => 'Pengguna tidak ditemukan dari token'
            ], 500);
        }

        // VALIDASI INPUT
    $validated = $request->validate([
        'name' => 'sometimes|string|max:150',
        'gender' => 'sometimes|in:L,P',
        'age' => 'sometimes|integer|min:1|max:100',
    ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated',
            'user'    => $user
        ]);
    }

    
}
    {
        return $this->role === 'user';
    }
