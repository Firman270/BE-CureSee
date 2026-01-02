<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SkinAnalysis;
use Illuminate\Support\Facades\Storage;

class SkinAnalysisController extends Controller
{
    // UPLOAD & CREATE ANALYSIS
    public function store(Request $request)
    {
        $user = $request->auth_user; // dari firebase-auth middleware

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // simpan file
        $path = $validated['image']->store(
            'skin-analyses',
            'public'
        );

        $analysis = SkinAnalysis::create([
            'user_id' => $user->id,
            'image_url' => asset('storage/' . $path),

            // sementara dummy
            'result_text' => 'Analysis in progress',
            'confidence_score' => null,
            'disease_id' => null,
        ]);

        return response()->json([
            'message' => 'Skin analysis created',
            'data' => $analysis
        ], 201);
    }

    // HISTORY USER
    public function history(Request $request)
    {
        $user = $request->auth_user;

        $data = SkinAnalysis::where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    // DETAIL ANALYSIS
    public function show($id)
    {
        $analysis = SkinAnalysis::with('disease')
            ->findOrFail($id);

        return response()->json([
            'data' => $analysis
        ]);
    }
}
