<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookingSlot;

class BookingSlotsSeeder extends Seeder
{
    public function run()
    {
       $slots = [
            ['07:00', '08:00'],
            ['08:00', '09:00'],
            ['09:00', '10:00'],
            ['10:00', '11:00'],
            ['11:00', '12:00'],
            ['12:00', '13:00'],
            ['13:00', '14:00'],
            ['14:00', '15:00'],
            ['15:00', '16:00'],
            ['16:00', '17:00'],
            ['17:00', '18:00'],
            ['18:00', '19:00'],
            ['19:00', '20:00'],
            ['20:00', '21:00'],
            ['21:00', '22:00'],
        ];

        
        foreach ($slots as $slot) {
            $startFormatted = date('g:i A', strtotime($slot[0]));
            $endFormatted = date('g:i A', strtotime($slot[1]));
            
            BookingSlot::create([
                'slot_time' => $startFormatted . ' - ' . $endFormatted,
                'start_time' => $slot[0],
                'end_time' => $slot[1],
                'is_active' => true,
                'max_bookings' => 1,
                'current_bookings' => 0,
                'days_available' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']
            ]);
        }
    }
}