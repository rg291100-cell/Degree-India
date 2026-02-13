<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeAccountDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'college_id',
        'account_holder_name',
        'bank_name',
        'account_number',
        'ifsc_code',
        'branch_name',
        'account_type',
        'micr_code',
        'upi_id',
        'qr_code_path',
        'registered_mobile',
    ];

    protected $casts = [
        'account_type' => 'string',
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }
}