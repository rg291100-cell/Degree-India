@extends('admin.layouts.master')

@section('title', 'Student Management')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

<style>
    .avatar-sm {
        width: 40px;
        height: 40px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .action-buttons a,
    .action-buttons button {
        background: none;
        border: none;
        padding: 5px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .action-buttons a:hover,
    .action-buttons button:hover {
        transform: translateY(-2px);
    }

    .action-buttons .view-btn {
        color: #0d6efd;
    }

    .action-buttons .delete-btn {
        color: #dc3545;
    }

    .stat-card {
        border-radius: 12px;
        transition: transform 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon-container {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .badge-pill {
        border-radius: 50px;
        padding: 5px 15px;
        font-weight: 500;
    }

    .empty-state-icon {
        opacity: 0.7;
    }
</style>

@section('content')
    <div class="container-fluid px-4 py-4">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="h2 mb-1">Student Management</h1>
                <p class="text-muted mb-0">Manage all registered students in the system</p>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                <i class="fas fa-users text-primary fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="mb-1 fw-bold">{{ $students->count() }}</h3>
                                <p class="text-muted mb-0">Total Students</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                <i class="fas fa-calendar-check text-success fa-2x"></i>
                            </div>
                            <div>
                                @php
                                    $activeStudents = $students
                                        ->filter(function ($student) {
                                            return $student->bookings_count > 0;
                                        })
                                        ->count();
                                @endphp
                                <h3 class="mb-1 fw-bold">{{ $activeStudents }}</h3>
                                <p class="text-muted mb-0">Active Students</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-info bg-opacity-10 rounded-3 p-3 me-3">
                                <i class="fas fa-user-plus text-info fa-2x"></i>
                            </div>
                            <div>
                                @php
                                    $newThisMonth = $students
                                        ->filter(function ($student) {
                                            return $student->created_at->format('Y-m') == now()->format('Y-m');
                                        })
                                        ->count();
                                @endphp
                                <h3 class="mb-1 fw-bold">{{ $newThisMonth }}</h3>
                                <p class="text-muted mb-0">New This Month</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                                <i class="fas fa-chart-line text-warning fa-2x"></i>
                            </div>
                            <div>
                                @php
                                    $avgBookings = $students->avg('bookings_count');
                                @endphp
                                <h3 class="mb-1 fw-bold">{{ number_format($avgBookings, 1) }}</h3>
                                <p class="text-muted mb-0">Avg. Bookings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">All Students ({{ $students->count() }})</h5>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="studentsTable">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Contact Info</th>
                                <th>Bookings</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark border">#{{ $student->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                                @if ($student->profile_picture)
                                                    <img src="{{ asset('storage/profiles/' . $student->profile_picture) }}"
                                                        alt="{{ $student->name }}" class="rounded-circle"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <i class="fas fa-user text-primary"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $student->name }}</h6>
                                                <small class="text-muted">ID: {{ $student->student_id ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="text-primary">{{ $student->email }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-phone-alt me-1"></i>
                                                {{ $student->phone ?? 'Not Provided' }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill px-3 py-2">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $student->bookings_count ?? 0 }} Bookings
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusColor =
                                                $student->status == 1
                                                    ? 'success'
                                                    : ($student->status == 0
                                                        ? 'danger'
                                                        : 'warning');
                                            $statusText = $student->status == 1 ? 'Active' : 'InActive';
                                        @endphp
                                        <span
                                            class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} border border-{{ $statusColor }} rounded-pill px-3 py-2">

                                            {{ ucfirst($statusText) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">{{ $student->created_at->format('d M Y') }}</span>
                                            <small class="text-muted">{{ $student->created_at->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons justify-content-center">
                                            <a class="view-btn" href="{{ route('admin.students.show', $student->id) }}"
                                                title="View Details">
                                                <i class="fas fa-eye fa-lg"></i>
                                            </a>
                                            <button type="button" class="delete-btn delete-student"
                                                data-student-id="{{ $student->id }}"
                                                data-student-name="{{ $student->name }}" title="Delete Student">
                                                <i class="fas fa-trash-alt fa-lg"></i>
                                            </button>
                                            <form action="{{ route('admin.students.destroy', $student->id) }}"
                                                method="POST" id="delete-form-{{ $student->id }}" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="py-5">
                                            <div class="empty-state-icon mb-3">
                                                <i class="fas fa-users fa-3x text-muted opacity-50"></i>
                                            </div>
                                            <h5 class="text-muted mb-2">No Students Found</h5>
                                            <p class="text-muted mb-4">No students have registered yet.</p>
                                            <a href="#" class="btn btn-primary">
                                                <i class="fas fa-user-plus me-2"></i> Add First Student
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete student <strong id="deleteStudentName"></strong>?</p>
                    <p class="text-muted small">This will permanently remove all student data including their bookings.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete Student</button>
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
            var table = $('#studentsTable').DataTable({
                "pageLength": 10,
                "order": [
                    [0, 'desc']
                ],
                "language": {
                    "search": "Search students:",
                    "lengthMenu": "Show _MENU_ students",
                    "info": "Showing _START_ to _END_ of _TOTAL_ students",
                    "paginate": {
                        "previous": "‹",
                        "next": "›"
                    }
                },
                "columnDefs": [{
                    "targets": [6], // Actions column
                    "orderable": false,
                    "searchable": false
                }]
            });

            // Delete student functionality
            let studentToDelete = null;
            let deleteForm = null;

            $(document).on('click', '.delete-student', function(e) {
                e.preventDefault();
                studentToDelete = $(this).data('student-id');
                const studentName = $(this).data('student-name');
                deleteForm = $('#delete-form-' + studentToDelete);

                $('#deleteStudentName').text(studentName);
                $('#deleteConfirmationModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                if (deleteForm) {
                    // Show loading state
                    const deleteBtn = $(this);
                    deleteBtn.html(
                            '<span class="spinner-border spinner-border-sm me-2"></span> Deleting...')
                        .prop('disabled', true);

                    // Submit the form
                    deleteForm.submit();
                }
            });

            // Reset delete button state when modal is hidden
            $('#deleteConfirmationModal').on('hidden.bs.modal', function() {
                $('#confirmDelete').html('Delete Student').prop('disabled', false);
                studentToDelete = null;
                deleteForm = null;
            });

            // Success message display
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    timer: 4000,
                    showConfirmButton: true
                });
            @endif
        });
    </script>
@endsection
