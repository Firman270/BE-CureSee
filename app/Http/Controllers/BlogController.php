<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    // LIST BLOG
    public function tampil()
    {
        return response()->json(
            Blog::with('admin')->latest()->get()
        );
    }

    // CREATE BLOG (ADMIN)
    public function tambah(Request $request)
    {
        $admin = $request->user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|string',
        ]);

        $blog = Blog::create([
            'admin_id' => $admin->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image' => $validated['image'] ?? null,
        ]);

        return response()->json([
            'message' => 'Blog created',
            'blog' => $blog
        ], 201);
    }

    // UPDATE BLOG
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'image' => 'nullable|string',
        ]);

        $blog->update($validated);

        return response()->json([
            'message' => 'Blog updated',
            'blog' => $blog
        ]);
    }

    // DELETE BLOG
    public function hapus($id)
    {
        Blog::destroy($id);

        return response()->json([
            'message' => 'Blog deleted'
        ]);
    }
}
