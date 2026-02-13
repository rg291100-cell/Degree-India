<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\Notification;

class BookingController extends Controller
{
    //
    public function bookSlot(Request $request)
    {
        try {
            // Authenticate user via JWT token
            $user = JWTAuth::parseToken()->authenticate();

            // Validate request inputs
            $validator = Validator::make($request->all(), [
                'month'    => 'required|string',
                'year'     => 'required|integer|min:2023|max:2100',
                'slot_time_id'     => 'required',
                'language' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            

            // Create booking linked to authenticated user
            $booking = Booking::create([
                'student_id' => $user->id,
                'month'      => $request->month,
                'year'       => $request->year,
                'slot_id'       => $request->slot_time_id,
                'language'   => $request->language,
            ]);

            // Fetch slot timing details for notification
            $slot = BookingSlot::find($booking->slot_id);
            $slotTimeText = $slot ? (date('h:i A', strtotime($slot->start_time)) . ' - ' . date('h:i A', strtotime($slot->end_time))) : 'Selected slot';

            // Create in-app notification for the student
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Slot Booked',
                'message' => "Your slot for {$slotTimeText} ({$booking->month}/{$booking->year}) has been booked successfully."
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Slot booked successfully',
                'booking' => $booking,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to book slot',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function getSlots(Request $request)
    {
        try {
            // Optional filters
            $month = $request->month;
            $year  = $request->year;

            // Fetch all bookings, optionally filtered by month/year
            $slots = Booking::with('student:id,name,email')
                ->when($month, fn($q) => $q->where('month', $month))
                ->when($year, fn($q) => $q->where('year', $year))
                ->orderBy('year')
                ->orderBy('month')
                ->orderBy('slot_id')
                ->get();

            return response()->json([
                'status' => true,
                'count'  => $slots->count(),
                'slots'  => $slots,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch slots',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function getSlotsTime(Request $request)
    {
        $slots = BookingSlot::where('is_active', 1)
            ->orderBy('start_time')
            ->get()
            ->map(function ($slot) {
                return [
                    'id'         => $slot->id,
                    'slot_time'  => date('h:i A', strtotime($slot->start_time)) . ' - ' .
                                    date('h:i A', strtotime($slot->end_time)),
                    'start_time' => $slot->start_time,
                    'end_time'   => $slot->end_time,
                ];
            });

        return response()->json([
            'status'  => true,
            'message' => 'Slots timing fetched successfully',
            'data'    => $slots,
        ], 200);
    }


}
