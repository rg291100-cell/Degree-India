@extends('admin.layouts.master')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .filter-form .form-group,
    .filter-form .form-control {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    td {
        font-size: 13px !important;
    }

    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-group .dropdown-menu {
        min-width: 120px;
    }

    .swal2-toast {
        font-size: 12px !important;
        padding: 6px 10px !important;
        min-width: auto !important;
        width: 220px !important;
        line-height: 1.3em !important;
    }

    .swal2-toast .swal2-icon {
        width: 24px !important;
        height: 24px !important;
        margin-right: 6px !important;
    }

    .swal2-toast .swal2-title {
        font-size: 13px !important;
    }

    .badge-success {
        background-color: #28a745 !important;
        color: #fff !important;
    }

    .badge-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    .badge-secondary {
        background-color: #6c757d !important;
        color: #fff !important;
    }

    .filter-form {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #dee2e6;
    }

    .filter-form .form-group {
        margin-bottom: 0;
    }
</style>
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Courses</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New Course
                            </a>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="card-body">
                        <div class="filter-form">
                            <form method="GET" action="{{ route('admin.courses.index') }}" id="filterForm">
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="category" class="form-label">Filter by Category</label>
                                            <select name="category" id="category" class="form-control form-control-sm">
                                                <option value="">All Categories</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="course_type" class="form-label">Course Type</label>
                                            <select name="course_type" id="course_type"
                                                class="form-control form-control-sm">
                                                <option value="">All Types</option>
                                                <option value="Certificate"
                                                    {{ request('course_type') == 'Certificate' ? 'selected' : '' }}>
                                                    Certificate Course
                                                </option>
                                                <option value="Diploma"
                                                    {{ request('course_type') == 'Diploma' ? 'selected' : '' }}>
                                                    Diploma
                                                </option>
                                                <option value="Graduate"
                                                    {{ request('course_type') == 'Graduate' ? 'selected' : '' }}>
                                                    Graduate
                                                </option>
                                                <option value="Post Graduate"
                                                    {{ request('course_type') == 'Post Graduate' ? 'selected' : '' }}>
                                                    Post Graduate
                                                </option>
                                                <option value="10th After"
                                                    {{ request('course_type') == '10th After' ? 'selected' : '' }}>
                                                    Courses After 10th
                                                </option>
                                                <option value="12th Science"
                                                    {{ request('course_type') == '12th Science' ? 'selected' : '' }}>
                                                    12th Science
                                                </option>
                                                <option value="12th Commerce"
                                                    {{ request('course_type') == '12th Commerce' ? 'selected' : '' }}>
                                                    12th Commerce
                                                </option>
                                                <option value="12th Arts"
                                                    {{ request('course_type') == '12th Arts' ? 'selected' : '' }}>
                                                    12th Arts
                                                </option>
                                                <option value="Online"
                                                    {{ request('course_type') == 'Online' ? 'selected' : '' }}>
                                                    Online Courses
                                                </option>
                                                <option value="Job Oriented"
                                                    {{ request('course_type') == 'Job Oriented' ? 'selected' : '' }}>
                                                    Job Oriented Courses
                                                </option>
                                                <option value="Skill Based"
                                                    {{ request('course_type') == 'Skill Based' ? 'selected' : '' }}>
                                                    Skill Courses
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" id="status" class="form-control form-control-sm">
                                                <option value="">All Status</option>
                                                <option value="published"
                                                    {{ request('status') == 'published' ? 'selected' : '' }}>
                                                    Published
                                                </option>
                                                <option value="draft"
                                                    {{ request('status') == 'draft' ? 'selected' : '' }}>
                                                    Draft
                                                </option>
                                                <option value="archived"
                                                    {{ request('status') == 'archived' ? 'selected' : '' }}>
                                                    Archived
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="course_mode" class="form-label">Course Mode</label>
                                            <select name="course_mode" id="course_mode"
                                                class="form-control form-control-sm">
                                                <option value="">All Modes</option>
                                                <option value="online"
                                                    {{ request('course_mode') == 'online' ? 'selected' : '' }}>
                                                    Online
                                                </option>
                                                <option value="offline"
                                                    {{ request('course_mode') == 'offline' ? 'selected' : '' }}>
                                                    Offline
                                                </option>
                                                <option value="both"
                                                    {{ request('course_mode') == 'both' ? 'selected' : '' }}>
                                                    Both (Hybrid)
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 d-flex justify-content-between">
                                        <div>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-filter"></i> Apply Filters
                                            </button>
                                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-redo"></i> Reset
                                            </a>
                                        </div>

                                        @if (request()->has('category') ||
                                                request()->has('status') ||
                                                request()->has('course_type') ||
                                                request()->has('course_mode'))
                                            <div>
                                                <span class="badge badge-info">
                                                    <i class="fas fa-filter"></i> Filters Active
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Export Buttons - Aligned to Right -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="exportData('print')">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            onclick="exportData('pdf')">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-sm"
                                            onclick="exportData('csv')">
                                            <i class="fas fa-file-excel"></i> CSV
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="courseTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Thumbnail</th>
                                        <th>Title</th>
                                        <th>Course Type</th>
                                        <th>Course Mode</th>
                                        <th>Category</th>
                                        <th>Duration</th>
                                        <th>Fees</th>
                                        <th>Status</th>
                                        <th>Featured</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = ($courses->currentPage() - 1) * $courses->perPage() + 1;
                                    @endphp
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>
                                                @php
                                                    $imagePath = $course->thumbnail_image;

                                                    // Actual file check (storage folder)
                                                    $exists =
                                                        $imagePath &&
                                                        file_exists(
                                                            storage_path(
                                                                'app/public/' . str_replace('storage/', '', $imagePath),
                                                            ),
                                                        );

                                                    $finalImage = $exists
                                                        ? asset('storage/' . $imagePath)
                                                        : asset('storage/courses/thumbnails/dummy.jpeg');
                                                @endphp

                                                <img src="{{ $finalImage }}" alt="{{ $course->title }}"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>

                                            <td>{{ $course->title }}</td>
                                            <td>{{ $course->course_type }}</td>
                                            <td>{{ $course->course_mode }}</td>
                                            <td>
                                                <span class="badge bd-info" style="color: purple">
                                                    {{ $course->category->name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>{{ $course->duration_text }}</td>
                                            <td>{{ $course->formatted_fees }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $course->status == 'published' ? 'success' : ($course->status == 'draft' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($course->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($course->featured)
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group"
                                                    aria-label="Course Actions">
                                                    <a href="{{ route('admin.courses.edit', $course) }}"
                                                        class="btn btn-warning" title="Edit" style="height: 25px;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.courses.show', $course) }}"
                                                        class="btn btn-info" title="View" style="height: 25px;">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('admin.courses.destroy', $course) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Delete"
                                                            style="height: 25px;"
                                                            onclick="return confirm('Are you sure you want to delete this course?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($courses->isEmpty())
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
                                                <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                                No courses found.
                                                @if (request()->has('category') || request()->has('status') || request()->has('featured'))
                                                    Try changing your filter criteria.
                                                @else
                                                    <a href="{{ route('admin.courses.create') }}"
                                                        class="btn btn-link">Add
                                                        your first course</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $courses->appends(request()->query())->links() }}
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {
            // Initialize DataTable
            $('#courseTable').DataTable({
                "pageLength": 5,
                "responsive": true,
                "ordering": true,
                "info": true,
                "paging": true,
                "searching": false,
                "language": {
                    "emptyTable": "No courses available"
                },
                "dom": 'lrtip' // Hide default search box
            });

            // Export functions
            window.exportData = function(format) {
                // Get current filter values
                const category = $('#category').val();
                const status = $('#status').val();
                const course_type = $('#course_type').val();
                const course_mode = $('#course_mode').val();

                // Build export URL with current filters
                let url = '{{ route('admin.courses.index') }}?export=' + format;

                if (category) url += '&category=' + category;
                if (status) url += '&status=' + status;
                if (course_type) url += '&course_type=' + course_type;
                if (course_mode) url += '&course_mode=' + course_mode;

                if (format === 'print') {
                    // Open print view in new window
                    window.open(url + '&auto_print=1', '_blank');
                } else {
                    // Download PDF or CSV
                    window.location.href = url;
                }
            };

            // Export selected rows (if you add checkboxes)
            window.exportSelectedRows = function() {
                // This requires adding checkboxes to your table
                Swal.fire({
                    title: 'Coming Soon!',
                    text: 'Selective export feature will be available soon.',
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            };

            // Auto-submit form on filter change (optional)
            $('#category, #status, #featured').change(function() {
                // If you want auto-filtering, uncomment below line
                // $('#filterForm').submit();
            });

            // Toast notification
            function showToast(message, type = 'success') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: type,
                    title: message
                });
            }

            // Display success/error messages from session
            @if (session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif

            @if (session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
        });
    </script>
@endsection
