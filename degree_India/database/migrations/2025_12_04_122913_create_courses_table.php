<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            // Basic Information
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description');
            
            // Course Details
            $table->string('course_type')->default('Certificate'); // Certificate, Diploma, Graduate, etc.
            $table->string('course_mode')->default('online'); // online, offline, both
            $table->integer('duration')->comment('Duration in hours');
            $table->enum('duration_unit', ['hours', 'days', 'weeks', 'months'])->default('hours');
            $table->string('learning_format')->nullable(); // Full-time, Part-time, Weekend
            $table->integer('total_sessions')->nullable();
            $table->string('course_affiliation')->nullable(); // University/Board affiliation
            $table->text('key_features')->nullable();
            $table->json('skills_covered')->nullable();
            $table->text('course_advantage')->nullable();
            
            // Pricing
            $table->decimal('fees', 10, 2);
            $table->decimal('discounted_fees', 10, 2)->nullable();
            $table->decimal('admission_fee', 10, 2)->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->string('currency', 3)->default('INR');
            
            // Admission Criteria
            $table->json('education_qualification')->nullable();
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->string('entrance_exam')->nullable();
            
            // Job Opportunities
            $table->text('industry_trend')->nullable();
            $table->json('employment_areas')->nullable();
            $table->string('expected_market_size')->nullable();
            $table->string('salary_range')->nullable();
            
            // Course Outcomes
            $table->longText('career_scope')->nullable();
            $table->json('course_outcomes')->nullable();
            $table->json('eligibility_criteria')->nullable();
            
            // Images
            $table->string('thumbnail_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->json('gallery_images')->nullable();
            
            // Course Highlights
            $table->json('course_highlights')->nullable();
            
            // Academic Partners
            $table->json('academic_partners')->nullable();
            
            // Course Syllabus
            $table->longText('syllabus')->nullable();
            
            // Settings
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('order')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('has_prospectus')->default(false);
            $table->string('prospectus_file')->nullable();
            
            // Statistics
            $table->integer('enrollment_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->integer('likes_count')->default(0);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};