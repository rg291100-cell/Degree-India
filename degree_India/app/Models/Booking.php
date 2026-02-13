<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['student_id', 'counselor_id','month', 'year', 'slot_id', 'language'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    // User relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Course relationship
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // College relationship
    public function college()
    {
        return $this->belongsTo(College::class);
    }

   

    // Relationship with Counselor
    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

      protected static function booted()
    {
        static::created(function ($booking) {
            // Increment slot bookings count
            $slot = BookingSlot::where('slot_time', $booking->slot)->first();
            if ($slot) {
                $slot->incrementBookings();
            }
        });

        static::deleted(function ($booking) {
            // Decrement slot bookings count
            $slot = BookingSlot::where('slot_time', $booking->slot)->first();
            if ($slot) {
                $slot->decrementBookings();
            }
        });
    }


    public function slotRelation()
    {
        return $this->belongsTo(BookingSlot::class, 'slot_id');
    }
    

}
