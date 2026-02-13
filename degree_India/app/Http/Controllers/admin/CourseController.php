<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Role;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
   
    public function index(Request $request)
    {
        $user = Auth::user();
        $user->load('role');

        // Define admin roles that can see all courses
        $adminRoles = ['super-admin', 'counselor'];

        $query = Course::with('category');

        if (!$user->role || !in_array($user->role->slug, $adminRoles)) {
            // If not super-admin or counselor, check if college-admin
            if ($user->role && $user->role->slug == 'college-admin') {
                // College-admin can only see their own courses
                $query->where('user_id', $user->id);
            } else {
                // If user doesn't have any of these roles
                return redirect()->back()->with('error', 'Unauthorized access');
            }
        }

        // Apply filters
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('featured') && $request->featured != '') {
            $query->where('featured', $request->featured);
        }
         // NEW: Add course_type filter
        if ($request->has('course_type') && $request->course_type != '') {
            $query->where('course_type', $request->course_type);
        }

        // NEW: Add course_mode filter
        if ($request->has('course_mode') && $request->course_mode != '') {
            $query->where('course_mode', $request->course_mode);
        }

        // For export, get all data without pagination
        if ($request->has('export')) {
            $courses = $query->get();

            if ($request->export == 'pdf') {
                return $this->exportPDF($courses);
            } elseif ($request->export == 'csv') {
                return $this->exportCSV($courses);
            } elseif ($request->export == 'print') {
                return $this->exportPrint($courses);
            }
        }

        // For normal view, paginate
        $courses = $query->paginate(5);
        $categories = Category::all();

        return view('admin.course.index', compact('courses', 'categories'));
    }

    // public function index(Request $request)
    // {
    //     $user = Auth::user();
    //     $user->load('role');

    //     // Define admin roles that can see all courses
    //     $adminRoles = ['super-admin', 'counselor'];

    //     $query = Course::with('category');

    //     if (!$user->role || !in_array($user->role->slug, $adminRoles)) {
    //         // If not super-admin or counselor, check if college-admin
    //         if ($user->role && $user->role->slug == 'college-admin') {
    //             // College-admin can only see their own courses
    //             $query->where('user_id', $user->id);
    //         } else {
    //             // If user doesn't have any of these roles
    //             return redirect()->back()->with('error', 'Unauthorized access');
    //         }
    //     }

    //     // Apply filters
    //     if ($request->has('category') && $request->category != '') {
    //         $query->where('category_id', $request->category);
    //     }

    //     if ($request->has('status') && $request->status != '') {
    //         $query->where('status', $request->status);
    //     }

    //     if ($request->has('featured') && $request->featured != '') {
    //         $query->where('featured', $request->featured);
    //     }

    //     // NEW: Add course_type filter
    //     if ($request->has('course_type') && $request->course_type != '') {
    //         $query->where('course_type', $request->course_type);
    //     }

    //     // NEW: Add course_mode filter
    //     if ($request->has('course_mode') && $request->course_mode != '') {
    //         $query->where('course_mode', $request->course_mode);
    //     }

    //     // For export, get all data without pagination
    //     if ($request->has('export')) {
    //         $courses = $query->get();

    //         if ($request->export == 'pdf') {
    //             return $this->exportPDF($courses);
    //         } elseif ($request->export == 'csv') {
    //             return $this->exportCSV($courses);
    //         } elseif ($request->export == 'print') {
    //             return $this->exportPrint($courses);
    //         }
    //     }

    //     // For normal view, paginate
    //     $courses = $query->paginate(10);
    //     $categories = Category::all();

    //     return view('admin.course.index', compact('courses', 'categories'));
    // }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.course.form', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                // Basic Info
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:courses,slug',
                'short_description' => 'nullable|string|max:500',
                'description' => 'required|string',
                
                // Course Details
                'course_type' => 'required|string|max:50',
                'course_mode' => 'required|in:online,offline,both',
                'duration' => 'required|integer|min:1',
                'duration_unit' => 'required|in:hours,days,weeks,months,year',
                'learning_format' => 'nullable|string|max:50',
                'total_sessions' => 'nullable|string|regex:/^\d{4}-\d{4}$/',
                'course_affiliation' => 'nullable|string|max:255',
                'key_features' => 'nullable|string',
                'skills_covered' => 'nullable|string',
                'course_advantage' => 'nullable|string',
                'syllabus' => 'nullable|string',
                
                // Pricing
                'fees' => 'required|numeric|min:0',
                'discounted_fees' => 'nullable|numeric|min:0',
                'admission_fee' => 'nullable|numeric|min:0',
                'discount_percentage' => 'nullable|numeric|min:0|max:100',
                'currency' => 'required|string|size:3',
                
                // Admission
                'education_qualification' => 'nullable|array',
                'education_qualification.*' => 'string',
                'min_age' => 'nullable|integer|min:0',
                'max_age' => 'nullable|integer|min:0',
                'entrance_exam' => 'nullable|string|max:255',
                'course_outcomes' => 'nullable|array',
                'course_outcomes.*' => 'string',
                'eligibility_criteria' => 'nullable|array',
                'eligibility_criteria.*' => 'string',
                
                // Career
                'career_scope' => 'nullable|string',
                'industry_trend' => 'nullable|string',
                'employment_areas' => 'nullable|string',
                'expected_market_size' => 'nullable|string|max:255',
                'salary_range' => 'nullable|string|max:255',
                
                // Highlights & Partners
                'course_highlights' => 'nullable|array',
                'course_highlights.*' => 'string',
                'highlight_icons' => 'nullable|array',
                'highlight_icons.*' => 'string',
                'partner_names' => 'nullable|array',
                'partner_names.*' => 'string',
                'partner_websites' => 'nullable|array',
                'partner_websites.*' => 'url',
                'partner_logos' => 'nullable|array',
                'partner_logos.*' => 'string',
                
                // Media
                'thumbnail_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'gallery_images' => 'nullable|array',
                'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'prospectus_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
                
                // Settings
                'level' => 'required|in:beginner,intermediate,advanced',
                'course_status' => 'required|in:draft,published,archived',
                'order' => 'nullable|integer|min:0',
                'featured' => 'nullable|boolean',
                'has_prospectus' => 'nullable|boolean',
                'allow_reviews' => 'nullable|boolean',
                
                // SEO
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string|max:255',
            ]);
            
            $user = Auth::user();
            $validated['user_id'] = $user->id;
            
            // Generate slug if not provided
            if (!$request->filled('slug')) {
                $validated['slug'] = Str::slug($validated['title']);
                
                $counter = 1;
                $originalSlug = $validated['slug'];
                while (Course::where('slug', $validated['slug'])->exists()) {
                    $validated['slug'] = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
            
            // Handle course highlights with icons
            if ($request->has('course_highlights')) {
                $highlights = [];
                foreach ($request->course_highlights as $index => $highlight) {
                    if (!empty(trim($highlight))) {
                        $highlights[] = [
                            'text' => $highlight,
                            'icon' => $request->highlight_icons[$index] ?? 'fas fa-check'
                        ];
                    }
                }
                $validated['course_highlights'] = $highlights;
            }
            
            // Handle academic partners
            if ($request->has('partner_names')) {
                $partners = [];
                foreach ($request->partner_names as $index => $name) {
                    if (!empty(trim($name))) {
                        $partners[] = [
                            'name' => $name,
                            'website' => $request->partner_websites[$index] ?? null,
                            'logo' => $request->partner_logos[$index] ?? null
                        ];
                    }
                }
                $validated['academic_partners'] = $partners;
            }
            
            // Handle array fields
            $validated['course_outcomes'] = $this->cleanArray($request->course_outcomes ?? []);
            $validated['eligibility_criteria'] = $this->cleanArray($request->eligibility_criteria ?? []);
            $validated['education_qualification'] = $this->cleanArray($request->education_qualification ?? []);
            
            // Handle skills covered (comma separated string to array)
            if ($request->filled('skills_covered')) {
                $skills = array_map('trim', explode(',', $request->skills_covered));
                $validated['skills_covered'] = array_filter($skills, function($skill) {
                    return !empty($skill);
                });
            }
            
            // Handle employment areas
            if ($request->filled('employment_areas')) {
                $areas = array_map('trim', explode(',', $request->employment_areas));
                $validated['employment_areas'] = array_filter($areas, function($area) {
                    return !empty($area);
                });
            }
            
            // Handle file uploads
            $validated['thumbnail_image'] = $request->file('thumbnail_image')->store('courses/thumbnails', 'public');
            $validated['banner_image'] = $request->file('banner_image')->store('courses/banners', 'public');
            
            if ($request->hasFile('gallery_images')) {
                $galleryImages = [];
                foreach ($request->file('gallery_images') as $image) {
                    $galleryImages[] = $image->store('courses/gallery', 'public');
                }
                $validated['gallery_images'] = $galleryImages;
            }
            
            if ($request->hasFile('prospectus_file') && $request->has('has_prospectus')) {
                $validated['prospectus_file'] = $request->file('prospectus_file')->store('courses/prospectus', 'public');
            }
            
            // Handle boolean fields
            $validated['featured'] = $request->has('featured');
            $validated['has_prospectus'] = $request->has('has_prospectus');
            $validated['allow_reviews'] = $request->has('allow_reviews');
            
            // Map course_status to status
            $validated['status'] = $validated['course_status'];
            unset($validated['course_status']);
            
            // Create course
            Course::create($validated);
            
            return redirect()->route('admin.courses.index')
                ->with('success', 'Course created successfully!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Course creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->except(['thumbnail_image', 'banner_image', 'gallery_images', 'prospectus_file'])
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create course. Please try again.');
        }
    }

    

    public function show(Course $course)
    {
        $course->load('category');
        return view('admin.course.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.course.form', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        try {
            $validated = $request->validate([
                // Basic Info
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:courses,slug,' . $course->id,
                'short_description' => 'nullable|string|max:500',
                'description' => 'required|string',
                
                // Course Details
                'course_type' => 'required|string|max:50',
                'course_mode' => 'required|in:online,offline,both',
                'duration' => 'required|integer|min:1',
                'duration_unit' => 'required|in:hours,days,weeks,months,year',
                'learning_format' => 'nullable|string|max:50',
                'total_sessions' => 'nullable|string|regex:/^\d{4}-\d{4}$/',
                'course_affiliation' => 'nullable|string|max:255',
                'key_features' => 'nullable|string',
                'skills_covered' => 'nullable|string',
                'course_advantage' => 'nullable|string',
                'syllabus' => 'nullable|string',
                
                // Pricing
                'fees' => 'required|numeric|min:0',
                'discounted_fees' => 'nullable|numeric|min:0',
                'admission_fee' => 'nullable|numeric|min:0',
                'discount_percentage' => 'nullable|numeric|min:0|max:100',
                'currency' => 'required|string|size:3',
                
                // Admission
                'education_qualification' => 'nullable|array',
                'education_qualification.*' => 'string',
                'min_age' => 'nullable|integer|min:0',
                'max_age' => 'nullable|integer|min:0',
                'entrance_exam' => 'nullable|string|max:255',
                'course_outcomes' => 'nullable|array',
                'course_outcomes.*' => 'string',
                'eligibility_criteria' => 'nullable|array',
                'eligibility_criteria.*' => 'string',
                
                // Career
                'career_scope' => 'nullable|string',
                'industry_trend' => 'nullable|string',
                'employment_areas' => 'nullable|string',
                'expected_market_size' => 'nullable|string|max:255',
                'salary_range' => 'nullable|string|max:255',
                
                // Highlights & Partners
                'course_highlights' => 'nullable|array',
                'course_highlights.*' => 'string',
                'highlight_icons' => 'nullable|array',
                'highlight_icons.*' => 'string',
                'partner_names' => 'nullable|array',
                'partner_names.*' => 'string',
                'partner_websites' => 'nullable|array',
                'partner_websites.*' => 'url',
                'partner_logos' => 'nullable|array',
                'partner_logos.*' => 'string',
                
                // Media
                'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'gallery_images' => 'nullable|array',
                'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'prospectus_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
                
                // Settings
                'level' => 'required|in:beginner,intermediate,advanced',
                'course_status' => 'required|in:draft,published,archived',
                'order' => 'nullable|integer|min:0',
                'featured' => 'nullable|boolean',
                'has_prospectus' => 'nullable|boolean',
                'allow_reviews' => 'nullable|boolean',
                
                // SEO
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string|max:255',
                
                // For removing files
                'remove_thumbnail' => 'nullable|boolean',
                'remove_banner' => 'nullable|boolean',
                'remove_gallery_images' => 'nullable|array',
                'remove_prospectus' => 'nullable|boolean',
            ]);
            
            // Handle course highlights with icons
            if ($request->has('course_highlights')) {
                $highlights = [];
                foreach ($request->course_highlights as $index => $highlight) {
                    if (!empty(trim($highlight))) {
                        $highlights[] = [
                            'text' => $highlight,
                            'icon' => $request->highlight_icons[$index] ?? 'fas fa-check'
                        ];
                    }
                }
                $validated['course_highlights'] = $highlights;
            } else {
                $validated['course_highlights'] = $course->course_highlights;
            }
            
            // Handle academic partners
            if ($request->has('partner_names')) {
                $partners = [];
                foreach ($request->partner_names as $index => $name) {
                    if (!empty(trim($name))) {
                        $partners[] = [
                            'name' => $name,
                            'website' => $request->partner_websites[$index] ?? null,
                            'logo' => $request->partner_logos[$index] ?? null
                        ];
                    }
                }
                $validated['academic_partners'] = $partners;
            } else {
                $validated['academic_partners'] = $course->academic_partners;
            }
            
            // Handle array fields
            $validated['course_outcomes'] = $this->cleanArray($request->course_outcomes ?? []);
            $validated['eligibility_criteria'] = $this->cleanArray($request->eligibility_criteria ?? []);
            $validated['education_qualification'] = $this->cleanArray($request->education_qualification ?? []);
            
            // Handle skills covered (comma separated string to array)
            if ($request->filled('skills_covered')) {
                $skills = array_map('trim', explode(',', $request->skills_covered));
                $validated['skills_covered'] = array_filter($skills, function($skill) {
                    return !empty($skill);
                });
            } else {
                $validated['skills_covered'] = $course->skills_covered;
            }
            
            // Handle employment areas
            if ($request->filled('employment_areas')) {
                $areas = array_map('trim', explode(',', $request->employment_areas));
                $validated['employment_areas'] = array_filter($areas, function($area) {
                    return !empty($area);
                });
            } else {
                $validated['employment_areas'] = $course->employment_areas;
            }
            
            // Handle job roles
            if ($request->filled('job_roles')) {
                $roles = array_map('trim', explode(',', $request->job_roles));
                $validated['job_roles'] = array_filter($roles, function($role) {
                    return !empty($role);
                });
            } else {
                $validated['job_roles'] = $course->job_roles;
            }
            
            // Handle top recruiters
            if ($request->filled('top_recruiters')) {
                $recruiters = array_map('trim', explode(',', $request->top_recruiters));
                $validated['top_recruiters'] = array_filter($recruiters, function($recruiter) {
                    return !empty($recruiter);
                });
            } else {
                $validated['top_recruiters'] = $course->top_recruiters;
            }
            
            // Handle thumbnail image
            if ($request->has('remove_thumbnail') && $request->remove_thumbnail == '1') {
                // Remove current thumbnail
                if ($course->thumbnail_image) {
                    Storage::disk('public')->delete($course->thumbnail_image);
                }
                $validated['thumbnail_image'] = null;
            } elseif ($request->hasFile('thumbnail_image')) {
                // Upload new thumbnail
                if ($course->thumbnail_image) {
                    Storage::disk('public')->delete($course->thumbnail_image);
                }
                $validated['thumbnail_image'] = $request->file('thumbnail_image')->store('courses/thumbnails', 'public');
            } else {
                // Keep existing thumbnail
                $validated['thumbnail_image'] = $course->thumbnail_image;
            }
            
            // Handle banner image
            if ($request->has('remove_banner') && $request->remove_banner == '1') {
                // Remove current banner
                if ($course->banner_image) {
                    Storage::disk('public')->delete($course->banner_image);
                }
                $validated['banner_image'] = null;
            } elseif ($request->hasFile('banner_image')) {
                // Upload new banner
                if ($course->banner_image) {
                    Storage::disk('public')->delete($course->banner_image);
                }
                $validated['banner_image'] = $request->file('banner_image')->store('courses/banners', 'public');
            } else {
                // Keep existing banner
                $validated['banner_image'] = $course->banner_image;
            }
            
            // Handle gallery images
            $currentGalleryImages = $course->gallery_images ?? [];
            // Ensure we have an array (database might store JSON string)
            if (is_string($currentGalleryImages)) {
                $decoded = json_decode($currentGalleryImages, true);
                $currentGalleryImages = is_array($decoded) ? $decoded : [];
            } elseif (!is_array($currentGalleryImages)) {
                $currentGalleryImages = [];
            }
            
            // Remove selected gallery images
            if ($request->has('remove_gallery_images')) {
                $imagesToRemove = $request->remove_gallery_images;
                foreach ($imagesToRemove as $imageIndex) {
                    if (isset($currentGalleryImages[$imageIndex])) {
                        Storage::disk('public')->delete($currentGalleryImages[$imageIndex]);
                        unset($currentGalleryImages[$imageIndex]);
                    }
                }
                // Re-index array
                $currentGalleryImages = array_values($currentGalleryImages);
            }
            
            // Add new gallery images
            if ($request->hasFile('gallery_images')) {
                $newGalleryImages = [];
                foreach ($request->file('gallery_images') as $image) {
                    $newGalleryImages[] = $image->store('courses/gallery', 'public');
                }
                // Merge existing images with new ones
                $validated['gallery_images'] = array_merge($currentGalleryImages, $newGalleryImages);
            } else {
                // Keep existing gallery images
                $validated['gallery_images'] = $currentGalleryImages;
            }
            
            // Handle prospectus file
            if ($request->has('remove_prospectus') && $request->remove_prospectus == '1') {
                // Remove current prospectus
                if ($course->prospectus_file) {
                    Storage::disk('public')->delete($course->prospectus_file);
                }
                $validated['prospectus_file'] = null;
                $validated['has_prospectus'] = false;
            } elseif ($request->hasFile('prospectus_file')) {
                // Upload new prospectus
                if ($course->prospectus_file) {
                    Storage::disk('public')->delete($course->prospectus_file);
                }
                $validated['prospectus_file'] = $request->file('prospectus_file')->store('courses/prospectus', 'public');
                $validated['has_prospectus'] = true;
            } else {
                // Keep existing prospectus
                $validated['prospectus_file'] = $course->prospectus_file;
                $validated['has_prospectus'] = $course->has_prospectus;
            }
            
            // Handle boolean fields
            $validated['featured'] = $request->has('featured');
            $validated['has_prospectus'] = $request->has('has_prospectus');
            $validated['allow_reviews'] = $request->has('allow_reviews');
            
            // Map course_status to status
            $validated['status'] = $validated['course_status'];
            unset($validated['course_status']);
            
            // Calculate display price if discount is applied
            if ($validated['discount_percentage'] > 0) {
                $validated['display_price'] = $validated['fees'] - ($validated['fees'] * $validated['discount_percentage'] / 100);
            } else {
                $validated['display_price'] = $validated['fees'];
            }
            
            // Update course
            $course->update($validated);
            
            return redirect()->route('admin.courses.index')
                ->with('success', 'Course updated successfully!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Course update failed: ' . $e->getMessage(), [
                'exception' => $e,
                'course_id' => $course->id,
                'request_data' => $request->except([
                    'thumbnail_image', 
                    'banner_image', 
                    'gallery_images', 
                    'prospectus_file',
                    'password',
                    'password_confirmation'
                ])
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update course. Please try again. Error: ' . $e->getMessage());
        }
    }

    private function cleanArray($array)
    {
        return array_values(array_filter(array_map('trim', $array), function($item) {
            return !empty($item);
        }));
    }

    public function destroy(Course $course)
    {
        // Delete associated files
        if ($course->thumbnail_image) {
            Storage::disk('public')->delete($course->thumbnail_image);
        }
        
        if ($course->gallery_images) {
            foreach ($course->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function deleteGalleryImage(Course $course, $index)
    {
        if ($course->gallery_images && isset($course->gallery_images[$index])) {
            Storage::disk('public')->delete($course->gallery_images[$index]);
            $galleryImages = $course->gallery_images;
            unset($galleryImages[$index]);
            $course->update(['gallery_images' => array_values($galleryImages)]);
        }

        return response()->json(['success' => true]);
    }

    // Export to PDF
    private function exportPDF($courses)
    {
        $pdf = Pdf::loadView('admin.course.exports.pdf', [
            'courses' => $courses,
            'title' => 'Courses Report - ' . date('Y-m-d')
        ]);
        
        return $pdf->download('courses-report-' . date('Y-m-d') . '.pdf');
    }
    
    // Export to CSV
    private function exportCSV($courses)
    {
        $fileName = 'courses-' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $callback = function() use ($courses) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fwrite($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            
            // Headers
            fputcsv($file, [
                'ID',
                'Title',
                'Course Type',
                'Course Mode',
                'Category',
                'Duration',
                'Fees',
                'Status',
                'Featured',
                'Created At'
            ]);
            
            // Data
            foreach ($courses as $course) {
                fputcsv($file, [
                    $course->id,
                    $course->title,
                    $course->course_type,
                    $course->course_mode,
                    $course->category->name ?? 'N/A',
                    $course->duration_text,
                    $course->formatted_fees,
                    ucfirst($course->status),
                    $course->featured ? 'Yes' : 'No',
                    $course->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    // Export for Print
    private function exportPrint($courses)
    {
        return view('admin.course.exports.print', [
            'courses' => $courses,
            'title' => 'Courses Report - ' . date('Y-m-d')
        ]);
    }
}