{{-- admin/course/form.blade.php --}}
@extends('admin.layouts.master')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">



<style>
    /* Existing styles remain */
    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: #667eea;
        border-bottom: 3px solid rgba(102, 126, 234, 0.3);
    }

    .nav-tabs .nav-link.active {
        color: #667eea;
        background-color: transparent;
        border: none;
        border-bottom: 3px solid #667eea;
        font-weight: 600;
    }

    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 1.5rem;
    }

    .tab-pane {
        padding-top: 1.5rem;
    }

    /* Progress bar styling */
    .progress {
        height: 8px;
        border-radius: 4px;
        margin-bottom: 2rem;
        background-color: #e9ecef;
    }

    .progress-bar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 4px;
        transition: width 0.5s ease;
    }

    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
        position: relative;
    }

    .step {
        text-align: center;
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        font-weight: 600;
        border: 3px solid white;
        transition: all 0.3s ease;
    }

    .step.active .step-circle {
        background: #667eea;
        color: white;
        transform: scale(1.1);
    }

    .step.completed .step-circle {
        background: #28a745;
        color: white;
    }

    .step-label {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 500;
    }

    .step.active .step-label {
        color: #667eea;
        font-weight: 600;
    }

    .step-indicator::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e9ecef;
        z-index: 1;
    }

    /* Main Container */
    .container-fluid {
        padding: 0 15px;
    }

    /* Card Styling */
    .card-primary {
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.35rem;
    }

    .card-header h3 {
        color: #5a5c69;
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
    }

    .card-header h3 i {
        color: #4e73df;
    }

    .card-body {
        padding: 2rem;
        background-color: #fff;
    }

    .card-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid #e3e6f0;
    }

    /* Form Elements */
    .form-label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-control {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        padding: 0.6rem 0.75rem;
        font-size: 0.95rem;
        transition: all 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .form-control.is-invalid {
        border-color: #e74a3b;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 0.2rem rgba(231, 74, 59, 0.25);
    }

    .invalid-feedback {
        font-size: 0.85rem;
        color: #e74a3b;
    }

    /* Select2 Styling (if using) */
    .select2-container--default .select2-selection--single {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        height: calc(2.25rem + 2px);
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: calc(2.25rem + 2px);
        padding-left: 0.75rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(2.25rem + 2px);
    }

    /* Summernote Editor */
    .note-editor {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        overflow: hidden;
    }

    .note-toolbar {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }

    .note-editable {
        min-height: 200px;
        padding: 0.75rem;
    }

    /* Bootstrap Tags Input */
    .bootstrap-tagsinput {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        padding: 0.375rem 0.75rem;
        min-height: calc(2.25rem + 2px);
        width: 100%;
    }

    .bootstrap-tagsinput .tag {
        background: #4e73df;
        color: white;
        padding: 0.2rem 0.6rem;
        border-radius: 0.25rem;
        margin-right: 0.3rem;
        margin-bottom: 0.3rem;
        display: inline-block;
        font-size: 0.85rem;
    }

    .bootstrap-tagsinput input {
        border: none;
        box-shadow: none;
        outline: none;
        background-color: transparent;
        padding: 0;
        margin: 0;
        width: auto !important;
    }

    /* Buttons */
    .btn {
        font-weight: 500;
        padding: 0.5rem 1.5rem;
        border-radius: 0.35rem;
        font-size: 0.9rem;
        transition: all 0.15s ease-in-out;
        border: 1px solid transparent;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.8rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4290 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background-color: #858796;
        border-color: #858796;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #717384;
        border-color: #717384;
    }

    .btn-success {
        background-color: #1cc88a;
        border-color: #1cc88a;
        color: white;
    }

    .btn-success:hover {
        background-color: #17a673;
        border-color: #17a673;
    }

    .btn-danger {
        background-color: #e74a3b;
        border-color: #e74a3b;
        color: white;
    }

    .btn-danger:hover {
        background-color: #d62c1a;
        border-color: #d62c1a;
    }

    .btn-outline-primary {
        color: #667eea;
        border-color: #667eea;
        background-color: transparent;
    }

    .btn-outline-primary:hover {
        background-color: #667eea;
        color: white;
    }

    /* Step Progress Indicator */
    .progress {
        height: 8px;
        border-radius: 4px;
        margin-bottom: 2rem;
        background-color: #e9ecef;
    }

    .progress-bar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 4px;
        transition: width 0.5s ease;
    }

    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
        position: relative;
    }

    .step {
        text-align: center;
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        font-weight: 600;
        border: 3px solid white;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .step.active .step-circle {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .step.completed .step-circle {
        background: #28a745;
        color: white;
    }

    .step-label {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 500;
    }

    .step.active .step-label {
        color: #667eea;
        font-weight: 600;
    }

    .step.completed .step-label {
        color: #28a745;
    }

    .step-indicator::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e9ecef;
        z-index: 1;
    }

    /* Navigation Tabs */
    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 1.5rem;
    }

    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: #667eea;
        border-bottom: 3px solid rgba(102, 126, 234, 0.3);
    }

    .nav-tabs .nav-link.active {
        color: #667eea;
        background-color: transparent;
        border: none;
        border-bottom: 3px solid #667eea;
        font-weight: 600;
    }

    /* Tab Content */
    .tab-pane {
        padding-top: 1.5rem;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Form Sections */
    .section-header {
        border-bottom: 2px solid #f8f9fc;
        padding-bottom: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .section-header h5 {
        color: #4e73df;
        font-weight: 600;
        margin: 0;
    }

    .section-header h5 i {
        margin-right: 0.5rem;
    }

    /* Alert Boxes */
    .alert {
        border-radius: 0.35rem;
        border: 1px solid transparent;
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
    }

    .alert-info {
        background-color: #f0f7ff;
        border-color: #c2dfff;
        color: #0066cc;
    }

    /* Badges */
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.25rem;
    }

    .badge.bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .badge.bg-danger {
        background-color: #e74a3b !important;
    }

    .badge.bg-success {
        background-color: #1cc88a !important;
    }

    /* Image Previews */
    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.35rem;
        max-width: 100%;
        height: auto;
    }

    /* Gallery Preview */
    #galleryPreview {
        min-height: 120px;
        padding: 10px;
        border: 1px dashed #d1d3e2;
        border-radius: 0.35rem;
        background-color: #f8f9fc;
    }

    /* Remove buttons on images */
    .position-relative .btn-danger {
        width: 25px;
        height: 25px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }

    /* Switch/Toggle */
    .form-check-input:checked {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .form-check-input:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    /* Tooltips */
    .tooltip {
        font-size: 0.85rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .step-indicator {
            flex-wrap: wrap;
        }

        .step {
            flex: 0 0 33.33%;
            margin-bottom: 1rem;
        }

        .step-circle {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }

        .step-label {
            font-size: 0.75rem;
        }

        .nav-tabs .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .btn {
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 1rem;
        }

        .step {
            flex: 0 0 50%;
        }

        .section-header h5 {
            font-size: 1rem;
        }
    }

    /* Loading Animation */
    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }

        100% {
            opacity: 1;
        }
    }

    .loading {
        animation: pulse 1.5s infinite;
    }

    /* Custom Checkbox/Radio */
    .custom-control-input:checked~.custom-control-label::before {
        border-color: #4e73df;
        background-color: #4e73df;
    }

    /* Helper Text */
    .text-muted small {
        font-size: 0.8rem;
        line-height: 1.4;
    }

    /* Required field indicator */
    .required::after {
        content: " *";
        color: #e74a3b;
    }

    /* Readonly fields */
    .form-control[readonly] {
        background-color: #f8f9fc;
        cursor: not-allowed;
    }

    /* Disabled buttons */
    .btn:disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }

    /* Scrollbar styling for webkit browsers */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Print styles */
    @media print {

        .card-header,
        .card-footer,
        .btn,
        .step-indicator {
            display: none !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }

    /* Hover effects */
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transition: box-shadow 0.3s ease;
    }

    /* Focus styles for accessibility */
    :focus {
        outline: 2px solid #4e73df;
        outline-offset: 2px;
    }

    /* Animation for form elements */
    .form-control,
    .form-select,
    .btn {
        transition: all 0.2s ease-in-out;
    }

    /* Custom file upload button */
    .custom-file-upload {
        display: inline-block;
        padding: 0.5rem 1rem;
        cursor: pointer;
        background-color: #f8f9fc;
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        transition: all 0.2s ease;
    }

    .custom-file-upload:hover {
        background-color: #e9ecef;
        border-color: #b7b9cc;
    }

    /* Price display */
    .original-price {
        text-decoration: line-through;
        color: #858796;
    }

    /* Success message animation */
    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .success-message {
        animation: slideIn 0.5s ease;
    }

    /* Error message styling */
    .error-message {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        padding: 0.75rem 1.25rem;
        border-radius: 0.35rem;
        margin-bottom: 1rem;
    }

    /* Warning message */
    .warning-message {
        background-color: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
        padding: 0.75rem 1.25rem;
        border-radius: 0.35rem;
        margin-bottom: 1rem;
    }

    /* Info message */
    .info-message {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
        padding: 0.75rem 1.25rem;
        border-radius: 0.35rem;
        margin-bottom: 1rem;
    }

    /* Table styling within form */
    .table {
        background-color: white;
        border: 1px solid #e3e6f0;
    }

    .table th {
        background-color: #f8f9fc;
        border-bottom: 2px solid #e3e6f0;
        font-weight: 600;
        color: #5a5c69;
    }

    /* Modal styling */
    .modal-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }

    .modal-title {
        color: #5a5c69;
        font-weight: 600;
    }

    /* Spinner for loading states */
    .spinner-border {
        color: #4e73df;
    }

    /* Card hover effect */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
</style>

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            @isset($course)
                                Edit Course: {{ $course->title }}
                            @else
                                Create New Course
                            @endisset
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back to List
                            </a>
                        </div>
                    </div>

                    <form
                        action="{{ isset($course) ? route('admin.courses.update', $course) : route('admin.courses.store') }}"
                        method="POST" enctype="multipart/form-data" id="courseForm">
                        @csrf
                        @isset($course)
                            @method('PUT')
                        @endisset

                        <!-- Step Progress Indicator -->
                        <div class="card-header">
                            <div class="step-indicator">
                                <div class="step active" data-step="1">
                                    <div class="step-circle">1</div>
                                    <div class="step-label">Basic Info</div>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-circle">2</div>
                                    <div class="step-label">Course Details</div>
                                </div>
                                <div class="step" data-step="3">
                                    <div class="step-circle">3</div>
                                    <div class="step-label">Pricing</div>
                                </div>
                                <div class="step" data-step="4">
                                    <div class="step-circle">4</div>
                                    <div class="step-label">Admission</div>
                                </div>
                                <div class="step" data-step="5">
                                    <div class="step-circle">5</div>
                                    <div class="step-label">Career</div>
                                </div>
                                <div class="step" data-step="6">
                                    <div class="step-circle">6</div>
                                    <div class="step-label">Media</div>
                                </div>
                                <div class="step" data-step="7">
                                    <div class="step-circle">7</div>
                                    <div class="step-label">SEO</div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Tab 1: Basic Information -->
                            <div class="tab-pane active" id="basic-tab" role="tabpanel">
                                @include('admin.course.partials.basic-info')
                            </div>

                            <!-- Tab 2: Course Details -->
                            <div class="tab-pane" id="details-tab" role="tabpanel" style="display: none;">
                                @include('admin.course.partials.course-details')
                            </div>

                            <!-- Tab 3: Pricing -->
                            <div class="tab-pane" id="pricing-tab" role="tabpanel" style="display: none;">
                                @include('admin.course.partials.pricing')
                            </div>

                            <!-- Tab 4: Admission Criteria -->
                            <div class="tab-pane" id="admission-tab" role="tabpanel" style="display: none;">
                                @include('admin.course.partials.admission')
                            </div>

                            <!-- Tab 5: Career Opportunities -->
                            <div class="tab-pane" id="career-tab" role="tabpanel" style="display: none;">
                                @include('admin.course.partials.career')
                            </div>

                            <!-- Tab 6: Media -->
                            <div class="tab-pane" id="media-tab" role="tabpanel" style="display: none;">
                                @include('admin.course.partials.media')
                            </div>

                            <!-- Tab 7: SEO -->
                            <div class="tab-pane" id="seo-tab" role="tabpanel" style="display: none;">
                                @include('admin.course.partials.seo')
                            </div>
                        </div>

                        <div class="card-footer bg-white border-top">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-outline-primary" id="prevBtn"
                                        style="display: none;">
                                        <i class="fas fa-arrow-left mr-1"></i> Previous
                                    </button>
                                    <button type="button" class="btn btn-primary" id="nextBtn">
                                        <i class="fas fa-arrow-right mr-1"></i> Next
                                    </button>
                                    <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                                        <i class="fas fa-save mr-1"></i>
                                        @isset($course)
                                            Update Course
                                        @else
                                            Create Course
                                        @endisset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {
            let currentStep = 1;
            const totalSteps = 7;
            const stepTabs = {
                1: '#basic-tab',
                2: '#details-tab',
                3: '#pricing-tab',
                4: '#admission-tab',
                5: '#career-tab',
                6: '#media-tab',
                7: '#seo-tab'
            };

            // Initialize Summernote
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Initialize tags inputs
            $('#skills_covered, #employment_areas, #job_roles, #top_recruiters').tagsinput({
                trimValue: true,
                confirmKeys: [13, 44, 32]
            });

            @isset($course)
                // Set summernote content
                @if ($course->description)
                    $('#description').summernote('code', `{!! $course->description !!}`);
                @endif

                // Initialize tags with existing data
                @if (!empty($course->skills_covered))
                    @foreach ($course->skills_covered as $skill)
                        $('#skills_covered').tagsinput('add', @json($skill));
                    @endforeach
                @endif
            @endisset

            // Show current step
            showStep(currentStep);

            // Debug logging
            console.log('Initial step:', currentStep);

            // Next button click
            $('#nextBtn').on('click', function() {
                console.log('Next button clicked, current step:', currentStep);
                if (validateStep(currentStep)) {
                    console.log('Validation passed for step:', currentStep);
                    // Mark current step as completed
                    $(`.step[data-step="${currentStep}"]`).removeClass('active').addClass('completed');
                    currentStep++;
                    showStep(currentStep);
                } else {
                    console.log('Validation failed for step:', currentStep);
                }
            });

            // Previous button click
            $('#prevBtn').on('click', function() {
                console.log('Previous button clicked');
                $(`.step[data-step="${currentStep}"]`).removeClass('active completed');
                currentStep--;
                showStep(currentStep);
            });

            function showStep(step) {
                console.log('Showing step:', step);

                // Hide all tabs
                $('.tab-pane').hide();

                // Show current tab
                const tabSelector = stepTabs[step];
                console.log('Tab selector:', tabSelector);
                $(tabSelector).show();

                // Update step indicators
                $('.step').removeClass('active');
                $(`.step[data-step="${step}"]`).addClass('active');

                // Update buttons
                if (step === 1) {
                    $('#prevBtn').hide();
                    $('#nextBtn').show();
                    $('#submitBtn').hide();
                } else if (step === totalSteps) {
                    $('#prevBtn').show();
                    $('#nextBtn').hide();
                    $('#submitBtn').show();
                } else {
                    $('#prevBtn').show();
                    $('#nextBtn').show();
                    $('#submitBtn').hide();
                }

                // Update progress bar
                const progress = ((step - 1) / (totalSteps - 1)) * 100;
                $('.progress-bar').css('width', progress + '%');

                // Scroll to top
                $('html, body').animate({
                    scrollTop: $('.card-body').offset().top - 20
                }, 300);
            }

            function validateStep(step) {
                console.log('Validating step:', step);
                let isValid = true;
                const currentTab = $(stepTabs[step]);

                // Clear previous error messages
                currentTab.find('.is-invalid').removeClass('is-invalid');
                currentTab.find('.invalid-feedback').remove();

                // Check required fields
                currentTab.find('[required]').each(function() {
                    const $field = $(this);
                    let value = '';

                    // Get value based on field type
                    if ($field.hasClass('summernote')) {
                        value = $field.summernote('code').replace(/<[^>]*>/g, '').trim();
                    } else if ($field.attr('type') === 'checkbox' || $field.attr('type') === 'radio') {
                        value = $field.is(':checked');
                    } else if ($field.prop('tagName') === 'SELECT') {
                        value = $field.val();
                    } else if ($field.is('input[type="file"]')) {
                        // Skip file validation for now
                        return;
                    } else {
                        value = $field.val() ? $field.val().trim() : '';
                    }

                    console.log('Checking field:', $field.attr('name'), 'value:', value);

                    // Check if field is empty
                    if (!value || value === '' || value === '<p><br></p>') {
                        console.log('Field is invalid:', $field.attr('name'));
                        $field.addClass('is-invalid');

                        // Get field label
                        let label = 'This field';
                        const $label = $field.closest('.form-group').find('label');
                        if ($label.length) {
                            label = $label.text().replace('*', '').trim();
                        }

                        // Add error message
                        if (!$field.next('.invalid-feedback').length) {
                            $field.after(`<div class="invalid-feedback">${label} is required</div>`);
                        }

                        isValid = false;
                    }
                });

                if (!isValid) {
                    console.log('Validation failed for step', step);
                    // Show first error
                    const firstError = currentTab.find('.is-invalid').first();
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 300);
                        firstError.focus();
                    }

                    // Show error message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please fill all required fields',
                            confirmButtonColor: '#667eea'
                        });
                    } else {
                        alert('Please fill all required fields correctly');
                    }
                } else {
                    console.log('Validation passed for step', step);
                }

                return isValid;
            }

            // Helper function for alerts
            function showAlert(icon, message, title = null) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: icon,
                        title: title || icon === 'error' ? 'Error' : 'Success',
                        text: message,
                        confirmButtonColor: '#667eea'
                    });
                } else {
                    alert((title || icon.toUpperCase()) + ': ' + message);
                }
            }

            // Auto-generate slug from title
            $('#title').on('input', function() {
                const slugField = $('#slug');
                if (!slugField.val() || !slugField.data('user-changed')) {
                    const slug = $(this).val()
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    slugField.val(slug);
                }
            });

            $('#slug').on('input', function() {
                $(this).data('user-changed', true);
            });

            // Calculate discounted price
            $('#fees, #discount_percentage').on('input', function() {
                calculateDiscount();
            });

            function calculateDiscount() {
                const fees = parseFloat($('#fees').val()) || 0;
                const discount = parseFloat($('#discount_percentage').val()) || 0;

                if (discount > 0 && discount <= 100) {
                    const discounted = fees - (fees * discount / 100);
                    $('#discounted_fees').val(discounted.toFixed(2));

                    // Show preview
                    $('#discountPreview').html(`
                    <div class="alert alert-info mt-3">
                        <h6>Price Preview:</h6>
                        <p class="mb-1">
                            <span class="original-price">₹${fees.toFixed(2)}</span>
                            <span class="badge bg-danger ms-2">${discount}% OFF</span>
                        </p>
                        <h4 class="text-primary">₹${discounted.toFixed(2)}</h4>
                        <small class="text-success">You save: ₹${(fees - discounted).toFixed(2)}</small>
                    </div>
                `).show();
                } else {
                    $('#discounted_fees').val(fees.toFixed(2));
                    $('#discountPreview').hide();
                }
            }

            // Initialize discount calculation on page load
            calculateDiscount();

            // Prospectus toggle
            $('#has_prospectus').change(function() {
                if ($(this).is(':checked')) {
                    $('#prospectusFile').slideDown();
                } else {
                    $('#prospectusFile').slideUp();
                }
            });

            // Form submission
            $('#courseForm').submit(function(e) {
                // Validate all steps
                let allValid = true;
                for (let i = 1; i <= totalSteps; i++) {
                    if (!validateStep(i)) {
                        allValid = false;
                        showStep(i);
                        break;
                    }
                }

                if (!allValid) {
                    e.preventDefault();
                    return false;
                }

                // Show loading if Swal available
                if (typeof Swal !== 'undefined') {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Saving Course...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form after showing loading
                    setTimeout(() => {
                        $(this).off('submit').submit();
                    }, 100);
                }
            });

            // Enable step click navigation
            $('.step').click(function() {
                const step = $(this).data('step');
                if (step < currentStep) {
                    // Allow going back
                    $(`.step[data-step="${currentStep}"]`).removeClass('active completed');
                    currentStep = step;
                    showStep(currentStep);
                }
            });

            // Test button click events
            console.log('Next button exists:', $('#nextBtn').length > 0);
            console.log('Prev button exists:', $('#prevBtn').length > 0);
        });
    </script>
@endpush
