<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'course_id',
        'total_fees',
        'paid_amount',
        'due_amount',
        'payment_mode',
        'payment_status',
        'admission_status',
        'remarks',
        'admission_date',
        'payment_date',
        'transaction_id',
        'is_notified'
    ];

    protected $casts = [
        'admission_date' => 'date',
        'payment_date' => 'date',
        'total_fees' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'is_notified' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function feePayments()
    {
        return $this->hasMany(AdmissionFeePayment::class);
    }

    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'pending' => 'badge-warning',
            'approved' => 'badge-info',
            'rejected' => 'badge-danger',
            'completed' => 'badge-success'
        ];

        return $statuses[$this->admission_status] ?? 'badge-secondary';
    }

    public function getPaymentStatusBadgeAttribute()
    {
        $statuses = [
            'pending' => 'badge-warning',
            'partially_paid' => 'badge-info',
            'paid' => 'badge-success'
        ];

        return $statuses[$this->payment_status] ?? 'badge-secondary';
    }
}