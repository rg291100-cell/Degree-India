<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_time',
        'start_time',
        'end_time',
        'is_active',
        'max_bookings',
        'current_bookings',
        'days_available'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'days_available' => 'array'
    ];

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'slot', 'slot_time');
    }

    // Helper Methods
    public function isAvailable()
    {
        return $this->is_active && $this->current_bookings < $this->max_bookings;
    }

    public function incrementBookings()
    {
        $this->current_bookings += 1;
        $this->save();
    }

    public function decrementBookings()
    {
        $this->current_bookings = max(0, $this->current_bookings - 1);
        $this->save();
    }

    public function getStatusColor()
    {
        if (!$this->is_active) {
            return 'danger'; // Red
        }
        
        if ($this->current_bookings >= $this->max_bookings) {
            return 'warning'; // Orange/Yellow
        }
        
        return 'success'; // Green
    }

    public function getStatusText()
    {
        if (!$this->is_active) {
            return 'Disabled';
        }
        
        if ($this->current_bookings >= $this->max_bookings) {
            return 'Full';
        }
        
        return 'Available';
    }
}