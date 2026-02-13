<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CurrentsAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationNewsController extends Controller
{
    protected $newsService;
    
    public function __construct(CurrentsAPIService $newsService)
    {
        $this->newsService = $newsService;
    }
    
  
    public function searchNews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'nullable|string|max:100',
            'title' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:100',
            'country' => 'nullable|string|size:2',
            'category' => 'nullable|string|max:50',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'sort_by' => 'nullable|in:date_newest,date_oldest,title_asc,title_desc',
            'limit' => 'nullable|integer|min:1|max:100'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Prepare filters
        $filters = [
            'keywords' => $request->keyword,
            'title' => $request->title,
            'author' => $request->author,
            'country' => $request->country,
            'category' => $request->category,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'sort_by' => $request->sort_by,
            'category_filter' => $request->category_filter
        ];
        
        // Remove empty filters
        $filters = array_filter($filters);
        
        $limit = $request->limit ?? 20;
        
        // Get news
        $result = $this->newsService->searchNews($filters, $limit);
        
        return response()->json($result);
    }
    
    
    public function searchByKeyword($keyword, Request $request)
    {
        $limit = $request->get('limit', 20);
        
        $result = $this->newsService->searchByKeyword($keyword, $limit);
        
        return response()->json($result);
    }
    
    /**
     * Get latest education news
     */
    public function getLatestEducationNews(Request $request)
    {
        $limit = $request->get('limit', 20);
        
        $result = $this->newsService->getEducationNews($limit);
        
        return response()->json($result);
    }
    
    /**
     * Get news by country
     */
    public function getNewsByCountry($country, Request $request)
    {
        $limit = $request->get('limit', 20);
        
        $result = $this->newsService->getNewsByCountry($country, $limit);
        
        return response()->json($result);
    }
    
    /**
     * Get news by category
     */
    public function getNewsByCategory($category, Request $request)
    {
        $limit = $request->get('limit', 20);
        
        $result = $this->newsService->getNewsByCategory($category, $limit);
        
        return response()->json($result);
    }
    
    /**
     * Get news categories
     */
    public function getCategories()
    {
        $categories = [
            'education', 'technology', 'sports', 'entertainment',
            'business', 'health', 'science', 'politics',
            'world', 'national', 'local'
        ];
        
        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }
    
    /**
     * Health check endpoint
     */
    public function healthCheck()
    {
        return response()->json([
            'success' => true,
            'message' => 'News API is running',
            'timestamp' => now()->toDateTimeString(),
            'service' => 'CurrentsAPI News Service'
        ]);
    }
    
    /**
     * Quick test endpoint
     */
    public function testApi()
    {
        $result = $this->newsService->searchNews(['keywords' => 'education'], 5);
        
        return response()->json([
            'api_status' => 'active',
            'test_result' => $result['success'] ? 'working' : 'failed',
            'sample_count' => $result['success'] ? count($result['news'] ?? []) : 0,
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}