<?php
// app/Models/RegisterContect.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterContect extends Model
{
    use HasFactory;
    
    protected $table = 'register_contects';
    
    protected $fillable = [
        'location_image',
        'name_image',
        'phone_image',
        'email_image',
        'otp_image'
    ];
}