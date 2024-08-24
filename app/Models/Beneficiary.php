<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'dob',
        'gender',
        'scheme_id',
        'dept_id',
        'aadhar_num',
        'mobile_num',
        'email_id',
        'scheme_specific_id',
        'scheme_specific_family_number',
        'home_address',
        'village_code',
        'village_name',
        'panchayat_code',
        'block_name',
        'block_code',
        'district_code',
        'district_name',
        'state_code',
        'state_name',
        'pincode',
        'ration_card_num',
        'tin_family_id',
        'active',
        'lastPaid',
        // 'created_at', 'updated_at' are generally handled automatically by Eloquent
    ];

    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    public function benefits(){
        return $this->hasMany(Benefits::class, 'beneficiary_id');
    }
}
