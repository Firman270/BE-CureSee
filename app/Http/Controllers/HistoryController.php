<?php

namespace App\Http\Controllers;

use App\Models\History;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistoryController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image',
        'label' => 'required|string',
        'confidence' => 'required|numeric'
    ]);

    $image = $request->file('image');

    $filename = hash('sha256', time() . $request->firebase_uid) . '.jpg';

    $imagePath = $image->storeAs('history', $filename, 'public');

    // TODO: BLUR IMAGE pakai Intervention Image
    $manager = new ImageManager(new Driver());

    $img = $manager->read(storage_path("app/public/$imagePath"))
                   ->blur(25)
                   ->save();

    // Simpan ke database
        $history = History::create([
            'user_id'    => $request->firebase_uid,
            'result_text'      => $request->label,
            'confidence_score' => $request->confidence,
            'image_url' => "/storage/" . $imagePath,
        ]);

    return response()->json($history);
}
public function index(Request $request)
{
    $data = History::where('user_id', $request->firebase_uid)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($data);
}
public function destroy(Request $request, $id)
{
    $item = History::where('analyses_id', $id)
        ->where('user_id', $request->firebase_uid)
        ->firstOrFail();

    Storage::disk('public')->delete(str_replace('/storage/', '', $item->image_path));

    $item->delete();

    return response()->json(['message' => 'Deleted']);
}

}