<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\College;
use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $user->load('role');
        $currentRole = $user->role->name;
        // Total Courses Count
        $totalCourses = Course::count();
        
        // Total Colleges Count
        $totalColleges = College::count();
        
        // Total Students Count (role_id = 2 वाले users)
        $totalStudents = User::where('role_id', 2)->count();
        
        // Total Booked Counselling Sessions
        $totalSessions = Booking::count();
        
        // Today's Statistics
        $today = Carbon::today();
        
        // New Students Today
        $newStudentsToday = User::where('role_id', 2)
            ->whereDate('created_at', $today)
            ->count();
        
        // New Sessions Today
        $newSessionsToday = Booking::whereDate('created_at', $today)
            ->count();
        
        // Admissions (आपके logic के अनुसार, मैंने Bookings को admissions मान लिया है)
        $admissionsToday = Booking::whereDate('created_at', $today)
            ->count();
        
        // Success Rate (example - approved bookings percentage)
        $totalBookings = Booking::count();
        $approvedBookings = 0;
        $successRate = $totalBookings > 0 ? round(($approvedBookings / $totalBookings) * 100) : 0;
        
        // Popular Categories with count
        $popularCategories = Category::withCount('courses')
            ->orderBy('courses_count', 'desc')
            ->take(5)
            ->get();
        
        // Latest Admissions (Bookings with user and course/college details)
        $latestAdmissions = Booking::with(['user', 'course', 'college'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Last Month Growth Calculations
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $currentMonthStart = Carbon::now()->startOfMonth();
        
        // Courses growth
        $lastMonthCourses = Course::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $currentMonthCourses = Course::where('created_at', '>=', $currentMonthStart)->count();
        $coursesGrowth = $lastMonthCourses > 0 ? 
            round((($currentMonthCourses - $lastMonthCourses) / $lastMonthCourses) * 100) : 0;
        
        // Colleges growth
        $lastMonthColleges = College::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $currentMonthColleges = College::where('created_at', '>=', $currentMonthStart)->count();
        $collegesGrowth = $lastMonthColleges > 0 ? 
            round((($currentMonthColleges - $lastMonthColleges) / $lastMonthColleges) * 100) : 0;
        
        // Students growth
        $lastMonthStudents = User::where('role_id', 2)
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();
        $currentMonthStudents = User::where('role_id', 2)
            ->where('created_at', '>=', $currentMonthStart)
            ->count();
        $studentsGrowth = $lastMonthStudents > 0 ? 
            round((($currentMonthStudents - $lastMonthStudents) / $lastMonthStudents) * 100) : 0;
        
        // Sessions growth (last week)
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
        $currentWeekStart = Carbon::now()->startOfWeek();
        
        $lastWeekSessions = Booking::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();
        $currentWeekSessions = Booking::where('created_at', '>=', $currentWeekStart)->count();
        $sessionsGrowth = $lastWeekSessions > 0 ? 
            round((($currentWeekSessions - $lastWeekSessions) / $lastWeekSessions) * 100) : 0;
        
        return view('admin.index', compact(
            'totalCourses',
            'totalColleges',
            'totalStudents',
            'totalSessions',
            'newStudentsToday',
            'newSessionsToday',
            'admissionsToday',
            'successRate',
            'popularCategories',
            'latestAdmissions',
            'coursesGrowth',
            'collegesGrowth',
            'studentsGrowth',
            'sessionsGrowth',
            'currentRole'
        ));
    }
}