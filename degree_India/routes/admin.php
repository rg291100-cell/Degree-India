<?php

use App\Http\Controllers\admin\auth\AuthController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CourseController;
use App\Http\Controllers\admin\CollegeController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\BlogsController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\QueryController;
use App\Http\Controllers\admin\BookingController;
use App\Http\Controllers\admin\StudentController;
use App\Http\Controllers\admin\WhyJoinFeatureController;
use App\Http\Controllers\admin\RegisterContectController;
use App\Http\Controllers\admin\BookingSlotController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\TestimonialController;
use App\Http\Controllers\admin\AdmissionController;
use App\Http\Controllers\admin\ExpertTipController;

use Illuminate\Support\Facades\Route;

// Public admin auth routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login'); // CHANGED FROM '/' TO '/login'
    Route::post('/login', 'loginSubmit')->name('loginSubmit');
});

// Protected admin routes
Route::middleware(['admin'])->group(function () {
    
        
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        // You can also add a route for '/' if you want
        Route::get('/', 'dashboard')->name('admin');
        // Route::get('profile','profile')->name('profile');
    });

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-profile', [ProfileController::class, 'updateAvatar'])->name('profile.update-avatar');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    
    Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('/{user}/status', [UserController::class, 'updateStatus'])->name('status.update');
    });
    Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
            Route::patch('/{category}/status', [CategoryController::class, 'updateStatus'])->name('status');
    });

    Route::resource('courses', CourseController::class);

    // Additional export routes
    Route::get('courses/export/pdf', [CourseController::class, 'index'])->name('courses.export.pdf');
    Route::get('courses/export/csv', [CourseController::class, 'index'])->name('courses.export.csv');
    Route::get('courses/export/print', [CourseController::class, 'index'])->name('courses.export.print');

    
    
    // Additional route for deleting gallery images
    Route::delete('courses/{course}/gallery/{index}', [CourseController::class, 'deleteGalleryImage'])
        ->name('courses.delete-gallery-image');

    Route::resource('colleges', CollegeController::class);
    Route::post('colleges/{college}/remove-gallery-image/{imageIndex}', 
        [CollegeController::class, 'removeGalleryImage'])
        ->name('colleges.remove-gallery-image'); 

    // New routes for assigning admin 
    Route::post('/colleges/assign-admin', [CollegeController::class, 'assignAdmin'])
    ->name('colleges.assign-admin');

     // Export routes
    Route::get('colleges/export/pdf', [CollegeController::class, 'index'])->name('colleges.export.pdf');
    Route::get('colleges/export/csv', [CollegeController::class, 'index'])->name('colleges.export.csv');
    Route::get('colleges/export/print', [CollegeController::class, 'index'])->name('colleges.export.print');
     
    Route::get('colleges/{college}/courses', [CollegeController::class, 'courses'])->name('colleges.courses');

     Route::get('colleges/{college}/account-details', [CollegeController::class, 'accountDetails'])
        ->name('colleges.account-details');
    
    Route::post('colleges/{college}/account-details', [CollegeController::class, 'storeAccountDetails'])
        ->name('colleges.account-details.store');
    
    Route::get('colleges/{college}/download-qr', [CollegeController::class, 'downloadQrCode'])
        ->name('colleges.download-qr');


    Route::resource('roles', RoleController::class);
    Route::get('roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    
    Route::resource('permissions', PermissionController::class);

    Route::prefix('blogs')->name('blogs.')->group(function () {
            Route::get('/', [BlogsController::class, 'index'])->name('index');
            Route::get('/create', [BlogsController::class, 'create'])->name('create');
            Route::post('/', [BlogsController::class, 'store'])->name('store');
            Route::get('/{blog}', [BlogsController::class, 'show'])->name('show');
            Route::get('/{blog}/edit', [BlogsController::class, 'edit'])->name('edit');
            Route::put('/{blog}', [BlogsController::class, 'update'])->name('update');
            Route::delete('/{blog}', [BlogsController::class, 'destroy'])->name('destroy');
            Route::patch('/{blog}/status', [BlogsController::class, 'updateStatus'])->name('status');
        });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::get('/{group}', [SettingController::class, 'manage'])->name('manage');
        Route::put('/{group}', [SettingController::class, 'update'])->name('update');
    });

    // Admin Query Management Routes
    Route::get('/queries', [QueryController::class, 'index'])->name('queries.index');
    Route::get('/queries/create', [QueryController::class, 'create'])->name('queries.create');
    Route::get('/queries/{id}', [QueryController::class, 'show'])->name('queries.show');
    Route::get('/queries/{id}/edit', [QueryController::class, 'edit'])->name('queries.edit');


    // Get All Student Booking Slots 

    Route::get('booking-slot',[BookingController::class,'index'])->name('booking-slot.index');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::delete('booking-slot/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');

      // Export routes
    Route::get('bookings/export/pdf', [BookingController::class, 'index'])->name('bookings.export.pdf');
    Route::get('bookings/export/csv', [BookingController::class, 'index'])->name('bookings.export.csv');
    Route::get('bookings/export/print', [BookingController::class, 'index'])->name('bookings.export.print'); 
    
    Route::post('bookings/{id}/assign', [BookingController::class, 'assignCounselor'])->name('bookings.assign');
    Route::post('bookings/{id}/remove-counselor', [BookingController::class, 'removeCounselor'])->name('bookings.remove-counselor');

    Route::get('bookings/{id}/conversation', [BookingController::class, 'showConversation'])->name('bookings.conversation');
    Route::post('bookings/{id}/conversation', [BookingController::class, 'storeConversation'])->name('bookings.conversation.store');
    Route::get('bookings/{id}/get-conversation', [BookingController::class, 'getConversation'])->name('bookings.conversation.get');


    Route::prefix('slots')->name('slots.')->group(function () {
    Route::get('/', [BookingSlotController::class, 'index'])->name('index');
    Route::post('/', [BookingSlotController::class, 'store'])->name('store');
    Route::get('/create', [BookingSlotController::class, 'create'])->name('create');
    Route::get('/{id}/edit', [BookingSlotController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BookingSlotController::class, 'update'])->name('update');
    Route::delete('/{id}', [BookingSlotController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/toggle-status', [BookingSlotController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/generate-slots', [BookingSlotController::class, 'generateSlots'])->name('generate-slots');
    Route::post('/reset-bookings', [BookingSlotController::class, 'resetBookings'])->name('reset-bookings');
});



    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Why Join Features Routes
    Route::resource('why-join-features', WhyJoinFeatureController::class);
  
    Route::post('why-join-features/update-order', [WhyJoinFeatureController::class, 'updateOrder'])
        ->name('why-join-features.update-order');


    Route::get('/register-contect', [RegisterContectController::class, 'index'])->name('register-contect.index');
    Route::get('/register-contect/create', [RegisterContectController::class, 'create'])->name('register-contect.create');
    Route::post('/register-contect', [RegisterContectController::class, 'store'])->name('register-contect.store');


    Route::put('/register-contect/{id}', [RegisterContectController::class, 'update'])
        ->name('register-contect.update');
    
    Route::get('/register-contect/edit/{id}', [RegisterContectController::class, 'edit'])
        ->name('register-contect.edit');

    Route::resource('banners', BannerController::class);
    Route::post('banners/{banner}/status', [BannerController::class, 'updateStatus'])->name('banners.status');
    Route::post('banners/update-order', [BannerController::class, 'updateOrder'])->name('banners.order');    

    Route::resource('testimonials', TestimonialController::class);
    Route::post('testimonials/{id}/status', [TestimonialController::class, 'updateStatus'])->name('admin.testimonials.status');
    Route::post('testimonials/order', [TestimonialController::class, 'updateOrder'])->name('admin.testimonials.order');



    Route::prefix('admission')->name('admission.')->group(function () {
        Route::get('/', [AdmissionController::class, 'index'])->name('index');
        Route::get('/{id}', [AdmissionController::class, 'show'])->name('show');
        Route::post('/update-status/{id}', [AdmissionController::class, 'updateStatus'])->name('update-status');
        Route::post('/record-payment/{id}', [AdmissionController::class, 'createManualPayment'])->name('record-payment');
        Route::get('/letter/{id}', [AdmissionController::class, 'generateAdmissionLetter'])->name('letter');
        Route::get('/download-letter/{id}', [AdmissionController::class, 'downloadAdmissionLetter'])->name('download-letter');
        Route::get('/stats', [AdmissionController::class, 'getStats'])->name('stats');
    });

    Route::resource('expert-tips', ExpertTipController::class);
    
    // Custom route for regenerating thumbnail
    Route::post('expert-tips/{expertTip}/regenerate-thumbnail', [ExpertTipController::class, 'regenerateThumbnail'])
        ->name('expert-tips.regenerate-thumbnail');

});