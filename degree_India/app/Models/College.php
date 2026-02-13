<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class College extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'short_description',
        'description',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'phone',
        'email',
        'website',
        'latitude',
        'longitude',
        'established_year',
        'accreditation',
        'affiliation',
        'type',
        'campus_size',
        'total_students',
        'total_faculty',
        'logo',
        'cover_image',
        'gallery_images',
        'nirf_ranking',
        'rating',
        'review_count',
        'fees_structure',
        'admission_process',
        'eligibility_criteria',
        'application_deadline',
        'academic_year_start',
        'facilities',
        'average_package',
        'highest_package',
        'top_recruiters',
        'placement_percentage',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_featured',
        'status',
        'views_count',
        'linkedin_url',
        'youtube_url',
        'instagram_url',
        'facebook_url'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'fees_structure' => 'array',
        'eligibility_criteria' => 'array',
        'facilities' => 'array',
        'top_recruiters' => 'array',
        'is_featured' => 'boolean',
        'average_package' => 'decimal:2',
        'highest_package' => 'decimal:2',
        'rating' => 'decimal:1',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

   
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'college_course')
                    ->withPivot(['course_details', 'fees', 'duration', 'intake', 'seats', 'eligibility'])
                    ->withTimestamps();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

  
    public function getGalleryImagesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

   
    public function setGalleryImagesAttribute($value)
    {
        $this->attributes['gallery_images'] = json_encode($value);
    }

    // All users with their roles for this college
    public function staff()
    {
        return $this->belongsToMany(User::class, 'college_user')
                    ->withPivot('role_id', 'permissions')
                    ->withTimestamps();
    }
    
    // Get specific role staff
    public function getStaffByRole($roleSlug)
    {
        $role = Role::where('slug', $roleSlug)->first();
        
        return $this->staff()
                    ->wherePivot('role_id', $role->id);
    }
    
    // Get college admins
    public function admins()
    {
        return $this->getStaffByRole('college-admin');
    }
    
    // Get counselors
    public function counselors()
    {
        return $this->getStaffByRole('counselor');
    }
    
    public function adminUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with User (Admin)
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   

    // Relationship with User who created/updated
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accountDetail()
    {
        return $this->hasOne(CollegeAccountDetail::class);
    }
}