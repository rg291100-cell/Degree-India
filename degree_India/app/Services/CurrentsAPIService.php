<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CurrentsAPIService
{
    private $apiKey;
    private $baseUrl = 'https://api.currentsapi.services/v1';
    
    public function __construct()
    {
        $this->apiKey = 'KsSO2OGU7rUfTkqHT07Ybi6uiYt0sJKb-bqEIoB58HruxvxM';
    }
    
   
    public function getEducationNews($limit = 20)
    {
        try {
            // Disable SSL verification for testing
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 60,
            ])->get($this->baseUrl . '/latest-news', [
                'apiKey' => $this->apiKey,
                'language' => 'en',
                'category' => 'education',
                'limit' => $limit
            ]);
            
            Log::info('CurrentsAPI Response Status: ' . $response->status());
            
            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'total' => count($data['news'] ?? []),
                    'news' => $data['news'] ?? [],
                    'meta' => [
                        'source' => 'CurrentsAPI',
                        'api_key' => substr($this->apiKey, 0, 10) . '...'
                    ]
                ];
            }
            
            Log::error('CurrentsAPI Error: ' . $response->body());
            
            return [
                'success' => false,
                'message' => 'API call failed',
                'status_code' => $response->status(),
                'error' => $response->body()
            ];
            
        } catch (\Exception $e) {
            Log::error('CurrentsAPI Exception: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ];
        }
    }
    
    
    public function searchNews($filters = [], $limit = 20)
    {
        try {
            // Prepare API parameters
            $params = [
                'apiKey' => $this->apiKey,
                'language' => 'en',
                'limit' => $limit
            ];
            
            // Add filters if provided
            if (isset($filters['keywords'])) {
                $params['keywords'] = $filters['keywords'];
            }
            
            if (isset($filters['title'])) {
                $params['title'] = $filters['title'];
            }
            
            if (isset($filters['author'])) {
                $params['author'] = $filters['author'];
            }
            
            if (isset($filters['country'])) {
                $params['country'] = $filters['country'];
            }
            
            if (isset($filters['category'])) {
                $params['category'] = $filters['category'];
            }
            
            if (isset($filters['from_date'])) {
                $params['start_date'] = $filters['from_date'];
            }
            
            if (isset($filters['to_date'])) {
                $params['end_date'] = $filters['to_date'];
            }
            
            if (isset($filters['sort_by'])) {
                // Convert sort_by to API parameter if needed
                // CurrentsAPI uses 'latest' or 'oldest'
                if ($filters['sort_by'] == 'date_newest') {
                    $params['type'] = 'latest';
                } elseif ($filters['sort_by'] == 'date_oldest') {
                    $params['type'] = 'oldest';
                }
            }
            
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 60,
            ])->get($this->baseUrl . '/search', $params);
            
            Log::info('CurrentsAPI Search Response Status: ' . $response->status());
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Apply additional filtering if needed
                $news = $data['news'] ?? [];
                
                // Apply category filter if provided
                if (isset($filters['category_filter'])) {
                    $news = array_filter($news, function($item) use ($filters) {
                        return stripos($item['category'] ?? '', $filters['category_filter']) !== false ||
                               stripos($item['title'] ?? '', $filters['category_filter']) !== false ||
                               stripos($item['description'] ?? '', $filters['category_filter']) !== false;
                    });
                }
                
                return [
                    'success' => true,
                    'total' => count($news),
                    'news' => array_values($news), // Reset array keys
                    'meta' => [
                        'source' => 'CurrentsAPI',
                        'api_key' => substr($this->apiKey, 0, 10) . '...',
                        'filters_applied' => $filters
                    ]
                ];
            }
            
            Log::error('CurrentsAPI Search Error: ' . $response->body());
            
            return [
                'success' => false,
                'message' => 'API call failed',
                'status_code' => $response->status(),
                'error' => $response->body()
            ];
            
        } catch (\Exception $e) {
            Log::error('CurrentsAPI Search Exception: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ];
        }
    }
    
    /**
     * Get news by country
     */
    public function getNewsByCountry($country, $limit = 20)
    {
        return $this->searchNews(['country' => $country], $limit);
    }
    
    /**
     * Get news by category
     */
    public function getNewsByCategory($category, $limit = 20)
    {
        return $this->searchNews(['category' => $category], $limit);
    }
    
    /**
     * Simple search by keyword
     */
    public function searchByKeyword($keyword, $limit = 20)
    {
        return $this->searchNews(['keywords' => $keyword], $limit);
    }
}