<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Service extends Model {
    protected $fillable = ['slug', 'title', 'description', 'icon', 'tags'];
    protected $casts = ['tags' => 'array'];
}
