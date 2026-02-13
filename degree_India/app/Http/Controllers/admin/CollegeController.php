<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\CollegeAccountDetail;
use App\Models\Course;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CollegeController extends Controller
{
    

    // public function index()
    // {
    //     $user = Auth::user();
    //     $user->load('role');
        
    //     $adminRoles = ['super-admin', 'counselor'];
        
    //     if (!$user->role || !in_array($user->role->slug, $adminRoles)) {
    //         if ($user->role && $user->role->slug == 'college-admin') {
    //             $college = College::where('user_id', $user->id)
    //                 ->with('courses')
    //                 ->first();
                    
    //             if (!$college) {
    //                 return redirect()->back()->with('error', 'No college assigned to your account');
    //             }
                
    //             $collegeAdminRole = Role::where('slug', 'college-admin')->first();
    //             $collegeAdminUserList = User::where('role_id', $collegeAdminRole->id)->get();
                
    //             return view('admin.college.index', [
    //                 'colleges' => collect([$college]), 
    //                 'collegeAdminUserList' => $collegeAdminUserList
    //             ]);
    //         }
            
    //         return redirect()->back()->with('error', 'Unauthorized access');
    //     }
        
    //     $collegeAdminRole = Role::where('slug', 'college-admin')->first();
    //     $collegeAdminUserList = User::where('role_id', $collegeAdminRole->id)->get();
        
    //     $colleges = College::with('courses')->latest()->paginate(20);
        
    //     return view('admin.college.index', compact('colleges', 'collegeAdminUserList'));
    // }

    public function index(Request $request)
    {
        $user = Auth::user();
        $user->load('role');
        
        $adminRoles = ['super-admin', 'counselor'];
        
        if (!$user->role || !in_array($user->role->slug, $adminRoles)) {
            if ($user->role && $user->role->slug == 'college-admin') {
                $college = College::where('user_id', $user->id)
                    ->with('courses')
                    ->first();
                    
                if (!$college) {
                    return redirect()->back()->with('error', 'No college assigned to your account');
                }
                
                $collegeAdminRole = Role::where('slug', 'college-admin')->first();
                $collegeAdminUserList = User::where('role_id', $collegeAdminRole->id)->get();
                
                // Handle export for college admin
                if ($request->has('export')) {
                    $colleges = collect([$college]);
                    
                    if ($request->export == 'pdf') {
                        return $this->exportPDF($colleges);
                    } elseif ($request->export == 'csv') {
                        return $this->exportCSV($colleges);
                    } elseif ($request->export == 'print') {
                        return $this->exportPrint($colleges);
                    }
                }
                
                return view('admin.college.index', [
                    'colleges' => collect([$college]), 
                    'collegeAdminUserList' => $collegeAdminUserList
                ]);
            }
            
            return redirect()->back()->with('error', 'Unauthorized access');
        }
        
        $collegeAdminRole = Role::where('slug', 'college-admin')->first();
        $collegeAdminUserList = User::where('role_id', $collegeAdminRole->id)->get();
        
        // Start query
        $query = College::with(['courses', 'admin']);
        
        // Apply filters if any
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        if ($request->has('state') && $request->state != '') {
            $query->where('state', $request->state);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('city', 'like', '%' . $search . '%')
                ->orWhere('state', 'like', '%' . $search . '%')
                ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }
        
        // Handle export
        if ($request->has('export')) {
            $colleges = $query->get();
            
            if ($request->export == 'pdf') {
                return $this->exportPDF($colleges);
            } elseif ($request->export == 'csv') {
                return $this->exportCSV($colleges);
            } elseif ($request->export == 'print') {
                return $this->exportPrint($colleges);
            }
        }
        
        // Calculate stats with filters applied
        $statsQuery = clone $query;
        $totalColleges = $statsQuery->count();
        $publishedCount = $statsQuery->clone()->where('status', 'published')->count();
        $withAdminCount = $statsQuery->clone()->whereNotNull('user_id')->count();
        
        // For total courses with filters
        $coursesQuery = College::withCount('courses');
        
        // Apply same filters to courses query
        if ($request->has('status') && $request->status != '') {
            $coursesQuery->where('status', $request->status);
        }
        
        if ($request->has('type') && $request->type != '') {
            $coursesQuery->where('type', $request->type);
        }
        
        if ($request->has('state') && $request->state != '') {
            $coursesQuery->where('state', $request->state);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $coursesQuery->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('city', 'like', '%' . $search . '%')
                ->orWhere('state', 'like', '%' . $search . '%')
                ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }
        
        $totalCourses = $coursesQuery->get()->sum('courses_count');
        
        // Get unique values for filters
        $statuses = ['published', 'draft', 'archived'];
        $types = College::select('type')->distinct()->pluck('type');
        $states = College::select('state')->distinct()->pluck('state');
        
        // For normal view, paginate (20 records per page)
        $colleges = $query->latest()->paginate(20);
        
        return view('admin.college.index', compact(
            'colleges', 
            'collegeAdminUserList',
            'statuses',
            'types',
            'states',
            'totalColleges',
            'publishedCount',
            'withAdminCount',
            'totalCourses'
        ));
    }
    
    // Export to PDF
    private function exportPDF($colleges)
    {
        $pdf = Pdf::loadView('admin.college.exports.pdf', [
            'colleges' => $colleges,
            'title' => 'Colleges Report - ' . date('Y-m-d'),
            'filters' => request()->only(['status', 'type', 'state', 'search'])
        ]);
        
        return $pdf->download('colleges-report-' . date('Y-m-d') . '.pdf');
    }
    
    // Export to CSV
    private function exportCSV($colleges)
    {
        $fileName = 'colleges-' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $callback = function() use ($colleges) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fwrite($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            
            // Headers
            fputcsv($file, [
                'ID',
                'Name',
                'Short Description',
                'City',
                'State',
                'Country',
                'Type',
                'Status',
                'Courses Count',
                'Assigned Admin',
                'Created At'
            ]);
            
            // Data
            foreach ($colleges as $college) {
                fputcsv($file, [
                    $college->id,
                    $college->name,
                    $college->short_description,
                    $college->city,
                    $college->state,
                    $college->country,
                    $college->type,
                    ucfirst($college->status),
                    $college->courses_count ?? $college->courses->count(),
                    $college->admin ? $college->admin->name : 'Not Assigned',
                    $college->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    // Export for Print
    private function exportPrint($colleges)
    {
        return view('admin.college.exports.print', [
            'colleges' => $colleges,
            'title' => 'Colleges Report - ' . date('Y-m-d'),
            'filters' => request()->only(['status', 'type', 'state', 'search'])
        ]);
    }

    public function create()
    {
        $courses = Course::published()->get();
        $college = new College(); 
        return view('admin.college.create', compact('courses', 'college'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'pincode' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'established_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'accreditation' => 'nullable|string',
            'affiliation' => 'nullable|string',
            'type' => 'required|in:government,private,deemed,autonomous',
            'campus_size' => 'nullable|string',
            'total_students' => 'nullable|integer',
            'total_faculty' => 'nullable|integer',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nirf_ranking' => 'nullable|integer',
            'fees_structure' => 'nullable|array',
            'admission_process' => 'nullable|string',
            'eligibility_criteria' => 'nullable|array',
            'application_deadline' => 'nullable|date',
            'academic_year_start' => 'nullable|date',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string',
            'average_package' => 'nullable|numeric',
            'highest_package' => 'nullable|numeric',
            'top_recruiters' => 'nullable|array',
            'placement_percentage' => 'nullable|integer|min:0|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published,archived',
            'courses' => 'nullable|array',
            'course_fees.*' => 'nullable|numeric',
            'course_duration.*' => 'nullable|string',
            'course_intake.*' => 'nullable|in:january,july,yearly',
            'course_seats.*' => 'nullable|integer',
             'linkedin_url' => 'nullable|string',
            'youtube_url' => 'nullable|string',
            'instagram_url' =>'nullable|string',
            'facebook_url' => 'nullable|string',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($request->name) . '-' . Str::random(6);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('colleges/logo', 'public');
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('colleges/cover', 'public');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $image->store('colleges/gallery', 'public');
            }
            $validated['gallery_images'] = $galleryPaths;
        }

        // Create college
        $college = College::create($validated);

        // Attach courses with pivot data
        if ($request->has('courses')) {
            $coursesData = [];
            foreach ($request->courses as $courseId) {
                $coursesData[$courseId] = [
                    'fees' => $request->course_fees[$courseId] ?? null,
                    'duration' => $request->course_duration[$courseId] ?? null,
                    'intake' => $request->course_intake[$courseId] ?? 'yearly',
                    'seats' => $request->course_seats[$courseId] ?? null,
                    'eligibility' => $request->course_eligibility[$courseId] ?? null,
                ];
            }
            $college->courses()->sync($coursesData);
        }

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College created successfully.');
    }

    public function assignAdmin(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'user_id' => 'required|exists:users,id'
        ]);
        
        try {
            // Check if user is already assigned to another college
            $existingAssignment = College::where('user_id', $request->user_id)
                                        ->where('id', '!=', $request->college_id)
                                        ->first();
            
            if ($existingAssignment) {
                return response()->json([
                    'error' => 'This admin is already assigned to another college!'
                ], 422); // 422 status code for validation error
            }
            
            // Find and update college
            $college = College::findOrFail($request->college_id);
            $college->update([
                'user_id' => $request->user_id
            ]);
            
            return response()->json([
                'success' => 'Admin assigned successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error assigning admin: ' . $e->getMessage()
            ], 500);
        }
    }

   
    public function show(College $college)
    {
        return view('admin.college.show', compact('college'));
    }

    public function edit(College $college)
    {
        $college->load('courses');
        $courses = Course::published()->get();
        
        return view('admin.college.edit', compact('college', 'courses'));
    }

     public function accountDetails(College $college)
    {
        $accountDetail = $college->accountDetail;
        return view('admin.college.account-details', compact('college', 'accountDetail'));
    }

    

    public function storeAccountDetails(Request $request, College $college)
    {
        $request->validate([
            'account_holder_name' => 'required|string|max:255',

            'bank_name' => 'required|string|max:255',

            'account_number' => 'required|digits_between:9,18',
            'ifsc_code' => 'required|string|max:11',

            'branch_name' => 'required|string|max:255',

            'account_type' => 'required|in:savings,current',
            'micr_code' => 'nullable',

            'upi_id' => [
                'nullable',
                'regex:/^[a-zA-Z0-9.\-_]{2,256}@[a-zA-Z]{2,64}$/'
            ],

            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            'registered_mobile' => 'nullable|digits:10',
        ]);

        
        // Handle QR code upload
        $qrCodePath = null;
        if ($request->hasFile('qr_code')) {
            $qrCodePath = $request->file('qr_code')->store('qr-codes', 'public');
        }
        
        // Update or create account details
        $college->accountDetail()->updateOrCreate(
            ['college_id' => $college->id],
            [
                'account_holder_name' => $request->account_holder_name,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'ifsc_code' => $request->ifsc_code,
                'branch_name' => $request->branch_name,
                'account_type' => $request->account_type,
                'micr_code' => $request->micr_code,
                'upi_id' => $request->upi_id,
                'qr_code_path' => $qrCodePath ?? ($college->accountDetail->qr_code_path ?? null),
                'registered_mobile' => $request->registered_mobile,
            ]
        );
        
        return redirect()->back()
            ->with('success', 'Account details updated successfully!');
    }
    
    
    public function downloadQrCode(College $college)
    {
        $accountDetail = $college->accountDetail;
        
        if (!$accountDetail || !$accountDetail->qr_code_path) {
            return redirect()->back()->with('error', 'QR code not found!');
        }
        
        return Storage::disk('public')->download($accountDetail->qr_code_path);
    }

    public function update(Request $request, College $college)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'pincode' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'established_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'accreditation' => 'nullable|string',
            'affiliation' => 'nullable|string',
            'type' => 'required|in:government,private,deemed,autonomous',
            'campus_size' => 'nullable|string',
            'total_students' => 'nullable|integer',
            'total_faculty' => 'nullable|integer',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nirf_ranking' => 'nullable|integer',
            'fees_structure' => 'nullable|array',
            'admission_process' => 'nullable|string',
            'eligibility_criteria' => 'nullable|array',
            'application_deadline' => 'nullable|date',
            'academic_year_start' => 'nullable|date',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string',
            'average_package' => 'nullable|numeric',
            'highest_package' => 'nullable|numeric',
            'top_recruiters' => 'nullable|array',
            'placement_percentage' => 'nullable|integer|min:0|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published,archived',
            'courses' => 'nullable|array',
            'course_fees.*' => 'nullable|numeric',
            'course_duration.*' => 'nullable|string',
            'course_intake.*' => 'nullable|in:january,july,yearly',
            'course_seats.*' => 'nullable|integer',
            'linkedin_url' => 'nullable|string',
            'youtube_url' => 'nullable|string',
            'instagram_url' =>'nullable|string',
            'facebook_url' => 'nullable|string',
        ]);

        // Update slug if name changed
        if ($college->name !== $request->name) {
            $validated['slug'] = Str::slug($request->name) . '-' . Str::random(6);
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($college->logo) {
                Storage::disk('public')->delete($college->logo);
            }
            $validated['logo'] = $request->file('logo')->store('colleges/logo', 'public');
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($college->cover_image) {
                Storage::disk('public')->delete($college->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('colleges/cover', 'public');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = $college->gallery_images ?? [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $image->store('colleges/gallery', 'public');
            }
            $validated['gallery_images'] = $galleryPaths;
        }

        // Update college
        $college->update($validated);

        // Update courses with pivot data
        if ($request->has('courses')) {
            $coursesData = [];
            foreach ($request->courses as $courseId) {
                $coursesData[$courseId] = [
                    'fees' => $request->course_fees[$courseId] ?? null,
                    'duration' => $request->course_duration[$courseId] ?? null,
                    'intake' => $request->course_intake[$courseId] ?? 'yearly',
                    'seats' => $request->course_seats[$courseId] ?? null,
                    'eligibility' => $request->course_eligibility[$courseId] ?? null,
                ];
            }
            $college->courses()->sync($coursesData);
        } else {
            $college->courses()->detach();
        }

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College updated successfully.');
    }

   
    public function destroy(College $college)
    {
        // Delete images
        if ($college->logo) {
            Storage::disk('public')->delete($college->logo);
        }
        if ($college->cover_image) {
            Storage::disk('public')->delete($college->cover_image);
        }
        if ($college->gallery_images) {
            foreach ($college->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $college->delete();

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College deleted successfully.');
    }

    
    public function removeGalleryImage(College $college, $imageIndex)
    {
        $galleryImages = $college->gallery_images;
        
        if (isset($galleryImages[$imageIndex])) {
            // Delete file from storage
            Storage::disk('public')->delete($galleryImages[$imageIndex]);
            
            // Remove from array
            unset($galleryImages[$imageIndex]);
            $college->gallery_images = array_values($galleryImages); // Reindex array
            $college->save();
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function courses(College $college)
    {
        $college->load('courses');
        return view('admin.college.courses', compact('college'));
    }
}