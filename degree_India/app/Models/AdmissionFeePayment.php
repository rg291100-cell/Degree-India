<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionFeePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        'amount',
        'payment_mode',
        'transaction_id',
        'payment_date',
        'receipt_number',
        'remarks',
        'proof_document',
        'collected_by'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collected_by');
    }
}