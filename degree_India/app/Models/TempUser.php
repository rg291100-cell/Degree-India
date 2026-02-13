<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempUser extends Model
{
    protected $fillable = [
        'session_id',
        'location',
        'name',
        'email',
        'phone',
        'password',
        'gender',
        'dob',
        
        'education_level',
        'career_interest',
        'profile_picture',
        'otp',
        'otp_expires_at',
        'otp_verified',
        'completed_steps'
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime'
    ];
}