<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index()
    {
        return response()->json(Formation::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:formations',
            'title' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'category' => 'required|string',
            'image' => 'nullable|string',
        ]);

        $formation = Formation::create($validated);
        return response()->json($formation, 201);
    }

    public function show(Formation $formation)
    {
        return response()->json($formation);
    }

    public function update(Request $request, Formation $formation)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'capacity' => 'sometimes|integer',
        ]);

        $formation->update($validated);
        return response()->json($formation);
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();
        return response()->json(['message' => 'Formation deleted']);
    }
}
