<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // LIST BLOG
    public function tampil()
{
    return response()->json(Blog::latest()->get());
}
 public function tampilUser()
{
    return response()->json(Blog::latest()->get());
}
 
public function tambah(Request $request)
{
    Log::info('BLOG CREATE PAYLOAD', [
    'fields' => $request->except('image'),
    'image_is_sent' => $request->hasFile('image'),
    'image_file_info' => $request->hasFile('image')
        ? [
            'original_name' => $request->file('image')->getClientOriginalName(),
            'mime' => $request->file('image')->getClientMimeType(),
            'size' => $request->file('image')->getSize(),
        ]
        : 'NO FILE RECEIVED',
    'content_type' => $request->header('Content-Type'),
]);


    $admin = $request->user('sanctum');

    $validated = $request->validate([
        'title' => 'required|string',
        'content' => 'nullable|string',
        'description' => 'nullable|string',
        'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
    ]);

    $content = $validated['content'] ?? $validated['description'] ?? null;

    if (!$content) {
        return response()->json([
            'message' => 'Validation error',
            'errors' => [
                'content' => ['content/description wajib diisi']
            ]
        ], 422);
    }

    if (!$request->hasFile('image')) {
        return response()->json([
            'message' => 'Validation error',
            'errors' => [
                'image' => ['image wajib dikirim sebagai file']
            ]
        ], 422);
    }

    $path = $request->file('image')->store('blogs', 'public');

    $blog = \App\Models\Blog::create([
        'admin_id' => $admin->id,
        'title' => $validated['title'],
        'content' => $content,
        'image' => $path,
    ]);

    return response()->json([
        'message' => 'Blog created',
        'blog' => $blog
    ], 201);
}


 public function update(Request $request, $id)
    {
        // Ambil data blog
        $blog = Blog::findOrFail($id);

        // Validasi (PATCH = pakai "sometimes")
        $validated = $request->validate([
            'title'   => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'image'   => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika ada image baru → hapus image lama
        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('blogs', 'public');
        }

        // Update data
        $blog->update($validated);
info('BLOG BEFORE UPDATE', $blog->toArray());
info('VALIDATED DATA', $validated);

$updated = $blog->update($validated);

info('UPDATE RETURNED', ['result' => $updated]);
info('BLOG AFTER UPDATE (MODEL)', $blog->toArray());
info('BLOG AFTER UPDATE (FRESH FROM DB)', Blog::find($id)->toArray());

        // Response
        return response()->json([
            'message' => 'Blog updated successfully',
            'blog' => $blog->fresh(),
        ]);
    }



public function hapus($id)
{
    Blog::destroy($id);

    return response()->json([
        'message' => 'Blog deleted'
    ]);
}
}
