<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefits extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheme_id',
        'dept_id',
        'beneficiary_id',
        'jan_amount',
        'feb_amount',
        'mar_amount',
        'apr_amount',
        'may_amount',
        'jun_amount',
        'jul_amount',
        'aug_amount',
        'sep_amount',
        'oct_amount',
        'nov_amount',
        'dec_amount',
        'yearly_total',
        'fy_from',
        'fy_to',
        'last_transaction_date',
        'uploaded_by',
    ];

    /**
     * Calculate the yearly total automatically when setting monthly amounts
     */
    public function setYearlyTotalAttribute()
    {
        $this->attributes['yearly_total'] =
            $this->jan_amount + $this->feb_amount + $this->mar_amount +
            $this->apr_amount + $this->may_amount + $this->jun_amount +
            $this->jul_amount + $this->aug_amount + $this->sep_amount +
            $this->oct_amount + $this->nov_amount + $this->dec_amount;
    }

    /**
     * Define relationships
     */
    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }

    public function department()
    {
        return $this->belongsTo(Dept::class, 'dept_id');
    }

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
