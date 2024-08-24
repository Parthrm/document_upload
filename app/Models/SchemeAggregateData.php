<?php

namespace App\Models;

use App\Models\Dept;
use App\Models\Scheme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchemeAggregateData extends Model
{
    use HasFactory;
    protected $table;
    public $timestamps = true;    
    
    protected $fillable = [
        'scheme_id',
        'benefit_type',
        'dept_id',
        'scheme_grouping',
        'type',
        'date_from',
        'date_to',
        'fy_from',
        'fy_to',
        'total_no_of_beneficiaries',
        'total_no_of_beneficiaries_centre_state',
        'total_no_of_beneficiaries_state',
        'total_no_of_beneficiaries_with_bank_ac',
        'total_no_of_beneficiaries_with_aadhar',
        'total_no_of_beneficiaries_with_seeded_bank_ac',
        'total_no_of_beneficiaries_digitized',
        'total_no_of_beneficiaries_with_mobile_no',
        'total_ghost_beneficiaries',
        'total_duplicate_beneficiaries',
        'total_other_beneficiaries',
        'month_status',
        'data_awaited',
        'data_not_applicable',
        'updated_at',
        'created_at',
    ];
    
    public function dept()
    {
        return $this->belongsTo(Dept::class, 'dept_id');
    }

    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }
}
