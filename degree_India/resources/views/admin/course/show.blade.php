@extends('admin.layouts.master')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    /* ============ MAIN CONTAINER ============ */
    .course-show-container {
        background: #f8f9fa;
        min-height: 100vh;
    }

    /* ============ COURSE BANNER ============ */
    .course-banner {
        height: 286px;
        background-size: cover;
        background-position: center;
        position: relative;
        margin-bottom: 30px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .banner-overlay {
        background: linear-gradient(135deg, rgb(107 181 242 / 90%) 0%, rgb(172 174 174 / 90%) 100%);
        color: white;
        padding: 30px;
        height: 100%;
        /* display: flex;
        align-items: center; */
    }

    .course-title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .course-short-desc {
        font-size: 1rem;
        opacity: 0.95;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    /* ============ IMAGE SECTIONS ============ */
    .image-section {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        border: 1px solid #eaeaea;
    }

    .image-preview {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
        border: 2px solid #f0f0f0;
    }

    .image-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .image-label i {
        color: #34a1eb;
    }

    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    /* ============ RATING & STATS ============ */
    .rating-stats {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 15px;
    }

    .rating-box {
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 15px;
        border-radius: 8px;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .rating-stars {
        color: #FFD700;
        font-size: 0.95rem;
        margin-right: 6px;
    }

    .stats-item {
        display: flex;
        align-items: center;
        gap: 6px;
        color: rgba(255, 255, 255, 0.95);
        font-size: 0.9rem;
    }

    .stats-item i {
        font-size: 1rem;
    }

    /* ============ PRICE CARD ============ */
    .price-card {
        background: white;
        color: #333;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        height: fit-content;
        border: 1px solid #e0e0e0;
    }

    .price-title {
        color: #2c80ff;
        font-weight: 500;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    .current-price {
        font-size: 2rem;
        font-weight: 600;
        color: #28a745;
        margin-bottom: 5px;
    }

    .original-price {
        text-decoration: line-through;
        color: #6c757d;
        font-size: 1rem;
        opacity: 0.7;
    }

    .discount-badge {
        background: #ff6b6b;
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
        margin-left: 10px;
    }

    .save-text {
        color: #28a745;
        font-weight: 500;
        margin-top: 8px;
        display: block;
        font-size: 0.9rem;
    }

    /* ============ COURSE HIGHLIGHTS ============ */
    .highlights-section {
        margin-bottom: 40px;
    }

    .section-title {
        color: #495057;
        font-weight: 600;
        font-size: 1.4rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: #2c80ff;
        font-size: 1.2rem;
    }

    .highlights-scroll {
        display: flex;
        overflow-x: auto;
        padding: 15px 0;
        gap: 20px;
        scrollbar-width: thin;
        scrollbar-color: #2c80ff #f1f1f1;
    }

    .highlights-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .highlights-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 8px;
    }

    .highlights-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #2c80ff 0%, #34a1eb 100%);
        border-radius: 8px;
    }

    .highlight-card {
        background: white;
        border-radius: 10px;
        padding: 10px;
        text-align: center;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        min-width: 150px;
        flex-shrink: 0;
        border: 1px solid #eaeaea;
    }

    .highlight-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(44, 128, 255, 0.1);
        border-color: #2c80ff;
    }

    .highlight-icon {
        font-size: 2rem;
        color: #2c80ff;
        margin-bottom: 15px;
    }

    .highlight-text {
        font-size: 0.95rem;
        font-weight: 500;
        color: #495057;
        margin: 0;
        line-height: 1.4;
    }

    /* ============ MAIN CONTENT CARDS ============ */
    .content-card {
        background: white;
        border-radius: 10px;
        border: none;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        margin-bottom: 25px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .content-card:hover {
        transform: translateY(-3px);
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #495057 !important;
        padding: 18px 20px !important;
        border-bottom: 1px solid #dee2e6 !important;
        font-weight: 500;
    }

    .card-header h4 {
        font-weight: 500;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.2rem;
    }

    .card-header i {
        font-size: 1.1rem;
    }

    .card-body {
        padding: 25px;
    }

    /* ============ COURSE DETAILS ============ */
    .course-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 3px solid #2c80ff;
    }

    .detail-item i {
        color: #2c80ff;
        font-size: 1rem;
        min-width: 25px;
    }

    .detail-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 2px;
        font-size: 0.85rem;
    }

    .detail-value {
        color: #6c757d;
        font-size: 0.85rem;
        margin: 0;
    }

    /* ============ SKILLS BADGES ============ */
    .skills-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }

    .skill-badge {
        background: linear-gradient(135deg, #f0f0f0 0%, #e6e6e6 100%);
        color: #495057;
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 400;
        display: flex;
        align-items: center;
        gap: 5px;
        border: 1px solid #ddd;
    }

    .skill-badge i {
        font-size: 0.8rem;
        color: #28a745;
    }

    /* ============ FEES BREAKDOWN ============ */
    .fees-breakdown {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border-left: 3px solid #28a745;
    }

    .fee-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #dee2e6;
        font-size: 0.9rem;
    }

    .fee-item:last-child {
        border-bottom: none;
    }

    .total-payable {
        background: linear-gradient(135deg, #f8f9fa 0%, #e8f5e9 100%);
        color: #495057;
        padding: 18px;
        border-radius: 8px;
        margin-top: 15px;
        border: 1px solid #d4edda;
    }

    /* ============ ACTION BUTTONS ============ */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 25px;
    }

    .btn-enroll {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 12px 24px;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 8px;
        border: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-enroll:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(40, 167, 69, 0.25);
        color: white;
    }

    .btn-share,
    .btn-like,
    .btn-prospectus {
        padding: 10px 16px;
        font-weight: 400;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-share:hover,
    .btn-like:hover,
    .btn-prospectus:hover {
        transform: translateY(-2px);
    }

    /* ============ SIDEBAR CARDS ============ */
    .sidebar-card {
        background: white;
        border-radius: 10px;
        border: none;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        margin-bottom: 20px;
        overflow: hidden;
        border: 1px solid #eaeaea;
    }

    .sidebar-card .card-header {
        background: #f8f9fa;
        color: #495057;
        border-bottom: 1px solid #e9ecef;
        font-weight: 500;
        font-size: 1rem;
    }

    .sidebar-card .card-body {
        padding: 20px;
    }

    .expert-card {
        background: linear-gradient(135deg, #2c80ff 0%, #d0e7ff 100%);
        color: #333;
        text-align: center;
        padding: 25px 20px;
        border-radius: 10px;
        border: 1px solid #cce5ff;
    }

    .expert-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: #2c80ff;
    }

    .btn-counseling {
        background: white;
        color: #2c80ff;
        border: 1px solid #2c80ff;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        margin-top: 15px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-counseling:hover {
        background: #2c80ff;
        color: white;
        transform: translateY(-2px);
    }

    /* ============ PARTNER LOGOS ============ */
    .partner-logo-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
        align-items: center;
        padding: 15px;
    }

    .partner-logo {
        max-height: 50px;
        max-width: 120px;
        object-fit: contain;
        padding: 8px;
        background: white;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 1px solid #eee;
    }

    .partner-logo:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* ============ COURSE OUTCOMES ============ */
    .outcomes-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .outcome-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 10px;
        border-left: 3px solid #28a745;
        font-size: 0.9rem;
    }

    .outcome-item i {
        color: #28a745;
        font-size: 1rem;
        margin-top: 1px;
    }

    /* ============ QUICK ACTIONS ============ */
    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-edit,
    .btn-delete {
        padding: 12px 16px;
        font-weight: 500;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-edit {
        background: linear-gradient(135deg, #2c80ff 0%, #34a1eb 100%);
        color: white;
        border: none;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(44, 128, 255, 0.25);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #dc3545 0%, #e4606d 100%);
        color: white;
        border: none;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(220, 53, 69, 0.25);
        color: white;
    }

    /* ============ RATINGS & REVIEWS ============ */
    .review-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        margin-bottom: 25px;
        border: 1px solid #eaeaea;
    }

    .rating-input {
        display: flex;
        gap: 8px;
        margin-bottom: 15px;
    }

    .rating-input i {
        font-size: 1.5rem;
        color: #e4e5e9;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .rating-input i:hover {
        color: #FFD700;
        transform: scale(1.1);
    }

    .rating-input i.active {
        color: #FFD700;
    }

    /* ============ TEXT STYLES ============ */
    .text-gradient-primary {
        color: #2c80ff;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 10px;
        font-size: 1rem;
    }

    .text-gradient-primary i {
        font-size: 0.9rem;
    }

    /* ============ RESPONSIVE DESIGN ============ */
    @media (max-width: 768px) {
        .course-banner {
            height: 300px;
        }

        .banner-overlay {
            padding: 20px;
        }

        .course-title {
            font-size: 1.5rem;
        }

        .course-short-desc {
            font-size: 0.9rem;
        }

        .price-card {
            margin-top: 15px;
        }

        .highlight-card {
            min-width: 180px;
            padding: 15px 12px;
        }

        .section-title {
            font-size: 1.2rem;
        }

        .card-body {
            padding: 20px;
        }

        .course-details-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-enroll,
        .btn-share,
        .btn-like,
        .btn-prospectus {
            width: 100%;
            font-size: 0.85rem;
        }

        .image-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .course-banner {
            height: 250px;
        }

        .rating-stats {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .highlight-card {
            min-width: 160px;
            padding: 12px 10px;
        }

        .partner-logo-container {
            gap: 12px;
        }

        .partner-logo {
            max-height: 40px;
            max-width: 100px;
        }
    }

    /* ============ UTILITY CLASSES ============ */
    .shadow-soft {
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.06) !important;
    }

    /* ============ ANIMATIONS ============ */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.4s ease forwards;
    }

    /* ============ CUSTOM SCROLLBAR ============ */
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
        height: 5px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #2c80ff;
        border-radius: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #1a6bff;
    }
</style>


@section('content')
    <div class="course-show-container">
        <div class="container py-4">
            <!-- Course Banner -->
            <div class="course-banner fade-in-up"
                style="background-image: url('{{ $course->banner_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80' }}');">
                <div class="banner-overlay">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h1 class="course-title">{{ $course->title }}</h1>
                            <p class="course-short-desc">
                                {{ $course->short_description ?? 'A comprehensive course designed to help you master essential skills' }}
                            </p>

                            <div class="rating-stats">
                                <div class="rating-box">
                                    <div class="d-flex align-items-center">
                                        <div class="rating-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($course->rating))
                                                    <i class="fas fa-star"></i>
                                                @elseif($i - 0.5 <= $course->rating)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="ms-2 fw-bold" style="font-size: 0.9rem;">
                                            {{ number_format($course->rating, 1) }}
                                        </span>
                                        <span class="ms-2" style="font-size: 0.9rem;">
                                            ({{ $course->total_reviews }} reviews)
                                        </span>
                                    </div>
                                </div>

                                <div class="stats-item">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $course->enrollment_count }} Enrolled</span>
                                </div>

                                <div class="stats-item">
                                    <i class="fas fa-heart text-danger"></i>
                                    <span>{{ $course->likes_count }} Likes</span>
                                </div>

                                <div class="stats-item">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $course->duration }} {{ $course->duration_unit }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mt-4 mt-lg-0">
                            <div class="price-card fade-in-up" style="animation-delay: 0.2s;">
                                <h5 class="price-title"><i class="fas fa-tags me-2"></i>Course Fees</h5>

                                @if ($course->has_discount)
                                    <div class="d-flex align-items-baseline">
                                        <h2 class="current-price mb-0">{{ $course->currency }}
                                            {{ number_format($course->display_price, 2) }}</h2>
                                        <span class="original-price ms-2">{{ $course->currency }}
                                            {{ number_format($course->fees, 2) }}</span>
                                        <span class="discount-badge">Save {{ $course->discount_percentage }}%</span>
                                    </div>
                                    <span class="save-text">
                                        <i class="fas fa-save me-1"></i> You save {{ $course->currency }}
                                        {{ number_format($course->savings_amount, 2) }}
                                    </span>
                                @else
                                    <h2 class="current-price mb-3">{{ $course->currency }}
                                        {{ number_format($course->fees, 2) }}</h2>
                                @endif

                                @if ($course->admission_fee)
                                    <div class="mt-3">
                                        <p class="mb-1" style="font-size: 0.9rem;">
                                            <i class="fas fa-file-invoice-dollar me-2"></i>
                                            Admission Fee: {{ $course->currency }}
                                            {{ number_format($course->admission_fee, 2) }}
                                        </p>
                                    </div>
                                @endif

                                {{-- <div class="mt-4">
                                    <button class="btn-enroll w-100">
                                        <i class="fas fa-shopping-cart"></i> Enroll Now
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images Section -->
            <div class="image-section fade-in-up" style="animation-delay: 0.3s;">
                <h3 class="section-title"> Course Images
                </h3>

                <div class="image-grid">
                    <!-- Banner Image -->
                    <div>
                        <p class="image-label">
                            <i class="fas fa-image"></i> Banner Image
                        </p>
                        @if ($course->banner_url)
                            <img src="{{ $course->banner_url }}" alt="Course Banner" class="image-preview">
                        @else
                            <div class="image-preview d-flex align-items-center justify-content-center bg-light">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Image -->
                    <div>
                        <p class="image-label">
                            <i class="fas fa-thumbtack"></i> Thumbnail Image
                        </p>
                        @if ($course->thumbnail_url)
                            <img src="{{ $course->thumbnail_url }}" alt="Course Thumbnail" class="image-preview">
                        @else
                            <div class="image-preview d-flex align-items-center justify-content-center bg-light">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Course Images -->
                    @if ($course->course_images && count($course->course_images) > 0)
                        @foreach ($course->course_images as $index => $image)
                            <div>
                                <p class="image-label">
                                    <i class="fas fa-image"></i> Course Image {{ $index + 1 }}
                                </p>
                                <img src="{{ $image }}" alt="Course Image {{ $index + 1 }}"
                                    class="image-preview">
                            </div>
                        @endforeach
                    @endif
                </div>

                @if (!$course->banner_url && !$course->thumbnail_url && (!$course->course_images || count($course->course_images) == 0))
                    <div class="text-center py-4">
                        <i class="fas fa-images fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No images uploaded for this course</p>
                    </div>
                @endif
            </div>

            <!-- Course Highlights -->
            <div class="highlights-section fade-in-up" style="animation-delay: 0.4s;">
                <h2 class="section-title">Course Highlights
                </h2>

                <div class="highlights-scroll custom-scrollbar">
                    @if ($course->course_highlights && count($course->course_highlights) > 0)
                        @foreach ($course->course_highlights as $highlight)
                            <div class="highlight-card">
                                <div class="highlight-icon">
                                    <i class="{{ $highlight['icon'] ?? 'fas fa-check-circle' }}"></i>
                                </div>
                                <p class="highlight-text">{{ $highlight['text'] }}</p>
                            </div>
                        @endforeach
                    @else
                        <!-- Default highlights -->
                        @foreach ([['icon' => 'fas fa-certificate', 'text' => 'Certificate of Completion'], ['icon' => 'fas fa-chalkboard-teacher', 'text' => 'Expert Instructors'], ['icon' => 'fas fa-laptop-code', 'text' => 'Hands-on Projects'], ['icon' => 'fas fa-clock', 'text' => 'Lifetime Access'], ['icon' => 'fas fa-question-circle', 'text' => '24/7 Support'], ['icon' => 'fas fa-briefcase', 'text' => 'Career Guidance']] as $highlight)
                            <div class="highlight-card">
                                <div class="highlight-icon">
                                    <i class="{{ $highlight['icon'] }}"></i>
                                </div>
                                <p class="highlight-text">{{ $highlight['text'] }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Main Content -->
            <div class="row">
                <!-- Left Column - Course Details -->
                <div class="col-lg-8">
                    <!-- About Course -->
                    <div class="content-card fade-in-up" style="animation-delay: 0.5s;">
                        <div class="card-header">
                            <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>About The Course</h4>
                        </div>
                        <div class="card-body">
                            <!-- Course Details Grid -->
                            <div class="course-details-grid">
                                <div class="detail-item">
                                    <i class="fas fa-certificate"></i>
                                    <div>
                                        <div class="detail-label">Course Type</div>
                                        <div class="detail-value">{{ $course->course_type ?? 'Certificate Course' }}</div>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <div class="detail-label">Duration</div>
                                        <div class="detail-value">{{ $course->duration_text ?? '12 Weeks' }}</div>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-laptop"></i>
                                    <div>
                                        <div class="detail-label">Mode</div>
                                        <div class="detail-value">{{ ucfirst($course->course_mode ?? 'Online') }}</div>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <div>
                                        <div class="detail-label">Format</div>
                                        <div class="detail-value">{{ ucfirst($course->learning_format ?? 'Self-Paced') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <div>
                                        <div class="detail-label">Sessions</div>
                                        <div class="detail-value">{{ $course->total_sessions ?? '30+' }} Sessions</div>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-university"></i>
                                    <div>
                                        <div class="detail-label">Affiliation</div>
                                        <div class="detail-value">
                                            {{ $course->course_affiliation ?? 'Industry Recognized' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Course Description -->
                            <div class="mb-4">
                                <h5 class="text-gradient-primary mb-3">
                                    <i class="fas fa-align-left me-2"></i>Course Description
                                </h5>
                                <div class="course-description" style="font-size: 0.95rem; line-height: 1.6;">
                                    {!! $course->description ??
                                        '<p>This comprehensive course is designed to provide you with practical skills and knowledge that are immediately applicable in the real world. Our expert instructors will guide you through every step of the learning journey.</p>' !!}
                                </div>
                            </div>

                            <!-- Key Features -->
                            @if ($course->key_features)
                                <div class="mb-4">
                                    <h5 class="text-gradient-primary mb-3">
                                        <i class="fas fa-key me-2"></i>Key Features
                                    </h5>
                                    <div class="key-features" style="font-size: 0.95rem;">
                                        {!! $course->key_features !!}
                                    </div>
                                </div>
                            @endif

                            <!-- Skills Covered -->
                            @if ($course->skills_covered && count($course->skills_covered) > 0)
                                <div class="mb-4">
                                    <h5 class="text-gradient-primary mb-3">
                                        <i class="fas fa-tools me-2"></i>Skills Covered
                                    </h5>
                                    <div class="skills-container">
                                        @foreach ($course->skills_covered as $skill)
                                            <span class="skill-badge">
                                                <i class="fas fa-check-circle me-1"></i> {{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Syllabus -->
                            @if ($course->syllabus)
                                <div class="mt-4">
                                    <h5 class="text-gradient-primary mb-3">
                                        <i class="fas fa-book me-2"></i>Course Syllabus
                                    </h5>
                                    <div class="syllabus-content" style="font-size: 0.95rem;">
                                        {!! $course->syllabus !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Fees & Payment -->
                    <div class="content-card fade-in-up" style="animation-delay: 0.6s;">
                        <div class="card-header">
                            <h4 class="mb-0"><i class="fas fa-credit-card me-2"></i>Fees & Payment</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fees-breakdown">
                                        <h5 class="text-gradient-primary mb-4" style="font-size: 1rem;">
                                            <i class="fas fa-receipt me-2"></i>Fees Breakdown
                                        </h5>

                                        <div class="fee-item">
                                            <span>Course Fees:</span>
                                            <span class="fw-bold">{{ $course->currency }}
                                                {{ number_format($course->fees, 2) }}</span>
                                        </div>

                                        @if ($course->has_discount)
                                            <div class="fee-item">
                                                <span>Discount ({{ $course->discount_percentage }}%):</span>
                                                <span class="text-success">-{{ $course->currency }}
                                                    {{ number_format($course->savings_amount, 2) }}</span>
                                            </div>

                                            <div class="fee-item">
                                                <span>Discounted Fees:</span>
                                                <span class="fw-bold">{{ $course->currency }}
                                                    {{ number_format($course->discounted_fees, 2) }}</span>
                                            </div>
                                        @endif

                                        @if ($course->admission_fee)
                                            <div class="fee-item">
                                                <span>Admission Fee:</span>
                                                <span>{{ $course->currency }}
                                                    {{ number_format($course->admission_fee, 2) }}</span>
                                            </div>
                                        @endif

                                        <div class="total-payable">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Total Payable:</span>
                                                <span class="h5 mb-0 fw-bold">
                                                    {{ $course->currency }}
                                                    @if ($course->has_discount)
                                                        {{ number_format($course->discounted_fees + ($course->admission_fee ?? 0), 2) }}
                                                    @else
                                                        {{ number_format($course->fees + ($course->admission_fee ?? 0), 2) }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="action-buttons">
                                        {{-- <button class="btn-enroll">
                                            <i class="fas fa-shopping-cart me-2"></i> Enroll Now
                                        </button>

                                        <div class="row g-2">
                                            <div class="col-6">
                                                <button class="btn btn-outline-primary btn-share w-100">
                                                    <i class="fas fa-share-alt me-2"></i> Share
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-outline-danger btn-like w-100">
                                                    <i class="fas fa-heart me-2"></i> Like
                                                </button>
                                            </div>
                                        </div> --}}

                                        @if ($course->has_prospectus)
                                            <a href="{{ $course->prospectus_url }}"
                                                class="btn btn-success btn-prospectus" target="_blank">
                                                <i class="fas fa-download me-2"></i> Download Prospectus
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Payment Options -->
                                    <div class="mt-4">
                                        <h6 class="text-gradient-primary mb-3" style="font-size: 0.9rem;">
                                            <i class="fas fa-credit-card me-2"></i>Payment Options
                                        </h6>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <span class="badge bg-light text-dark p-2" style="font-size: 0.8rem;">
                                                <i class="fab fa-cc-visa me-1"></i> Visa
                                            </span>
                                            <span class="badge bg-light text-dark p-2" style="font-size: 0.8rem;">
                                                <i class="fab fa-cc-mastercard me-1"></i> Mastercard
                                            </span>
                                            <span class="badge bg-light text-dark p-2" style="font-size: 0.8rem;">
                                                <i class="fas fa-university me-1"></i> Net Banking
                                            </span>
                                            <span class="badge bg-light text-dark p-2" style="font-size: 0.8rem;">
                                                <i class="fas fa-wallet me-1"></i> UPI
                                            </span>
                                            <span class="badge bg-light text-dark p-2" style="font-size: 0.8rem;">
                                                <i class="fas fa-money-check-alt me-1"></i> EMI
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Career Opportunities -->
                    <div class="content-card fade-in-up" style="animation-delay: 0.7s;">
                        <div class="card-header">
                            <h4 class="mb-0"><i class="fas fa-briefcase me-2"></i>Career Opportunities</h4>
                        </div>
                        <div class="card-body">
                            @if ($course->career_scope)
                                <div class="mb-4">
                                    <h5 class="text-gradient-primary mb-3">
                                        <i class="fas fa-bullseye me-2"></i>Career Scope
                                    </h5>
                                    <div class="career-scope" style="font-size: 0.95rem;">
                                        {!! $course->career_scope !!}
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                @if ($course->salary_range)
                                    <div class="col-md-6 mb-4">
                                        <div class="bg-light p-4 rounded">
                                            <h5 class="text-gradient-primary mb-3">
                                                <i class="fas fa-money-check-alt me-2"></i>Salary Range
                                            </h5>
                                            <div class="h4 fw-bold" style="color: #28a745;">
                                                {{ $course->salary_range }}
                                            </div>
                                            <small class="text-muted" style="font-size: 0.8rem;">Average starting
                                                salary</small>
                                        </div>
                                    </div>
                                @endif

                                @if ($course->expected_market_size)
                                    <div class="col-md-6 mb-4">
                                        <div class="bg-light p-4 rounded">
                                            <h5 class="text-gradient-primary mb-3">
                                                <i class="fas fa-chart-pie me-2"></i>Market Size
                                            </h5>
                                            <div class="h4 fw-bold" style="color: #2c80ff;">
                                                {{ $course->expected_market_size }}
                                            </div>
                                            <small class="text-muted" style="font-size: 0.8rem;">Expected market
                                                growth</small>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Employment Areas -->
                            @if ($course->employment_areas && count($course->employment_areas) > 0)
                                <div class="mt-4">
                                    <h5 class="text-gradient-primary mb-3">
                                        <i class="fas fa-building me-2"></i>Employment Areas
                                    </h5>
                                    <div class="skills-container">
                                        @foreach ($course->employment_areas as $area)
                                            <span class="skill-badge">
                                                <i class="fas fa-briefcase me-1"></i> {{ $area }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Sidebar -->
                <div class="col-lg-4">
                    <!-- Talk to Expert -->


                    <!-- Academic Partners -->
                    @if ($course->academic_partners && count($course->academic_partners) > 0)
                        <div class="sidebar-card fade-in-up" style="animation-delay: 0.6s;">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-handshake me-2"></i>Academic Partners</h5>
                            </div>
                            <div class="card-body">
                                <div class="partner-logo-container">
                                    @foreach ($course->academic_partners as $partner)
                                        @if ($partner['logo'])
                                            <img src="{{ $partner['logo'] }}" alt="{{ $partner['name'] }}"
                                                class="partner-logo" title="{{ $partner['name'] }}">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Course Outcomes -->
                    @if ($course->course_outcomes && count($course->course_outcomes) > 0)
                        <div class="sidebar-card fade-in-up" style="animation-delay: 0.7s;">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Course Outcomes</h5>
                            </div>
                            <div class="card-body">
                                <ul class="outcomes-list">
                                    @foreach ($course->course_outcomes as $outcome)
                                        <li class="outcome-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span>{{ $outcome }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="sidebar-card fade-in-up" style="animation-delay: 0.8s;">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions">
                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn-edit">
                                    <i class="fas fa-edit me-2"></i> Edit Course
                                </a>

                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                                    class="d-inline-block w-100" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete w-100">
                                        <i class="fas fa-trash me-2"></i> Delete Course
                                    </button>
                                </form>

                                <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ratings & Reviews -->
            <div class="content-card fade-in-up mt-4" style="animation-delay: 0.8s;">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-star me-2"></i>Ratings & Reviews</h4>
                </div>
                <div class="card-body">
                    @if ($course->allow_reviews)
                        <!-- Add Review -->
                        <div class="review-card mb-4">
                            <h5 class="text-gradient-primary mb-4">Add Your Review</h5>
                            <form id="reviewForm">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-3">Your Rating</label>
                                    <div class="rating-input">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="far fa-star" data-rating="{{ $i }}"></i>
                                        @endfor
                                        <input type="hidden" name="rating" id="ratingValue" value="0">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-3">Your Review</label>
                                    <textarea class="form-control" name="review" rows="3" placeholder="Share your experience with this course..."
                                        style="border-radius: 8px; border: 1px solid #e9ecef; font-size: 0.9rem;"></textarea>
                                </div>

                                <button type="submit" class="btn-enroll" style="max-width: 200px; padding: 10px 20px;">
                                    <i class="fas fa-paper-plane me-2"></i> Submit Review
                                </button>
                            </form>
                        </div>

                        <!-- Reviews Summary -->
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="text-gradient-primary mb-0" style="font-size: 1rem;">Student Reviews</h5>
                                <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ $course->total_reviews }}
                                    reviews</p>
                            </div>
                            <div class="text-end">
                                <div class="h4 fw-bold text-gradient-primary mb-0">
                                    {{ number_format($course->rating, 1) }}
                                </div>
                                <div class="rating-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($course->rating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $course->rating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-comment-slash fa-2x text-muted mb-3"></i>
                            <h5 class="text-muted" style="font-size: 1rem;">Reviews are disabled for this course</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {
            // Rating stars interaction
            $('.rating-input i').hover(function() {
                const rating = $(this).data('rating');
                $('.rating-input i').each(function(i) {
                    const starIndex = $(this).data('rating');
                    if (starIndex <= rating) {
                        $(this).removeClass('far').addClass('fas');
                    } else {
                        $(this).removeClass('fas').addClass('far');
                    }
                });
            }).mouseleave(function() {
                const currentRating = $('#ratingValue').val();
                $('.rating-input i').each(function(i) {
                    const starIndex = $(this).data('rating');
                    if (starIndex <= currentRating) {
                        $(this).removeClass('far').addClass('fas');
                    } else {
                        $(this).removeClass('fas').addClass('far');
                    }
                });
            }).click(function() {
                const rating = $(this).data('rating');
                $('#ratingValue').val(rating);
                $('.rating-input i').each(function(i) {
                    const starIndex = $(this).data('rating');
                    if (starIndex <= rating) {
                        $(this).removeClass('far').addClass('fas');
                    } else {
                        $(this).removeClass('fas').addClass('far');
                    }
                });
            });

            // Share functionality
            $('.btn-share').click(function(e) {
                e.preventDefault();
                if (navigator.share) {
                    navigator.share({
                            title: '{{ $course->title }}',
                            text: 'Check out this amazing course!',
                            url: window.location.href,
                        })
                        .then(() => console.log('Successful share'))
                        .catch((error) => console.log('Error sharing:', error));
                } else {
                    // Fallback
                    navigator.clipboard.writeText(window.location.href)
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Link Copied!',
                                text: 'Course link copied to clipboard',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        })
                        .catch(err => {
                            console.error('Failed to copy: ', err);
                        });
                }
            });

            // Like functionality
            $('.btn-like').click(function(e) {
                e.preventDefault();
                const $btn = $(this);

                // Toggle like state
                if ($btn.hasClass('btn-outline-danger')) {
                    $btn.removeClass('btn-outline-danger').addClass('btn-danger');
                    $btn.html('<i class="fas fa-heart me-2"></i> Liked');

                    Swal.fire({
                        icon: 'success',
                        title: 'Course Liked!',
                        text: 'Thanks for liking this course',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    $btn.removeClass('btn-danger').addClass('btn-outline-danger');
                    $btn.html('<i class="fas fa-heart me-2"></i> Like');
                }
            });

            // Enroll button
            $('.btn-enroll').click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Enroll in Course',
                    html: `You are about to enroll in:<br><strong>{{ $course->title }}</strong><br><br>
                       Total Amount: <strong>{{ $course->currency }} 
                       @if ($course->has_discount)
                           {{ number_format($course->discounted_fees + ($course->admission_fee ?? 0), 2) }}
                       @else
                           {{ number_format($course->fees + ($course->admission_fee ?? 0), 2) }}
                       @endif</strong>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Proceed to Payment',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Here you would typically redirect to payment page
                        Swal.fire({
                            title: 'Redirecting...',
                            text: 'Please wait while we redirect you to the payment gateway',
                            timer: 1500,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    }
                });
            });

            // Review form submission
            $('#reviewForm').submit(function(e) {
                e.preventDefault();
                const rating = $('#ratingValue').val();
                const review = $('textarea[name="review"]').val();

                if (rating == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please Rate',
                        text: 'Please select a rating before submitting',
                        confirmButtonColor: '#2c80ff'
                    });
                    return;
                }

                if (!review.trim()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Review Required',
                        text: 'Please write a review before submitting',
                        confirmButtonColor: '#2c80ff'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Submitting Review...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Simulate API call
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Review Submitted!',
                        text: 'Thank you for your feedback',
                        confirmButtonColor: '#28a745'
                    });
                    $('#reviewForm')[0].reset();
                    $('.rating-input i').removeClass('fas').addClass('far');
                    $('#ratingValue').val(0);
                }, 1500);
            });

            // Delete confirmation
            window.confirmDelete = function() {
                return Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    return result.isConfirmed;
                });
            };

            // Book counseling session
            $('.btn-counseling').click(function() {
                Swal.fire({
                    title: 'Book Counseling Session',
                    html: `Select a time slot for your free career counseling session`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#2c80ff',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Book Now',
                    cancelButtonText: 'Later',
                    input: 'select',
                    inputOptions: {
                        '10:00 AM': '10:00 AM (Tomorrow)',
                        '02:00 PM': '02:00 PM (Tomorrow)',
                        '04:30 PM': '04:30 PM (Tomorrow)',
                        '11:00 AM': '11:00 AM (Day after tomorrow)',
                        '03:00 PM': '03:00 PM (Day after tomorrow)'
                    },
                    inputPlaceholder: 'Select a time slot',
                    showLoaderOnConfirm: true,
                    preConfirm: (selectedTime) => {
                        if (!selectedTime) {
                            Swal.showValidationMessage('Please select a time slot');
                            return false;
                        }
                        return new Promise((resolve) => {
                            setTimeout(() => {
                                resolve(selectedTime);
                            }, 1500);
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Session Booked!',
                            html: `Your counseling session is booked for <strong>${result.value}</strong><br><br>
                               You will receive a confirmation email shortly.`,
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        });
                    }
                });
            });
        });
    </script>
@endsection
