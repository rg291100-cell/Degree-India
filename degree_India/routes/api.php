<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CollegeController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\WhyjoinUs;
use App\Http\Controllers\Api\AdmissionController;
use App\Http\Controllers\Api\EducationNewsController;
use App\Http\Controllers\Api\NotificationController;



Route::prefix('auth')->group(function () {
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::post('/verify-otp', [AdminAuthController::class, 'verifyOtp']);
    Route::post('/resend-otp', [AdminAuthController::class, 'resendOtp']);
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::delete('/delete-account', [AdminAuthController::class, 'deleteUser']);
});
 


// Protected API routes (JWT + Admin check)
Route::middleware(['api_auth'])->group(function () {

    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::post('/refresh', [AdminAuthController::class, 'refresh']);
        Route::get('/me', [AdminAuthController::class, 'me']);
    });

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::post('/update', [ProfileController::class, 'updateProfile']);
        Route::get('/get', [ProfileController::class, 'getProfile']);
         Route::post('/update-image', [ProfileController::class, 'updateProfileImage']);
    });

    Route::post('book-slot', [BookingController::class, 'bookSlot']);
    Route::get('get-slots', [BookingController::class, 'getSlots']);
    
    // Notifications API
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/{id}', [NotificationController::class, 'show']);
        Route::post('/', [NotificationController::class, 'store']);
        Route::delete('/{id}', [NotificationController::class, 'destroy']);
    });



});

Route::get('get-slots-time', [BookingController::class, 'getSlotsTime']);


Route::controller(CollegeController::class)->group(function () {
    Route::get('get-colleges', 'getColleges');
    Route::get('get-college/{id}', 'getCollegeById');
     Route::get('search-colleges', 'searchColleges');
    Route::get('search-colleges-advanced', 'searchCollegesAdvanced');
});

Route::controller(CourseController::class)->group(function(){
    Route::get('get-courses', 'getAllCources');
    Route::get('get-category', 'getCategory');
    Route::get('categories/search', 'searchCategoriesByName');
    Route::get('get-courses/{college_id?}/{category_id?}', 'getCourses');
    Route::get('course-details/{course_id?}','getCourseDetail');
     Route::get('/courses/category/{category_id?}', 'getCourseByCategory');
});
Route::get('/offers', [CourseController::class, 'getOffers']);
Route::get('/offers/paginated', [CourseController::class, 'getOffersPaginated']);
Route::get('/offers/college/{college_id}', [CourseController::class, 'getOffersByCollege']);

Route::controller(BlogController::class)->group(function(){
    Route::get('get-blogs', 'getBlogs');
    Route::get('get-blog/{blog_id?}','getBlogDetail');
});


Route::controller(WhyjoinUs::class)->group(function() {
    Route::get('why-join-us', 'getFeatures')->name('why-join-us.features');
    Route::get('register-content', 'getContent');
    Route::get('get-banner', 'getBanner');
    Route::get('get-testimonials', 'getTestimonials');
    Route::get('get-expert-tips', 'getExpert');
    Route::get('account-details/{college_id}', 'getAccountDetails');
});

Route::prefix('admissions')->group(function () {
    Route::post('apply', [AdmissionController::class, 'applyForAdmission']);
    Route::get('my-admissions', [AdmissionController::class, 'getUserAdmissions']);
    Route::get('details/{id}', [AdmissionController::class, 'getAdmissionDetails']);
    Route::post('offline-payment/{id}', [AdmissionController::class, 'updateOfflinePayment']);
    Route::get('payment-history/{admissionId}', [AdmissionController::class, 'getFeePaymentHistory']);
});



Route::prefix('news')->group(function () {
    // GET endpoints
    Route::get('/education/latest', [EducationNewsController::class, 'getLatestEducationNews']);
    Route::get('/search/{keyword}', [EducationNewsController::class, 'searchByKeyword']);
    Route::get('/country/{country}', [EducationNewsController::class, 'getNewsByCountry']);
    Route::get('/category/{category}', [EducationNewsController::class, 'getNewsByCategory']);
    Route::get('/categories', [EducationNewsController::class, 'getCategories']);
    Route::get('/test', [EducationNewsController::class, 'testApi']);
    Route::get('/health', [EducationNewsController::class, 'healthCheck']);
    
    // POST endpoint for advanced search
    Route::post('/search', [EducationNewsController::class, 'searchNews']);
});


