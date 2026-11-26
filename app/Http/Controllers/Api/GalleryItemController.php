<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryItemController extends Controller
{
    public function index()
    {
        return response()->json(GalleryItem::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|string',
            'type' => 'required|in:image,video',
            'thumbnail' => 'nullable|string',
        ]);

        $item = GalleryItem::create($validated);
        return response()->json($item, 201);
    }

    public function show(GalleryItem $galleryItem)
    {
        return response()->json($galleryItem);
    }

    public function update(Request $request, GalleryItem $galleryItem)
    {
        $validated = $request->validate([
            'url' => 'sometimes|string',
            'type' => 'sometimes|in:image,video',
            'thumbnail' => 'nullable|string',
        ]);

        $galleryItem->update($validated);
        return response()->json($galleryItem);
    }

    public function destroy(GalleryItem $galleryItem)
    {
        $galleryItem->delete();
        return response()->json(['message' => 'Gallery item deleted']);
    }
}
