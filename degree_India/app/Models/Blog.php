<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'user_id',
        'category_id',
        'seo_fields'
    ];

    protected $casts = [
        'seo_fields' => 'array',
        'status' => 'string'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($blog) {
            if (auth()->check()) {
                $blog->user_id = auth()->id();
            }
            $blog->slug = \Str::slug($blog->title);
        });
        
        static::updating(function ($blog) {
            $blog->slug = \Str::slug($blog->title);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}