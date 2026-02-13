<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhyJoinFeature;
use App\Models\Banner;
use App\Models\Testimonial;
use App\Models\RegisterContect;
use App\Models\ExpertTip;
use App\Models\CollegeAccountDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class WhyjoinUs extends Controller
{
    public function getFeatures()
    {
        try {
            // Sort by sort_order if you have that field, otherwise by creation date
            $features = WhyJoinFeature::orderBy('created_at', 'desc')
                                    ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Why join us features retrieved successfully',
                'data' => $features,
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch features',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function getContent()
    {
        try {
            $content = RegisterContect::orderBy('created_at', 'desc')
                                    ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Register Content retrieved successfully',
                'data' => $content,
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch Content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBanner()
    {
        try {
            // Get active banners ordered by order field (for display order)
            $banners = Banner::where('status', true)
                            ->orderBy('order', 'asc')
                            ->get(['id', 'title', 'description', 'image' , 'order']);
            
            // Add full image URL to each banner
            $banners->transform(function ($banner) {
                if ($banner->image) {
                    $banner->image_url = $banner->image;
                } else {
                    $banner->image_url = null;
                }
                // Remove the original image path for cleaner response
                unset($banner->image);
                return $banner;
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Banners retrieved successfully',
                'data' => $banners,
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Banner API Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch banners',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }


    // API Method for frontend
    public function getTestimonials()
    {
        try {
            $testimonials = Testimonial::where('status', true)
                ->orderBy('order', 'asc')
                ->get();
            
            // Add image URLs
            $testimonials->transform(function ($testimonial) {
                return [
                    'id' => $testimonial->id,
                    'title' => $testimonial->title,
                    'subtitle' => $testimonial->subtitle,
                    'description' => $testimonial->description,
                    'image_url' => $testimonial->image ? $testimonial->image : null,
                  
                    'order' => $testimonial->order,
                    'created_at' => $testimonial->created_at->toDateTimeString(),
                ];
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Testimonials retrieved successfully',
                'data' => $testimonials,
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Testimonials API Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch testimonials',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }


    public function getExpert()
    {
        try {
            $expertTips = ExpertTip::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Expert tips retrieved successfully',
                'data' => $expertTips,
                'meta' => [
                    'total' => $expertTips->count(),
                    'timestamp' => now()->toDateTimeString()
                ]
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Expert Tips API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch expert tips',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    public function getAccountDetails($college_id)
    {
        try {
            $accountDetails = CollegeAccountDetail::where('college_id', $college_id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'College Account Details retrieved successfully',
                'data' => $accountDetails,
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch Account Details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
