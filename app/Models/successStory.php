<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class successStory extends Model
{
    use HasFactory;
    protected $fillable = ['title','path','author','description'];
    protected $table = 'successStory';
}
