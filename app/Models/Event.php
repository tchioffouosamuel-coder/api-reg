<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['slug', 'title', 'subtitle', 'date', 'time', 'location', 'description', 'poster', 'video', 'themes', 'pricing', 'phones', 'status'];

    protected $casts = [
        'themes' => 'array',
        'pricing' => 'array',
        'phones' => 'array',
        'date' => 'date',
    ];
}
