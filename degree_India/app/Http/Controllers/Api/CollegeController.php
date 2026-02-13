<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CollegeController extends Controller
{
    
    public function getColleges()
    {
        return response()->json([
            'colleges' => College::where('status', 'published')->paginate(10)
        ]);
    }

    public function getCollegeById($id)
    {
        try {
            $college = College::where('id', $id)
                ->where('status', 'published')
                ->first();

            if (!$college) {
                return response()->json([
                    'success' => false,
                    'message' => 'College not found or not published'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'college' => $college
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching college by ID: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching college details',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function searchColleges(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'search' => 'nullable|string|max:255',
                'page' => 'nullable|integer|min:1',
                'per_page' => 'nullable|integer|min:1|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $search = $request->input('search');
            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', 1);

            // Start query
            $query = College::where('status', 'published');

            // Apply search filter if provided
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            // Execute query with pagination
            $colleges = $query->orderBy('name')->paginate($perPage, ['*'], 'page', $page);

            if ($colleges->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No colleges found',
                    'colleges' => [],
                    'pagination' => [
                        'total' => 0,
                        'per_page' => $perPage,
                        'current_page' => $page,
                        'last_page' => 0
                    ]
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Colleges retrieved successfully',
                'colleges' => $colleges->items()
                
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error searching colleges: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error searching colleges',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    
    public function searchCollegesAdvanced(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'search' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'course_type' => 'nullable|string|max:255',
                'min_fees' => 'nullable|numeric|min:0',
                'max_fees' => 'nullable|numeric|min:0',
                'rating_min' => 'nullable|numeric|min:0|max:5',
                'sort_by' => 'nullable|in:name,rating,fees,created_at',
                'sort_order' => 'nullable|in:asc,desc',
                'page' => 'nullable|integer|min:1',
                'per_page' => 'nullable|integer|min:1|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $search = $request->input('search');
            $location = $request->input('location');
            $courseType = $request->input('course_type');
            $minFees = $request->input('min_fees');
            $maxFees = $request->input('max_fees');
            $ratingMin = $request->input('rating_min');
            $sortBy = $request->input('sort_by', 'name');
            $sortOrder = $request->input('sort_order', 'asc');
            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', 1);

            // Start query
            $query = College::where('status', 'published');

            // Apply search filter if provided
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%")
                      ->orWhere('courses_offered', 'LIKE', "%{$search}%");
                });
            }

            // Apply location filter
            if ($location) {
                $query->where('location', 'LIKE', "%{$location}%");
            }

            // Apply course type filter (assuming you have a course_type field)
            if ($courseType) {
                $query->where('course_type', $courseType);
            }

            // Apply fees range filter
            if ($minFees) {
                $query->where('fees', '>=', $minFees);
            }
            if ($maxFees) {
                $query->where('fees', '<=', $maxFees);
            }

            // Apply rating filter
            if ($ratingMin) {
                $query->where('rating', '>=', $ratingMin);
            }

            // Apply sorting
            $query->orderBy($sortBy, $sortOrder);

            // Execute query with pagination
            $colleges = $query->paginate($perPage, ['*'], 'page', $page);

            if ($colleges->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No colleges found matching your criteria',
                    'colleges' => [],
                    'filters_applied' => [
                        'search' => $search,
                        'location' => $location,
                        'course_type' => $courseType,
                        'min_fees' => $minFees,
                        'max_fees' => $maxFees,
                        'rating_min' => $ratingMin
                    ],
                    'pagination' => [
                        'total' => 0,
                        'per_page' => $perPage,
                        'current_page' => $page,
                        'last_page' => 0
                    ]
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Colleges retrieved successfully',
                'colleges' => $colleges->items()
                
                
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in advanced college search: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error searching colleges',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }


}
