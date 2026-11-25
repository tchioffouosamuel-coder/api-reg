<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Registration extends Model
{
    protected $fillable = [
        'uuid',
        'type',
        'reference_slug',
        'reference_label',
        'nom',
        'telephone',
        'email',
        'participant_type',
        'amount_label',
        'status',
        'checked_in_at',
        'attestation_generated_at',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'attestation_generated_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Registration $registration) {
            $registration->uuid ??= (string) Str::uuid();
            $registration->status ??= 'pending';
        });
    }
}
