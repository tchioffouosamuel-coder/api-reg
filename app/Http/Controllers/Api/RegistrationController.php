<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
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
