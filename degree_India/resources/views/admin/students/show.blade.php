@extends('admin.layouts.master')

@section('title', 'Student Details')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@section('content')
    <div class="container-fluid px-4 py-4">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="h2 mb-1">Student Details</h1>
            </div>
            <div>
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Students
                </a>
            </div>
        </div>


        <!-- Student Details Card -->
        <div class="row">
            <!-- Student Information -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <!-- Profile picture section में -->
                            @if ($student->profile_picture)
                                <!-- ये $student होगा क्योंकि loop में है -->
                                <img src="{{ asset('storage/profiles/' . $student->profile_picture) }}"
                                    alt="{{ $student->name }}" class="rounded-circle"
                                    style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <i class="fas fa-user text-primary"></i>
                            @endif
                            <h4 class="mb-1">{{ $student->name }}</h4>
                            <p class="text-muted mb-2">{{ $student->email }}</p>
                            @php
                                $statusColor =
                                    $student->status == 1 ? 'success' : ($student->status == 0 ? 'danger' : 'warning');
                            @endphp
                            <span
                                class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} border border-{{ $statusColor }} rounded-pill px-3 py-2">

                                {{ ucfirst($student->status == 1 ? 'Active' : 'InActive') }}
                            </span>
                        </div>

                        <div class="student-info">
                            <h6 class="text-muted mb-3"><i class="fas fa-info-circle me-2"></i> Student Information</h6>
                            <div class="mb-2">
                                <small class="text-muted d-block">Student ID</small>
                                <strong>{{ $student->student_id ?? 'Not Assigned' }}</strong>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted d-block">Phone Number</small>
                                <strong>{{ $student->phone ?? 'Not Provided' }}</strong>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted d-block">Date of Birth</small>
                                <strong>{{ $student->dob ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : 'Not Provided' }}</strong>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted d-block">Gender</small>
                                <strong>{{ ucfirst($student->gender ?? 'Not Specified') }}</strong>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics & Bookings -->
            <div class="col-lg-8 mb-4">
                <div class="row mb-4">
                    <!-- Stats Cards -->
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="stat-icon-container bg-primary bg-opacity-10 rounded-3 p-3 mx-auto mb-3">
                                    <i class="fas fa-calendar-check text-primary fa-2x"></i>
                                </div>
                                <h3 class="mb-1 fw-bold">{{ $student->bookings->count() ?? 0 }}</h3>
                                <p class="text-muted mb-0">Total Bookings</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="stat-icon-container bg-success bg-opacity-10 rounded-3 p-3 mx-auto mb-3">
                                    <i class="fas fa-check-circle text-success fa-2x"></i>
                                </div>
                                <h3 class="mb-1 fw-bold">
                                    {{ $student->bookings->where('status', 'completed')->count() ?? 0 }}</h3>
                                <p class="text-muted mb-0">Completed</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="stat-icon-container bg-info bg-opacity-10 rounded-3 p-3 mx-auto mb-3">
                                    <i class="fas fa-clock text-info fa-2x"></i>
                                </div>
                                <h3 class="mb-1 fw-bold">{{ $student->bookings->where('status', 'pending')->count() ?? 0 }}
                                </h3>
                                <p class="text-muted mb-0">Pending</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0"><i class="fas fa-history me-2"></i> Recent Bookings</h5>
                            <span class="badge bg-light text-dark">{{ $student->bookings_count ?? 0 }} Total</span>
                        </div>

                        @if ($student->bookings && $student->bookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time Slot</th>
                                            <th>Language</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($student->bookings->take(5) as $booking)
                                            <tr>
                                                <td>{{ $booking->month }} {{ $booking->year }}</td>
                                                <td>{{ $booking->slot }}</td>
                                                <td>{{ $booking->language }}</td>
                                                <td>
                                                    @php
                                                        $bookingStatusColor =
                                                            $booking->status == 'completed'
                                                                ? 'success'
                                                                : ($booking->status == 'cancelled'
                                                                    ? 'danger'
                                                                    : 'warning');
                                                    @endphp
                                                    <span class="badge bg-{{ $bookingStatusColor }}">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($student->bookings->count() > 5)
                                <div class="text-center mt-3">
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        View All Bookings <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-alt fa-3x text-muted opacity-50 mb-3"></i>
                                <p class="text-muted">No bookings found for this student.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-4"><i class="fas fa-user-cog me-2"></i> Account Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">Registration Date</small>
                                <strong>{{ $student->created_at->format('d M Y, h:i A') }}</strong>
                            </div>
                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">Last Updated</small>
                                <strong>{{ $student->updated_at->format('d M Y, h:i A') }}</strong>
                            </div>
                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">Last Login</small>
                                <strong>{{ $student->last_login_at ? \Carbon\Carbon::parse($student->last_login_at)->format('d M Y, h:i A') : 'Never' }}</strong>
                            </div>
                        </div>
                    </div>
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
                    <p>Are you sure you want to delete student <strong>{{ $student->name }}</strong>?</p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


    <script>
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {
            // Delete student confirmation
            $('.delete-student-btn').on('click', function(e) {
                e.preventDefault();
                $('#deleteConfirmationModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                const deleteBtn = $(this);
                deleteBtn.html('<span class="spinner-border spinner-border-sm me-2"></span> Deleting...')
                    .prop('disabled', true);

                $('#deleteForm').submit();
            });
        });
    </script>
@endsection
