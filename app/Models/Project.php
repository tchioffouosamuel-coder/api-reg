<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Project extends Model {
    protected $fillable = ['slug', 'name', 'tagline', 'description', 'challenge', 'solution', 'tags', 'categories', 'status', 'visibility', 'image', 'logo'];
    protected $casts = ['tags' => 'array', 'categories' => 'array'];
}
