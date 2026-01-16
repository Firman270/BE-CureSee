<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class FirebaseAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        Log::info("HEADER AUTH: " . $request->header('Authorization'));
        Log::info("TOKEN VIA bearerToken(): " . $token);

        if (!$token) {
            return response()->json(['error' => 'Token required'], 401);
        }

        try {
            $response = Http::post(
                'https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=' . env('FIREBASE_API_KEY'),
                ['idToken' => $token]
            );

            if (!$response->successful()) {
                return response()->json(['error' => 'Invalid or expired token'], 401);
            }

            $firebaseUser = $response->json()['users'][0] ?? null;

            if (!$firebaseUser || !isset($firebaseUser['localId'])) {
                return response()->json(['error' => 'Invalid token structure'], 401);
            }
            $emailVerified = $firebaseUser['emailVerified'] ?? false;

            if (!$emailVerified) {
                return response()->json([
                    'error' => 'Email belum diverifikasi'
                ], 403);
            }


            $firebaseUid = $firebaseUser['localId'];
            $email = $firebaseUser['email'] ?? null;

            // ✅ HANYA AMBIL USER (JANGAN CREATE)
            $user = User::where('email', $email)->first();

            // inject ke request
            $request->merge([
                'firebase_uid'      => $firebaseUid,
                'firebase_email'    => $email,
                'firebase_verified' => $emailVerified,
                'auth_user'         => $user, // boleh null
            ]);

            Log::info("🔥 Firebase lookup success", [
                'uid' => $firebaseUid,
                'email' => $email,
                'verified' => $emailVerified,
            ]);

        } catch (\Exception $e) {
            Log::error("🔥 REAL ERROR: " . $e->getMessage());
            return response()->json(['error' => 'Firebase auth failed'], 500);
        }

        return $next($request);
    }
}