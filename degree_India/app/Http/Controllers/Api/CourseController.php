<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;


class CourseController extends Controller
{
    //

    public function getCategory()
    {
        return response()->json([
            'categories' => Category::where('status', 'active')->paginate(10)
        ]);
    }

    public function searchCategoriesByName(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|string'
            ]);
            
            $categories = Category::where('status', 'active')
                ->where('slug', 'like', '%' . $request->slug . '%')
                ->paginate(10);
            
            return response()->json([
                'success' => true,
                'message' => 'Categories filtered by name retrieved successfully',
                'categories' => $categories
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllCources(){
       return response()->json(
        [ 'status'=> true,
           'message' => 'Get All Courses Sucessfully',
            'courses' => Course::where('status', 'published')->paginate(10)
        ]); 
    }


    public function getCourses($college_id = null, $category_id = null)
    {
        // Convert "null" string to null (if using route parameters)
        $college_id  = $college_id === 'null' ? null : $college_id;
        $category_id = $category_id === 'null' ? null : $category_id;
    
        // If college_id is provided
        if ($college_id) {
            $college = College::with(['courses' => function ($q) use ($category_id) {
                if ($category_id) {
                    $q->where('category_id', $category_id);
                }
                $q->where('status', 'published');
            }])->find($college_id);
    
            if (!$college) {
                return response()->json([
                    'status' => false,
                    'message' => 'College not found',
                ], 404);
            }
    
            return response()->json([
                'status'  => true,
                'college' => $college->only(['id', 'name']),
                'courses' => $college->courses,
            ]);
        }
    
        // If no college_id → return all courses (optional category filter)
        $courses = Course::with('college')
            ->where('status', 'published')
            ->when($category_id, fn ($q) => $q->where('category_id', $category_id))
            ->get();
    
        return response()->json([
            'status'  => true,
            'courses' => $courses,
        ]);
    }

    public function getCourseDetail($course_id = null)
    {
        // Check if course_id is provided
        if (!$course_id) {
            return response()->json([
                'status' => false,
                'message' => 'Course ID is required',
            ], 400);
        }

        // Fetch course with related data
        $course = Course::with(['category'])->find($course_id);

        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => 'Course not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'course' => $course,
        ]);
    }


    public function getCourseByCategory($category_id = null)
    {
        $category_id = ($category_id === 'null' || $category_id === '') ? null : $category_id;
        
        $query = Course::where('status', 'published')->where('category_id', $category_id); 
            
        $courses = $query->get();
        
        return response()->json([
            'status'  => true,
            'message' => $category_id 
                ? 'Get Courses by category successfully' 
                : 'Get all courses successfully',
            'courses' => $courses,
            'count'   => $courses->count()
        ]);
    }


    // CourseController.php - Add this method


    public function getOffers()
    {
        try {
            // Fetch courses that have discounts and eager load associated colleges & category
            $courses = Course::with(['colleges:id,name', 'category:id,name'])
                ->where('status', 'published')
                ->whereNotNull('discounted_fees')
                ->where('discounted_fees', '>', 0)
                ->orderBy('discount_percentage', 'desc')
                ->get();

            // Build a collection of offer entries for each college-course pair
            $offers = $courses->flatMap(function ($course) {
                // If a course isn't associated with any college, still include it with null college
                if ($course->colleges->isEmpty()) {
                    return [
                        [
                            'course_id' => $course->id,
                            'course_title' => $course->title,
                            'course_slug' => $course->slug,
                            'college_id' => null,
                            'college_name' => null,
                            'category_id' => $course->category?->id,
                            'category_name' => $course->category?->name,
                            'fees' => number_format($course->fees, 2, '.', ''),
                            'discounted_fees' => number_format($course->discounted_fees, 2, '.', ''),
                            'admission_fee' => number_format($course->admission_fee ?? 0, 2, '.', ''),
                            'discount_percentage' => $course->discount_percentage ?? 0,
                            'course_type' => $course->course_type,
                            'course_mode' => $course->course_mode,
                            'duration' => $course->duration . ' ' . $course->duration_unit,
                            'thumbnail' => $course->thumbnail_image,
                            'banner' => $course->banner_image,
                            'currency' => $course->currency,
                            'savings_amount' => number_format($course->savings_amount, 2, '.', ''),
                            'total_fees_with_admission' => number_format(
                                $course->discounted_fees + ($course->admission_fee ?? 0),
                                2, '.', ''
                            )
                        ]
                    ];
                }

                return $course->colleges->map(function ($college) use ($course) {
                    return [
                        'course_id' => $course->id,
                        'course_title' => $course->title,
                        'course_slug' => $course->slug,
                        'college_id' => $college->id,
                        'college_name' => $college->name,
                        'category_id' => $course->category?->id,
                        'category_name' => $course->category?->name,
                        'fees' => number_format($course->fees, 2, '.', ''),
                        'discounted_fees' => number_format($course->discounted_fees, 2, '.', ''),
                        'admission_fee' => number_format($course->admission_fee ?? 0, 2, '.', ''),
                        'discount_percentage' => $course->discount_percentage ?? 0,
                        'course_type' => $course->course_type,
                        'course_mode' => $course->course_mode,
                        'duration' => $course->duration . ' ' . $course->duration_unit,
                        'thumbnail' => $course->thumbnail_image,
                        'banner' => $course->banner_image,
                        'currency' => $course->currency,
                        'savings_amount' => number_format($course->savings_amount, 2, '.', ''),
                        'total_fees_with_admission' => number_format(
                            $course->discounted_fees + ($course->admission_fee ?? 0),
                            2, '.', ''
                        )
                    ];
                })->values();
            });

            // Group offers by college for better organization
            $offersByCollege = $offers->groupBy('college_id')->map(function ($collegeCourses) {
                return [
                    'college_id' => $collegeCourses->first()['college_id'],
                    'college_name' => $collegeCourses->first()['college_name'],
                    'total_offers' => $collegeCourses->count(),
                    'offers' => $collegeCourses->values()
                ];
            })->values();

            $totalSavings = $offers->sum(function ($o) {
                return (float) str_replace(',', '', $o['savings_amount']);
            });

            return response()->json([
                'status' => true,
                'message' => 'Special offers retrieved successfully',
                'data' => [
                    'total_offers' => $offers->count(),
                    'all_offers' => $offers->values(),
                    'offers_by_college' => $offersByCollege,
                    'summary' => [
                        'total_discounted_courses' => $offers->count(),
                        'highest_discount' => $offers->max('discount_percentage') ?? 0,
                        'average_discount' => round($offers->avg('discount_percentage') ?? 0, 2),
                        'total_savings_possible' => number_format($totalSavings, 2, '.', '')
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve offers',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function getOffersPaginated(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            
            // Get paginated courses with discounts and eager load colleges
            $courses = Course::with(['colleges:id,name', 'category:id,name'])
                ->where('status', 'published')
                ->whereNotNull('discounted_fees')
                ->where('discounted_fees', '>', 0)
                ->orderBy('discount_percentage', 'desc')
                ->paginate($perPage)
                ->through(function ($course) {
                    $college = $course->colleges->first();
                    return [
                        'course_id' => $course->id,
                        'course_title' => $course->title,
                        'course_slug' => $course->slug,
                        'college_id' => $college?->id,
                        'college_name' => $college?->name,
                        'category_id' => $course->category?->id,
                        'category_name' => $course->category?->name,
                        'fees' => number_format($course->fees, 2, '.', ''),
                        'discounted_fees' => number_format($course->discounted_fees, 2, '.', ''),
                        'admission_fee' => number_format($course->admission_fee ?? 0, 2, '.', ''),
                        'discount_percentage' => $course->discount_percentage ?? 0,
                        'currency' => $course->currency,
                        'savings_amount' => number_format($course->savings_amount, 2, '.', '')
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => 'Special offers retrieved successfully',
                'data' => $courses
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve offers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function getOffersByCollege($college_id)
    {
        try {
            $college = College::find($college_id);
            
            if (!$college) {
                return response()->json([
                    'status' => false,
                    'message' => 'College not found'
                ], 404);
            }

            $courses = $college->courses()
                ->with('category:id,name')
                ->where('status', 'published')
                ->whereNotNull('discounted_fees')
                ->where('discounted_fees', '>', 0)
                ->orderBy('discount_percentage', 'desc')
                ->get()
                ->map(function ($course) use ($college) {
                    $fees = $course->pivot->fees ?? $course->fees;
                    return [
                        'course_id' => $course->id,
                        'course_title' => $course->title,
                        'course_slug' => $course->slug,
                        'college_id' => $college->id,
                        'college_name' => $college->name,
                        'category_id' => $course->category?->id,
                        'category_name' => $course->category?->name,
                        'fees' => number_format($fees, 2, '.', ''),
                        'discounted_fees' => number_format($course->discounted_fees, 2, '.', ''),
                        'admission_fee' => number_format($course->admission_fee ?? 0, 2, '.', ''),
                        'discount_percentage' => $course->discount_percentage ?? 0,
                        'currency' => $course->currency,
                        'savings_amount' => number_format($fees - $course->discounted_fees, 2, '.', '')
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => 'Special offers for ' . $college->name . ' retrieved successfully',
                'data' => [
                    'college' => [
                        'id' => $college->id,
                        'name' => $college->name
                    ],
                    'total_offers' => $courses->count(),
                    'offers' => $courses,
                    'summary' => [
                        'highest_discount' => $courses->max('discount_percentage') ?? 0,
                        'average_discount' => round($courses->avg('discount_percentage') ?? 0, 2),
                        'total_savings' => number_format($courses->sum('savings_amount'), 2, '.', '')
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve offers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
