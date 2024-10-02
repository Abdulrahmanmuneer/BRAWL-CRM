<?php

// app/Models/Textile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Textile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'stock', 'categories', 'description', 'price', 'seller'];
}