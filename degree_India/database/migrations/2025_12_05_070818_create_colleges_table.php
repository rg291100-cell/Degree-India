<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description');
            
            // Location details
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('pincode')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // College details
            $table->year('established_year')->nullable();
            $table->string('accreditation')->nullable();
            $table->string('affiliation')->nullable();
            $table->enum('type', ['government', 'private', 'deemed', 'autonomous'])->default('private');
            $table->string('campus_size')->nullable()->comment('e.g., "10 acres"');
            $table->integer('total_students')->nullable();
            $table->integer('total_faculty')->nullable();
            
            // Images
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->json('gallery_images')->nullable();
            
            // Rankings & Ratings
            $table->integer('nirf_ranking')->nullable();
            $table->decimal('rating', 3, 1)->default(0);
            $table->integer('review_count')->default(0);
            
            // Fees structure
            $table->json('fees_structure')->nullable()->comment('JSON structure for different courses');
            
            // Admission details
            $table->text('admission_process')->nullable();
            $table->json('eligibility_criteria')->nullable();
            $table->date('application_deadline')->nullable();
            $table->date('academic_year_start')->nullable();
            
            // Facilities
            $table->json('facilities')->nullable();
            
            // Placement details
            $table->decimal('average_package', 10, 2)->nullable();
            $table->decimal('highest_package', 10, 2)->nullable();
            $table->json('top_recruiters')->nullable();
            $table->integer('placement_percentage')->nullable();
            
            // SEO fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Status
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('views_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
        
        // Create college_course pivot table
        Schema::create('college_course', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->json('course_details')->nullable()->comment('College-specific course details');
            $table->decimal('fees', 10, 2)->nullable();
            $table->string('duration')->nullable();
            $table->enum('intake', ['january', 'july', 'yearly'])->default('yearly');
            $table->integer('seats')->nullable();
            $table->json('eligibility')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('college_course');
        Schema::dropIfExists('colleges');
    }
};