<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'counselor_id',
        'student_id',
        'summary',
        'notes',
        'key_points',
        'meeting_date',
        'meeting_time',
        'duration',
        'status',
        'follow_up_date',
        'follow_up_notes',
        'attachments'
    ];

    protected $casts = [
        'key_points' => 'array',
        'attachments' => 'array'
    ];

    // Relationship with Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Relationship with Counselor
    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    // Relationship with Student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Status options
    public static function getStatusOptions()
    {
        return [
            'scheduled' => 'Scheduled',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'rescheduled' => 'Rescheduled'
        ];
    }

    // Check if summary exists for booking
    public static function existsForBooking($bookingId)
    {
        return self::where('booking_id', $bookingId)->exists();
    }
}