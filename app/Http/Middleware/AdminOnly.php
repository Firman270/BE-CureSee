<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        /**
         * Ambil user dari Sanctum (Bearer token)
         */
        $user = $request->user('sanctum');

        // 🔴 Token tidak valid / tidak ada
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        // 🔴 Bukan admin
        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'Forbidden. Admin only.'
            ], 403);
        }

        /**
         * Inject admin ke request (opsional tapi berguna)
         * Jadi di controller bisa pakai:
         * $admin = $request->admin;
         */
        $request->merge([
            'admin' => $user
        ]);

        return $next($request);
    }
}
