<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BookingSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingSlotController extends Controller
{
    public function index()
    {
        $slots = BookingSlot::orderBy('start_time')->get();
        
        $stats = [
            'total_slots' => $slots->count(),
            'active_slots' => $slots->where('is_active', true)->count(),
            'available_slots' => $slots->where('is_active', true)
                                      ->where('current_bookings', '<', DB::raw('max_bookings'))
                                      ->count(),
            'full_slots' => $slots->where('current_bookings', '>=', DB::raw('max_bookings'))->count(),
        ];
        
        return view('admin.booking-slots.index', compact('slots', 'stats'));
    }

    public function create()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return view('admin.booking-slots.create', compact('days'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'slot_time' => 'required|string|unique:booking_slots,slot_time',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_bookings' => 'required|integer|min:1',
            'days_available' => 'nullable|array',
            'days_available.*' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'
        ]);

        $slot = BookingSlot::create([
            'slot_time' => $request->slot_time,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'max_bookings' => $request->max_bookings,
            'days_available' => $request->days_available,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.slots.index')
            ->with('success', 'Slot created successfully!');
    }

    public function edit($id)
    {
        $slot = BookingSlot::findOrFail($id);
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return view('admin.booking-slots.edit', compact('slot', 'days'));
    }

    public function update(Request $request, $id)
    {
        $slot = BookingSlot::findOrFail($id);
        
        $request->validate([
            'slot_time' => 'required|string|unique:booking_slots,slot_time,' . $id,
            'start_time' => 'required|date_format:h:i A',
            'end_time' => 'required|date_format:h:i A',
            'max_bookings' => 'required|integer|min:' . $slot->current_bookings,
            'days_available' => 'nullable|array',
            'days_available.*' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'
        ]);

        // Convert times to 24-hour format for comparison if needed
        $startTime24 = date('H:i', strtotime($request->start_time));
        $endTime24 = date('H:i', strtotime($request->end_time));
        
        // Validate that end time is after start time
        if (strtotime($endTime24) <= strtotime($startTime24)) {
            return redirect()->back()
                ->withErrors(['end_time' => 'End time must be after start time.'])
                ->withInput();
        }

        $slot->update([
            'slot_time' => $request->slot_time,
            'start_time' => $request->start_time, // Store as "10:00 AM"
            'end_time' => $request->end_time, // Store as "11:00 AM"
            'max_bookings' => $request->max_bookings,
            'days_available' => $request->days_available,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.slots.index')
            ->with('success', 'Slot updated successfully!');
    }

    public function destroy($id)
    {
        $slot = BookingSlot::findOrFail($id);
        
        // Check if slot has bookings
        if ($slot->bookings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete slot with existing bookings!');
        }
        
        $slot->delete();
        
        return redirect()->route('admin.slots.index')
            ->with('success', 'Slot deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $slot = BookingSlot::findOrFail($id);
        $slot->update(['is_active' => !$slot->is_active]);
        
        $status = $slot->is_active ? 'activated' : 'deactivated';
        
        return response()->json([
            'success' => true,
            'message' => 'Slot ' . $status . ' successfully!',
            'is_active' => $slot->is_active
        ]);
    }

    public function generateSlots(Request $request)
    {
        $request->validate([
            'start_hour' => 'required|integer|min:7|max:22',
            'end_hour' => 'required|integer|min:8|max:23|gt:start_hour',
            'duration' => 'required|integer|in:30,60,90,120',
            'max_bookings' => 'required|integer|min:1',
            'days' => 'required|array',
        ]);

        $slots = [];
        $startHour = $request->start_hour;
        $endHour = $request->end_hour;
        $duration = $request->duration;
        
        for ($hour = $startHour; $hour < $endHour; $hour++) {
            for ($minute = 0; $minute < 60; $minute += $duration) {
                $startTime = sprintf('%02d:%02d', $hour, $minute);
                $endHourTime = $hour + floor(($minute + $duration) / 60);
                $endMinute = ($minute + $duration) % 60;
                $endTime = sprintf('%02d:%02d', $endHourTime, $endMinute);
                
                // Format slot time
                $startFormatted = date('g:i A', strtotime($startTime));
                $endFormatted = date('g:i A', strtotime($endTime));
                $slotTime = $startFormatted . ' - ' . $endFormatted;
                
                // Check if slot already exists
                if (!BookingSlot::where('slot_time', $slotTime)->exists()) {
                    $slots[] = [
                        'slot_time' => $slotTime,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'max_bookings' => $request->max_bookings,
                        'days_available' => $request->days,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }
        
        if (!empty($slots)) {
            BookingSlot::insert($slots);
            $message = count($slots) . ' slots generated successfully!';
        } else {
            $message = 'No new slots generated (all slots already exist).';
        }
        
        return redirect()->route('admin.slots.index')
            ->with('success', $message);
    }

    public function resetBookings()
    {
        // Reset current bookings count for all slots
        BookingSlot::query()->update(['current_bookings' => 0]);
        
        // Recalculate current bookings from actual bookings
        $bookingsCount = DB::table('bookings')
            ->select('slot', DB::raw('COUNT(*) as count'))
            ->groupBy('slot')
            ->get();
        
        foreach ($bookingsCount as $booking) {
            DB::table('booking_slots')
                ->where('slot_time', $booking->slot)
                ->update(['current_bookings' => $booking->count]);
        }
        
        return redirect()->route('admin.slots.index')
            ->with('success', 'Booking counts reset successfully!');
    }
}