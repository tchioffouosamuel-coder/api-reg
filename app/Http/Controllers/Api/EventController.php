<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return response()->json(Event::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:events',
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'description' => 'required|string',
            'poster' => 'nullable|string',
            'video' => 'nullable|string',
            'themes' => 'nullable|array',
            'pricing' => 'nullable|array',
            'phones' => 'nullable|array',
            'status' => 'required|in:a-venir,passe',
        ]);

        // Set default values for optional fields
        $validated['poster'] = $validated['poster'] ?? '';
        $validated['video'] = $validated['video'] ?? null;
        $validated['themes'] = $validated['themes'] ?? [];
        $validated['pricing'] = $validated['pricing'] ?? [];
        $validated['phones'] = $validated['phones'] ?? [];

        $event = Event::create($validated);
        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
            'status' => 'sometimes|in:a-venir,passe',
        ]);

        $event->update($validated);
        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted']);
    }
}
