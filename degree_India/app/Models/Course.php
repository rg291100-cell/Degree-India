<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'short_description', 'description',
        'course_type', 'course_mode', 'duration', 'duration_unit', 'learning_format',
        'total_sessions', 'course_affiliation', 'key_features', 'skills_covered',
        'course_advantage', 'fees', 'discounted_fees', 'admission_fee', 'discount_percentage',
        'currency', 'education_qualification', 'min_age', 'max_age', 'entrance_exam',
        'industry_trend', 'employment_areas', 'expected_market_size', 'salary_range',
        'career_scope', 'course_outcomes', 'eligibility_criteria', 'thumbnail_image',
        'banner_image', 'gallery_images', 'course_highlights', 'academic_partners',
        'syllabus', 'level', 'status', 'order', 'featured', 'has_prospectus',
        'prospectus_file', 'enrollment_count', 'rating', 'total_reviews',
        'likes_count', 'meta_title', 'meta_description', 'meta_keywords'
    ];

    protected $casts = [
        'course_outcomes' => 'array',
        'eligibility_criteria' => 'array',
        'gallery_images' => 'array',
        'course_highlights' => 'array',
        'academic_partners' => 'array',
        'skills_covered' => 'array',
        'employment_areas' => 'array',
        'education_qualification' => 'array',
        'featured' => 'boolean',
        'has_prospectus' => 'boolean',
        'fees' => 'decimal:2',
        'discounted_fees' => 'decimal:2',
        'admission_fee' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Accessors
    public function getFormattedFeesAttribute()
    {
        return $this->currency . ' ' . number_format($this->fees, 2);
    }

    public function getFormattedDiscountedFeesAttribute()
    {
        if ($this->discounted_fees) {
            return $this->currency . ' ' . number_format($this->discounted_fees, 2);
        }
        return null;
    }

    public function getDurationTextAttribute()
    {
        return $this->duration . ' ' . str($this->duration_unit)->title();
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail_image && Storage::disk('public')->exists($this->thumbnail_image)) {
            return Storage::url($this->thumbnail_image);
        }
        return asset('storage/courses/thumbnails/dummy.jpeg');
    }

    public function getBannerUrlAttribute()
    {
        if ($this->banner_image && Storage::disk('public')->exists($this->banner_image)) {
            return Storage::url($this->banner_image);
        }
        return asset('storage/courses/banners/default-banner.jpg');
    }

    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery_images) {
            return [];
        }

        $urls = [];
        foreach ($this->gallery_images as $image) {
            if (Storage::disk('public')->exists($image)) {
                $urls[] = Storage::url($image);
            }
        }
        return $urls;
    }

    public function getProspectusUrlAttribute()
    {
        if ($this->prospectus_file && Storage::disk('public')->exists($this->prospectus_file)) {
            return Storage::url($this->prospectus_file);
        }
        return null;
    }

    // Calculate discount if available
    public function getHasDiscountAttribute()
    {
        return $this->discounted_fees && $this->discounted_fees < $this->fees;
    }

    // Get actual price to display
    public function getDisplayPriceAttribute()
    {
        if ($this->has_discount) {
            return $this->discounted_fees;
        }
        return $this->fees;
    }

    // Get savings amount
    public function getSavingsAmountAttribute()
    {
        if ($this->has_discount) {
            return $this->fees - $this->discounted_fees;
        }
        return 0;
    }

    // Format rating with stars
    public function getRatingStarsAttribute()
    {
        return round($this->rating * 2) / 2; // Returns 0, 0.5, 1, 1.5, etc.
    }

    // Check if prospectus is available
    public function getHasProspectusAttribute()
    {
        return $this->prospectus_file && Storage::disk('public')->exists($this->prospectus_file);
    }
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
        // ya: ->where('status', 1)
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Many-to-Many relationship: a course can be offered by multiple colleges.
     */
    public function colleges()
    {
        return $this->belongsToMany(College::class, 'college_course')
                    ->withPivot(['course_details', 'fees', 'duration', 'intake', 'seats', 'eligibility'])
                    ->withTimestamps();
    }
}