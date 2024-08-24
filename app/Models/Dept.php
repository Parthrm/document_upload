<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dept extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'logo', 'website', 'type', 'email'
    ];
    
}
