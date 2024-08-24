<?php

namespace App\Models;

use App\Models\Dept;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'schemeid',
        'name',
        'description',
        'website',
        'dept_id'
    ];

    protected $primaryKey = 'schemeid';

    public function dept()
    {
        return $this->belongsTo(Dept::class);
    }
    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'scheme_user', 'schemeid', 'user_id')
            ->withPivot('info')
            ->withTimestamps();;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'scheme_category', 'scheme_id', 'category_id');
    }
}
