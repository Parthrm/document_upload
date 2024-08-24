<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function schemes()
    {
        return $this->belongsToMany(Scheme::class, 'scheme_category', 'category_id', 'scheme_id');
    }

}
