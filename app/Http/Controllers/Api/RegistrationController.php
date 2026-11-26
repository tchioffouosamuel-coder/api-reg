<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Registration::query()->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('telephone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('reference_label', 'like', "%{$search}%");
            });
        }

        return response()->json($query->get());
    }

    public function show(Registration $registration): JsonResponse
    {
        return response()->json($registration);
    }

    public function checkIn(Registration $registration): JsonResponse
    {
        $registration->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
        ]);

        return response()->json($registration);
    }

    public function destroy(Registration $registration): JsonResponse
    {
        $registration->delete();

        return response()->json(['message' => 'Registration deleted']);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:event,formation'],
            'reference_slug' => ['required', 'string', 'max:255'],
            'reference_label' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'participant_type' => ['nullable', 'string', 'max:255'],
            'amount_label' => ['nullable', 'string', 'max:255'],
        ]);

        $registration = Registration::create($validated + ['status' => 'confirmed']);

        return response()->json([
            'id' => $registration->id,
            'uuid' => $registration->uuid,
            'status' => $registration->status,
        ], 201);
    }
}
