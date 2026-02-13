<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ExpertTip extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'video_link',
        'thumbnail',
        'is_active',
        'sort_order'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
            
            // Auto-generate thumbnail when creating
            if ($model->video_link && !$model->thumbnail) {
                $model->thumbnail = $model->generateThumbnailFromVideoLink();
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = Str::slug($model->title);
            }
            
            // Auto-generate thumbnail when video link changes OR no thumbnail exists
            if ($model->isDirty('video_link') && $model->video_link) {
                $model->thumbnail = $model->generateThumbnailFromVideoLink();
            }
        });
    }

    /**
     * Generate thumbnail from video link
     */
    public function generateThumbnailFromVideoLink(): string
    {
        $videoLink = $this->video_link;
        
        // For YouTube links
        if (str_contains($videoLink, 'youtube.com') || str_contains($videoLink, 'youtu.be')) {
            return $this->generateYouTubeThumbnail($videoLink);
        }
        
        // For Vimeo links
        if (str_contains($videoLink, 'vimeo.com')) {
            return $this->generateVimeoThumbnail($videoLink);
        }
        
        // For Dailymotion
        if (str_contains($videoLink, 'dailymotion.com')) {
            return $this->generateDailymotionThumbnail($videoLink);
        }
        
        // Return default thumbnail
        return 'defaults/expert-tip.jpg';
    }

    /**
     * Generate YouTube thumbnail
     */
    private function generateYouTubeThumbnail(string $url): string
    {
        $videoId = '';
        
        // Extract video ID from different YouTube URL formats
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }
        
        if ($videoId) {
            // Try maxresdefault first, if not available try hqdefault
            return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
        }
        
        return 'defaults/expert-tip.jpg';
    }

   
    private function generateVimeoThumbnail(string $url): string
    {
        $videoId = '';
        
        // Extract video ID from Vimeo URL
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        
        if ($videoId) {
            // Use Vimeo oEmbed API to get thumbnail
            try {
                $oembedUrl = "https://vimeo.com/api/oembed.json?url=https://vimeo.com/{$videoId}";
                $data = @file_get_contents($oembedUrl);
                
                if ($data !== false) {
                    $response = json_decode($data, true);
                    if (isset($response['thumbnail_url'])) {
                        return $response['thumbnail_url'];
                    }
                }
            } catch (\Exception $e) {
                // Fallback to placeholder
            }
        }
        
        return 'defaults/expert-tip.jpg';
    }

   
    private function generateDailymotionThumbnail(string $url): string
    {
        $videoId = '';
        
        if (preg_match('/dailymotion\.com\/video\/([a-zA-Z0-9]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        
        if ($videoId) {
            return "https://www.dailymotion.com/thumbnail/video/{$videoId}";
        }
        
        return 'defaults/expert-tip.jpg';
    }

   
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            // Check if it's a full URL or local path
            if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
                return $this->thumbnail;
            }
            
            // Check if file exists in storage
            if (Storage::disk('public')->exists($this->thumbnail)) {
                return asset('storage/' . $this->thumbnail);
            }
        }
        
        // Return default image
        return asset('images/default-expert-tip.jpg');
    }

   
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }
}