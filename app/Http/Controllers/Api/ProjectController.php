<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(Project::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:projects',
            'name' => 'required|string',
            'tagline' => 'required|string',
            'description' => 'required|string',
            'challenge' => 'required|string',
            'solution' => 'required|string',
            'tags' => 'sometimes|array',
            'categories' => 'sometimes|array',
            'status' => 'required|string',
            'visibility' => 'required|string',
            'image' => 'nullable|string',
            'logo' => 'nullable|string',
        ]);

        $project = Project::create($validated);
        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        return response()->json($project);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'status' => 'sometimes|string',
            'visibility' => 'sometimes|string',
        ]);

        $project->update($validated);
        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['message' => 'Project deleted']);
    }
}
