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
Log::info("TOKEN VIA bearerToken(): " . $request->bearerToken());


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

        // cek user
        $user = User::firstOrCreate(
    ['firebase_uid' => $firebaseUid], // cari berdasarkan UID
    [
        'name' => $email ?? 'User_' . substr($firebaseUid, 0, 6),
        'email' => $email,
    ]
);

        // simpan ke request
        $request->merge([
            'firebase_uid' => $firebaseUid,
            'auth_user' => $user
        ]);

        // ===== pindahin logging ke dalam try =====

        Log::info("🔥 Firebase lookup response", [
            'status' => $response->status(),
            'body' => $response->json()
        ]);

        Log::info("UID Extracted in try: " . $firebaseUid);

    } catch (\Exception $e) {
    Log::error("🔥 REAL ERROR: " . $e->getMessage());
    return response()->json(['error' => $e->getMessage()], 500);
}

    return $next($request);
}

}
