<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class News extends Model {
    protected $fillable = ['slug', 'title', 'content', 'excerpt', 'author', 'image', 'published_at'];
    protected $casts = ['published_at' => 'datetime'];
}
