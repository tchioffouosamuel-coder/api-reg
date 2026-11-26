<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Formation extends Model {
    protected $fillable = ['slug', 'title', 'description', 'start_date', 'end_date', 'price', 'capacity', 'category', 'image'];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date', 'price' => 'decimal:2'];
}
