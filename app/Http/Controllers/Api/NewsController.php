<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return response()->json(News::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:news',
            'title' => 'required|string',
            'content' => 'required|string',
            'excerpt' => 'required|string',
            'author' => 'required|string',
            'image' => 'nullable|string',
            'published_at' => 'sometimes|datetime',
        ]);

        $news = News::create($validated);
        return response()->json($news, 201);
    }

    public function show(News $news)
    {
        return response()->json($news);
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'content' => 'sometimes|string',
            'excerpt' => 'sometimes|string',
            'published_at' => 'sometimes|datetime',
        ]);

        $news->update($validated);
        return response()->json($news);
    }

    public function destroy(News $news)
    {
        $news->delete();
        return response()->json(['message' => 'News deleted']);
    }
}
