<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Role;
use App\Models\BookingSlot;
use App\Models\ConversationSummary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
   

    // public function index(Request $request)
    // {
    //     $user = Auth::user();
    //     $user->load('role');

    //     // Define admin roles that can see all bookings
    //     $adminRoles = ['super-admin'];

    //     $query = Booking::with(['student', 'counselor']);

    //     if (!$user->role || !in_array($user->role->slug, $adminRoles)) {
    //         // If counselor, restrict to only their assigned bookings
    //         if ($user->role && $user->role->slug == 'counselor') {
    //             $query->where('counselor_id', $user->id);
    //         } else {
    //             // If user doesn't have any of these roles
    //             return redirect()->back()->with('error', 'Unauthorized access');
    //         }
    //     }

    //     // Apply filters
    //     if ($request->has('month') && $request->month != '') {
    //         $query->where('month', $request->month);
    //     }

    //     if ($request->has('year') && $request->year != '') {
    //         $query->where('year', $request->year);
    //     }

    //     if ($request->has('language') && $request->language != '') {
    //         $query->where('language', $request->language);
    //     }

    //     if ($request->has('slot') && $request->slot != '') {
    //         $query->where('slot', $request->slot);
    //     }

    //     if ($request->has('student_name') && $request->student_name != '') {
    //         $query->whereHas('student', function($q) use ($request) {
    //             $q->where('name', 'like', '%' . $request->student_name . '%');
    //         });
    //     }

    //     if ($request->has('counselor') && $request->counselor != '') {
    //         if ($request->counselor == 'unassigned') {
    //             $query->whereNull('counselor_id');
    //         } else {
    //             $query->where('counselor_id', $request->counselor);
    //         }
    //     }

    //     // For export, get all data without pagination
    //     if ($request->has('export')) {
    //         $bookings = $query->get();

    //         if ($request->export == 'pdf') {
    //             return $this->exportPDF($bookings);
    //         } elseif ($request->export == 'csv') {
    //             return $this->exportCSV($bookings);
    //         } elseif ($request->export == 'print') {
    //             return $this->exportPrint($bookings);
    //         }
    //     }

    //     // Get unique values for filter dropdowns
    //     $months = Booking::select('month')->distinct()->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')")->get()->pluck('month');
    //     $years = Booking::select('year')->distinct()->orderBy('year', 'desc')->get()->pluck('year');
    //     $languages = Booking::select('language')->distinct()->orderBy('language')->get()->pluck('language');
    //     $slots = Booking::select('slot')->distinct()->orderBy('slot')->get()->pluck('slot');

    //     // Get counselor list
    //     $counselorRole = Role::where('slug', 'counselor')->first();
    //     $counselorList = User::where('role_id', $counselorRole->id)->get();

    //     // For normal view, get all or filtered data
    //     $bookings = $query->orderBy('year', 'desc')
    //         ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')")
    //         ->orderBy('slot', 'asc')
    //         ->get();

    //     // Stats for cards
    //     $totalBookings = $bookings->count();
    //     $currentMonth = now()->format('F');
    //     $currentMonthBookings = $bookings->where('month', $currentMonth)->count();
    //     $uniqueStudents = $bookings->pluck('student_id')->unique()->count();
    //     $uniqueLanguages = $bookings->pluck('language')->unique()->count();
    //     $assignedBookings = $bookings->whereNotNull('counselor_id')->count();
    //     $unassignedBookings = $bookings->whereNull('counselor_id')->count();

    //     return view('admin.bookings.index', compact(
    //         'bookings', 
    //         'totalBookings', 
    //         'currentMonthBookings',
    //         'uniqueStudents',
    //         'uniqueLanguages',
    //         'assignedBookings',
    //         'unassignedBookings',
    //         'months',
    //         'years',
    //         'languages',
    //         'slots',
    //         'counselorList'
    //     ));
    // }
    

    public function index(Request $request)
    {
        $user = Auth::user();
        $user->load('role');
        
        // Get active slots with their IDs
        $slots = BookingSlot::where('is_active', true)
            ->orderBy('start_time')
            ->get();

        // Define admin roles that can see all bookings
        $adminRoles = ['super-admin'];

        $query = Booking::with(['student', 'counselor', 'slotRelation']); // Add slotRelation

        if (!$user->role || !in_array($user->role->slug, $adminRoles)) {
            // If counselor, restrict to only their assigned bookings
            if ($user->role && $user->role->slug == 'counselor') {
                $query->where('counselor_id', $user->id);
            } else {
                // If user doesn't have any of these roles
                return redirect()->back()->with('error', 'Unauthorized access');
            }
        }

        // Apply filters
        if ($request->has('month') && $request->month != '') {
            $query->where('month', $request->month);
        }

        if ($request->has('year') && $request->year != '') {
            $query->where('year', $request->year);
        }

        if ($request->has('language') && $request->language != '') {
            $query->where('language', $request->language);
        }

        // Fix: slot filter should check slot_id, not slot
        if ($request->has('slot') && $request->slot != '') {
            $query->where('slot_id', $request->slot);
        }

        if ($request->has('student_name') && $request->student_name != '') {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student_name . '%');
            });
        }

        if ($request->has('counselor') && $request->counselor != '') {
            if ($request->counselor == 'unassigned') {
                $query->whereNull('counselor_id');
            } else {
                $query->where('counselor_id', $request->counselor);
            }
        }

        // For export, get all data without pagination
        if ($request->has('export')) {
            $bookings = $query->get();

            if ($request->export == 'pdf') {
                return $this->exportPDF($bookings);
            } elseif ($request->export == 'csv') {
                return $this->exportCSV($bookings);
            } elseif ($request->export == 'print') {
                return $this->exportPrint($bookings);
            }
        }

        // Get unique values for filter dropdowns
        $months = Booking::select('month')->distinct()
            ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')")
            ->get()->pluck('month');
        
        $years = Booking::select('year')->distinct()
            ->orderBy('year', 'desc')
            ->get()->pluck('year');
        
        $languages = Booking::select('language')->distinct()
            ->orderBy('language')
            ->get()->pluck('language');

        // Get current year and month
        $currentYear = date('Y');
        $currentMonth = date('F'); // Full month name like 'January'
        
        // Generate months from January to December
        $allMonths = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Get counselor list
        $counselorRole = Role::where('slug', 'counselor')->first();
        $counselorList = $counselorRole ? User::where('role_id', $counselorRole->id)->get() : collect([]);

        // For normal view, get all or filtered data
        $bookings = $query->orderBy('year', 'desc')
            ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')")
            ->orderBy('slot_id', 'asc')
            ->get();

        // Stats for cards
        $totalBookings = $bookings->count();
        $currentMonthBookings = $bookings->where('month', $currentMonth)->count();
        $uniqueStudents = $bookings->pluck('student_id')->unique()->count();
        $uniqueLanguages = $bookings->pluck('language')->unique()->count();
        $assignedBookings = $bookings->whereNotNull('counselor_id')->count();
        $unassignedBookings = $bookings->whereNull('counselor_id')->count();

        return view('admin.bookings.index', compact(
            'bookings', 
            'totalBookings', 
            'currentMonthBookings',
            'uniqueStudents',
            'uniqueLanguages',
            'assignedBookings',
            'unassignedBookings',
            'months',
            'years',
            'languages',
            'slots',
            'counselorList',
            'allMonths',
            'currentYear',
            'currentMonth'
        ));
    }
    // Assign counselor to booking
    public function assignCounselor(Request $request, $id)
    {
        try {
            $request->validate([
                'counselor_id' => 'required|exists:users,id'
            ]);
            
            $booking = Booking::findOrFail($id);
            $booking->counselor_id = $request->counselor_id;
            $booking->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Counselor assigned successfully!',
                'counselor_name' => $booking->counselor->name ?? 'N/A'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Remove counselor assignment
    public function removeCounselor($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->counselor_id = null;
            $booking->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Counselor removed successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Export to PDF
    private function exportPDF($bookings)
    {
        $pdf = Pdf::loadView('admin.bookings.exports.pdf', [
            'bookings' => $bookings,
            'title' => 'Booking Sessions Report - ' . date('Y-m-d'),
            'filters' => request()->only(['month', 'year', 'language', 'slot', 'student_name', 'counselor'])
        ]);
        
        return $pdf->download('booking-sessions-' . date('Y-m-d') . '.pdf');
    }
    
    // Export to CSV
    private function exportCSV($bookings)
    {
        $fileName = 'booking-sessions-' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fwrite($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            
            // Headers
            fputcsv($file, [
                'ID',
                'Student Name',
                'Student Email',
                'Student Phone',
                'Month',
                'Year',
                'Slot Time',
                'Language',
                'Counselor Assigned',
                'Booking Date'
            ]);
            
            // Data
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->student->name ?? 'N/A',
                    $booking->student->email ?? 'N/A',
                    $booking->student->phone ?? 'N/A',
                    $booking->month,
                    $booking->year,
                    $booking->slot,
                    $booking->language,
                    $booking->counselor->name ?? 'Not Assigned',
                    $booking->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    // Export for Print
    private function exportPrint($bookings)
    {
        return view('admin.bookings.exports.print', [
            'bookings' => $bookings,
            'title' => 'Booking Sessions Report - ' . date('Y-m-d'),
            'filters' => request()->only(['month', 'year', 'language', 'slot', 'student_name', 'counselor'])
        ]);
    }
    
    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();
            
            return redirect()->route('admin.booking-slot.index')
                ->with('success', 'Booking deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.booking-slot.index')
                ->with('error', 'Error deleting booking: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $booking = Booking::with(['student', 'counselor'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $booking->id,
                'month' => $booking->month,
                'year' => $booking->year,
                'slot' => $booking->slot,
                'language' => $booking->language,
                'student_id' => $booking->student_id,
                'student' => $booking->student,
                'counselor_id' => $booking->counselor_id,
                'counselor' => $booking->counselor,
                'created_at_formatted' => $booking->created_at->format('M d, Y h:i A'),
                'updated_at_formatted' => $booking->updated_at->format('M d, Y h:i A')
            ]
        ]);
    }


    // Add these methods to your BookingController

    // Show conversation summary
    public function showConversation($id)
    {
        $booking = Booking::with(['student', 'counselor'])->findOrFail($id);
        
        // Check if summary exists
        $conversationSummary = ConversationSummary::where('booking_id', $id)->first();
        $exists = $conversationSummary ? true : false;
        
        return view('admin.bookings.conversation', compact('booking', 'conversationSummary', 'exists'));
    }

    // Store conversation summary
    public function storeConversation(Request $request, $id)
    {
        try {
            $request->validate([
                'summary' => 'required|string|min:10',
                'notes' => 'nullable|string',
                'key_points' => 'nullable|array',
                'meeting_date' => 'nullable|date',
                'meeting_time' => 'nullable|string',
                'duration' => 'nullable|string',
                'status' => 'required|in:scheduled,completed,cancelled,rescheduled',
                'follow_up_date' => 'nullable|date|after_or_equal:today',
                'follow_up_notes' => 'nullable|string'
            ]);

            $booking = Booking::findOrFail($id);
            
            $data = $request->all();
            $data['booking_id'] = $booking->id;
            $data['counselor_id'] = $booking->counselor_id ?? auth()->id();
            $data['student_id'] = $booking->student_id;
            
            // Process key points as array
            if ($request->has('key_points')) {
                $data['key_points'] = array_filter($request->key_points);
            }
            
            // Check if summary already exists
            $existingSummary = ConversationSummary::where('booking_id', $id)->first();
            
            if ($existingSummary) {
                // Update existing
                $existingSummary->update($data);
                $message = 'Conversation summary updated successfully!';
            } else {
                // Create new
                ConversationSummary::create($data);
                $message = 'Conversation summary saved successfully!';
            }
            
            return redirect()->route('admin.bookings.conversation', $id)
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return redirect()->route('admin.bookings.conversation', $id)
                ->with('error', 'Error saving conversation: ' . $e->getMessage());
        }
    }

    // Get conversation summary via AJAX
    public function getConversation($id)
    {
        $conversationSummary = ConversationSummary::where('booking_id', $id)
            ->with(['counselor', 'student'])
            ->first();
        
        if ($conversationSummary) {
            return response()->json([
                'success' => true,
                'data' => $conversationSummary,
                'exists' => true
            ]);
        }
        
        return response()->json([
            'success' => false,
            'exists' => false,
            'message' => 'No conversation summary found'
        ]);
    }
}