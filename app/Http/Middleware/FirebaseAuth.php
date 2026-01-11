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

            $firebaseUid = $firebaseUser['localId'];
            $email = $firebaseUser['email'] ?? null;

            // ============================
            // SYNC USER FIREBASE KE DATABASE
            // ============================

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'firebase_uid' => $firebaseUid,
                    'email'        => $email,
                    'name'         => $email ?? ('User_' . substr($firebaseUid, 0, 6)),
                    'role'         => 'user',
                ]);
            } else {
                if (!$user->firebase_uid) {
                    $user->update([
                        'firebase_uid' => $firebaseUid,
                    ]);
                }
            }

            // inject ke request
            $request->merge([
                'firebase_uid' => $firebaseUid,
                'auth_user'    => $user,
            ]);

            Log::info("🔥 Firebase lookup response", [
                'status' => $response->status(),
                'body'   => $response->json()
            ]);

            Log::info("UID Extracted: " . $firebaseUid);

        } catch (\Exception $e) {
            Log::error("🔥 REAL ERROR: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return $next($request);
    }
}
