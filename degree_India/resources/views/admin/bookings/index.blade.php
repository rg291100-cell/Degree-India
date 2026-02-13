@extends('admin.layouts.master')

@section('title', 'Booking Slots Management')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .avatar-sm {
        width: 40px;
        height: 40px;
    }

    .empty-state-icon {
        opacity: 0.7;
    }

    .dropdown-menu {
        font-size: 0.875rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .flag-icon {
        width: 1.5em;
        height: 1em;
        background-size: contain;
        background-position: 50%;
        background-repeat: no-repeat;
        display: inline-block;
    }

    /* Action buttons styling */
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

    .action-buttons .edit-btn {
        color: #198754;
    }

    .action-buttons .delete-btn {
        color: #dc3545;
    }

    .action-buttons .assign-btn {
        color: #20c997;
    }

    /* Fixed table header */
    #bookingsTable_wrapper {
        padding-top: 0;
    }

    /* DataTable custom styling */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 20px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
    }

    /* Filter Form Styling */
    .filter-form {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .filter-form .form-label {
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 5px;
        color: #495057;
    }

    .filter-form .form-control-sm {
        font-size: 0.875rem;
        height: calc(1.5em + 0.5rem + 2px);
    }

    .action-buttons .conversation-btn {
        color: #17a2b8;
    }

    .action-buttons .conversation-btn:hover {
        color: #138496;
    }

    .active-filters {
        background: #e7f1ff;
        padding: 10px 15px;
        border-radius: 6px;
        margin-bottom: 15px;
        border-left: 4px solid #0d6efd;
    }

    .active-filters-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
    }

    .counselor-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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
</style>

@section('content')
    <div class="container-fluid px-4 py-4">

        <!-- Page Header with Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1">Booking Slots Management</h1>
                <p class="text-muted mb-0">Manage and view all student booking preferences and schedules</p>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="filter-form">
            <form method="GET" action="{{ route('admin.booking-slot.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <!-- Month Filter -->
                    <div class="col-md-2">
                        <label for="month" class="form-label">Month</label>
                        <select name="month" id="month" class="form-control form-control-sm">
                            <option value="">All Months</option>
                            @foreach ($allMonths as $month)
                                <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year Filter -->
                    <div class="col-md-2">
                        <label for="year" class="form-label">Year</label>
                        <select name="year" id="year" class="form-control form-control-sm">
                            <option value="">All Years</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}"
                                    {{ request('year') == $year || (!request('year') && $year == $currentYear) ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Slot Time Filter -->
                    <div class="col-md-3">
                        <label for="slot" class="form-label">Slot Time</label>
                        <select name="slot" id="slot" class="form-control form-control-sm">
                            <option value="">All Slots</option>
                            @foreach ($slots as $slot)
                                <option value="{{ $slot->id }}" {{ request('slot') == $slot->id ? 'selected' : '' }}>
                                    {{ $slot->slot_time }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <!-- Student Name Search -->
                    <div class="col-md-3">
                        <label for="student_name" class="form-label">Student Name</label>
                        <input type="text" name="student_name" id="student_name" class="form-control form-control-sm"
                            placeholder="Search by name..." value="{{ request('student_name') }}">
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-12 mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-filter"></i> Apply Filters
                                </button>
                                <a href="{{ route('admin.booking-slot.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>

                            <!-- Export Buttons -->
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="exportData('print')">
                                    <i class="fas fa-print"></i> Print
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="exportData('pdf')">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </button>
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="exportData('csv')">
                                    <i class="fas fa-file-excel"></i> CSV
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Active Filters Indicator -->
            @if (request()->has('month') ||
                    request()->has('year') ||
                    request()->has('language') ||
                    request()->has('slot') ||
                    request()->has('counselor') ||
                    request()->has('student_name'))
                <div class="active-filters mt-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-filter text-primary me-2"></i>
                        <small class="me-3">Active Filters:</small>
                        @if (request('month'))
                            <span class="badge bg-primary active-filters-badge me-2">
                                Month: {{ request('month') }}
                            </span>
                        @endif
                        @if (request('year'))
                            <span class="badge bg-primary active-filters-badge me-2">
                                Year: {{ request('year') }}
                            </span>
                        @endif

                        @if (request('slot'))
                            <span class="badge bg-primary active-filters-badge me-2">
                                Slot: {{ request('slot') }}
                            </span>
                        @endif

                        @if (request('student_name'))
                            <span class="badge bg-primary active-filters-badge me-2">
                                Student: {{ request('student_name') }}
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-4 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-primary bg-opacity-10 rounded-3 p-2 me-2">
                                <i class="fas fa-calendar-check text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">{{ $totalBookings }}</h4>
                                <p class="text-muted mb-0 small">Total Bookings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-4 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-success bg-opacity-10 rounded-3 p-2 me-2">
                                <i class="fas fa-user-check text-success fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">{{ $assignedBookings }}</h4>
                                <p class="text-muted mb-0 small">Assigned</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-4 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-warning bg-opacity-10 rounded-3 p-2 me-2">
                                <i class="fas fa-user-times text-warning fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">{{ $unassignedBookings }}</h4>
                                <p class="text-muted mb-0 small">Unassigned</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-md-4 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-dark bg-opacity-10 rounded-3 p-2 me-2">
                                <i class="fas fa-clock text-dark fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">{{ $currentMonthBookings }}</h4>
                                <p class="text-muted mb-0 small">This Month</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        Student Bookings ({{ $bookings->count() }})
                        @if (request()->hasAny(['month', 'year', 'language', 'slot', 'counselor', 'student_name']))
                            <small class="text-muted ms-2">(Filtered Results)</small>
                        @endif
                    </h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="bookingsTable">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Slot Time</th>
                                <th>Language</th>
                                <th>Counselor</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark border">#{{ $booking->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $booking->student->name ?? 'N/A' }}</h6>
                                                <small class="text-muted">Student ID:
                                                    {{ $booking->student_id ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="text-primary">{{ $booking->student->email ?? 'N/A' }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-phone-alt me-1"></i>
                                                {{ $booking->student->phone ?? 'Not Provided' }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">{{ $booking->month }}</span>
                                            <small class="text-muted">{{ $booking->year }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            // Fetch slot info from BookingSlots table
                                            $slot = $booking->slotRelation ?? null; // Make sure you define relationship

                                            // Determine badge color
                                            $slotColor = 'secondary'; // default color
                                            if ($slot) {
                                                $slotColor = str_contains($slot->slot_time, 'AM')
                                                    ? 'info'
                                                    : (str_contains($slot->slot_time, 'PM')
                                                        ? 'warning'
                                                        : 'success');
                                            }
                                        @endphp

                                        @if ($slot)
                                            <div
                                                class="badge bg-{{ $slotColor }} bg-opacity-10 text-{{ $slotColor }} border border-{{ $slotColor }} rounded-pill px-3 py-2">
                                                <i class="fas fa-clock me-1"></i> {{ $slot->slot_time }}
                                            </div>
                                        @else
                                            <div
                                                class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3 py-2">
                                                N/A
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            @php
                                                $flagIcon = match (strtolower($booking->language)) {
                                                    'english' => 'flag-icon-gb',
                                                    'spanish' => 'flag-icon-es',
                                                    'french' => 'flag-icon-fr',
                                                    'german' => 'flag-icon-de',
                                                    default => 'fa-globe',
                                                };
                                            @endphp
                                            @if (str_starts_with($flagIcon, 'flag-icon'))
                                                <span class="flag-icon {{ $flagIcon }} me-2"
                                                    style="font-size: 1.2em"></span>
                                            @else
                                                <i class="fas {{ $flagIcon }} me-2"></i>
                                            @endif
                                            {{ $booking->language }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($booking->counselor)
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-success counselor-badge" data-bs-toggle="tooltip"
                                                    title="{{ $booking->counselor->name }}">
                                                    <i class="fas fa-user-check me-1"></i>
                                                    {{ $booking->counselor->name }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="badge bg-warning counselor-badge">
                                                <i class="fas fa-user-times me-1"></i> Not Assigned
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons justify-content-center">
                                            <a class="view-btn view-booking" href="#" data-bs-toggle="modal"
                                                data-bs-target="#viewBookingModal" data-booking-id="{{ $booking->id }}"
                                                title="View Details">
                                                <i class="fas fa-eye fa-sm"></i>
                                            </a>
                                            <!-- Conversation Button -->
                                            @hasPermission('view-session-conversation')
                                                <a href="{{ route('admin.bookings.conversation', $booking->id) }}"
                                                    class="conversation-btn" title="Conversation Summary">
                                                    <i class="fas fa-comments fa-sm" style="color: #17a2b8;"></i>
                                                </a>
                                            @endhasPermission

                                            @hasPermission('assign-session-counselor')
                                                <button type="button" class="assign-btn assign-counselor-btn"
                                                    data-booking-id="{{ $booking->id }}"
                                                    data-booking-month="{{ $booking->month }}"
                                                    data-booking-year="{{ $booking->year }}"
                                                    data-booking-slot="{{ $booking->slot }}"
                                                    data-booking-language="{{ $booking->language }}"
                                                    data-student-name="{{ $booking->student->name ?? 'N/A' }}"
                                                    data-counselor-id="{{ $booking->counselor_id }}"
                                                    data-counselor-name="{{ $booking->counselor->name ?? '' }}"
                                                    data-bs-toggle="modal" data-bs-target="#assignCounselorModal"
                                                    title="Assign Counselor">
                                                    <i class="fas fa-user-plus fa-sm"></i>
                                                </button>
                                            @endhasPermission
                                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}"
                                                method="POST" id="delete-form-{{ $booking->id }}"
                                                style="display: inline; margin-bottom: 0px;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-btn delete-booking"
                                                    data-booking-id="{{ $booking->id }}"
                                                    data-booking-name="{{ $booking->student->name ?? 'Booking #' . $booking->id }}"
                                                    title="Delete Booking">
                                                    <i class="fas fa-trash-alt fa-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="py-5">
                                            <div class="empty-state-icon mb-3">
                                                <i class="fas fa-calendar-alt fa-3x text-muted opacity-50"></i>
                                            </div>
                                            <h5 class="text-muted mb-2">No Bookings Found</h5>
                                            <p class="text-muted mb-4">
                                                @if (request()->hasAny(['month', 'year', 'language', 'slot', 'counselor', 'student_name']))
                                                    No bookings match your filter criteria. Try changing your filters.
                                                @else
                                                    Students haven't booked any slots yet.
                                                @endif
                                            </p>
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

    <!-- View Booking Modal -->
    <div class="modal fade" id="viewBookingModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="booking-details-content">
                        <!-- Content will be loaded here via AJAX -->
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Counselor Modal -->
    <div class="modal fade" id="assignCounselorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i> Assign Counselor
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="assignCounselorForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="booking_id" id="booking_id">

                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Booking Information</h6>
                            <div class="alert alert-light">
                                <div class="row small">
                                    <div class="col-6">
                                        <strong>Student:</strong><br>
                                        <span id="modal_student_name">N/A</span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Session:</strong><br>
                                        <span id="modal_session_info">N/A</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="counselor_id" class="form-label">Select Counselor *</label>
                            <select name="counselor_id" id="counselor_id" class="form-control form-select" required>
                                <option value="">-- Select Counselor --</option>
                                @foreach ($counselorList as $counselor)
                                    <option value="{{ $counselor->id }}">{{ $counselor->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Choose a counselor to assign for this session</div>
                        </div>

                        <div class="alert alert-info small mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            The assigned counselor will be responsible for conducting this session.
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveCounselorBtn">Assign Counselor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Remove Counselor Modal -->
    <div class="modal fade" id="removeCounselorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-warning">
                        <i class="fas fa-user-times me-2"></i> Remove Counselor
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove <strong id="removeCounselorName"></strong> from this booking?</p>
                    <p class="text-muted small">The booking will become unassigned and available for reassignment.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="confirmRemove">Remove Counselor</button>
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
                    <p>Are you sure you want to delete booking for <strong id="deleteBookingName"></strong>?</p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete Booking</button>
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

    <!-- Flag icons for languages -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

    <script>
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#bookingsTable').DataTable({
                "pageLength": 10,
                "order": [
                    [0, 'desc']
                ],
                "language": {
                    "search": "Search bookings:",
                    "lengthMenu": "Show _MENU_ bookings",
                    "info": "Showing _START_ to _END_ of _TOTAL_ bookings",
                    "paginate": {
                        "previous": "‹",
                        "next": "›"
                    }
                },
                "columnDefs": [{
                    "targets": [7], // Actions column
                    "orderable": false,
                    "searchable": false
                }]
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Export function
            window.exportData = function(format) {
                // Get current filter values
                const month = $('#month').val();
                const year = $('#year').val();
                const language = $('#language').val();
                const slot = $('#slot').val();
                const counselor = $('#counselor').val();
                const studentName = $('#student_name').val();

                // Build export URL with current filters
                let url = '{{ route('admin.booking-slot.index') }}?export=' + format;

                if (month) url += '&month=' + month;
                if (year) url += '&year=' + year;
                if (language) url += '&language=' + language;
                if (request('slot')) {
                    url += '&slot=' + request('slot');
                }
                if (counselor) url += '&counselor=' + counselor;
                if (studentName) url += '&student_name=' + encodeURIComponent(studentName);

                if (format === 'print') {
                    // Open print view in new window
                    window.open(url + '&auto_print=1', '_blank');
                } else {
                    // Download PDF or CSV
                    window.location.href = url;
                }
            };



            // Assign Counselor Modal
            $(document).on('click', '.assign-counselor-btn', function(e) {
                e.preventDefault();

                const bookingId = $(this).data('booking-id');
                const studentName = $(this).data('student-name');
                const month = $(this).data('booking-month');
                const year = $(this).data('booking-year');
                // const slot = $(this).data('booking-slot');
                const language = $(this).data('booking-language');
                const counselorId = $(this).data('counselor-id');
                const counselorName = $(this).data('counselor-name');

                const slot = $('#slot').val();
                if (slot) {
                    url += '&slot=' + slot;
                }

                // Set modal data
                $('#booking_id').val(bookingId);
                $('#modal_student_name').text(studentName);
                $('#modal_session_info').text(`${month} ${year} | ${slot} | ${language}`);

                // Set selected counselor if already assigned
                if (counselorId) {
                    $('#counselor_id').val(counselorId);
                } else {
                    $('#counselor_id').val('');
                }

                // Set form action
                $('#assignCounselorForm').attr('action', '{{ route('admin.bookings.assign', ':id') }}'
                    .replace(':id', bookingId));

                // Set modal title based on action
                if (counselorId) {
                    $('.modal-title').html('<i class="fas fa-user-edit me-2"></i> Change Counselor');
                    $('#saveCounselorBtn').text('Update Counselor');
                } else {
                    $('.modal-title').html('<i class="fas fa-user-plus me-2"></i> Assign Counselor');
                    $('#saveCounselorBtn').text('Assign Counselor');
                }
            });

            // Handle Assign Counselor Form Submission
            $('#assignCounselorForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitBtn = $('#saveCounselorBtn');
                const originalText = submitBtn.text();

                // Show loading
                submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span> Processing...')
                    .prop('disabled', true);

                const formData = new FormData(this);
                const bookingId = $('#booking_id').val();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Close modal
                            $('#assignCounselorModal').modal('hide');

                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            // Reload page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });

                        // Reset button
                        submitBtn.text(originalText).prop('disabled', false);
                    }
                });
            });

            // Remove Counselor functionality
            let bookingToRemoveCounselor = null;

            $(document).on('click', '.remove-counselor-btn', function(e) {
                e.preventDefault();
                bookingToRemoveCounselor = $(this).data('booking-id');
                const counselorName = $(this).data('counselor-name');

                $('#removeCounselorName').text(counselorName);
                $('#removeCounselorModal').modal('show');
            });

            $('#confirmRemove').on('click', function() {
                if (bookingToRemoveCounselor) {
                    const removeBtn = $(this);
                    removeBtn.html(
                            '<span class="spinner-border spinner-border-sm me-2"></span> Removing...')
                        .prop('disabled', true);

                    $.ajax({
                        url: '{{ route('admin.bookings.remove-counselor', ':id') }}'.replace(':id',
                            bookingToRemoveCounselor),
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#removeCounselorModal').modal('hide');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to remove counselor'
                            });
                            removeBtn.text('Remove Counselor').prop('disabled', false);
                        }
                    });
                }
            });

            // View booking details with AJAX
            $(document).on('click', '.view-booking', function(e) {
                e.preventDefault();
                const bookingId = $(this).data('booking-id');

                // Show loading state
                $('.booking-details-content').html(`
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3">Loading booking details...</p>
                    </div>
                `);

                $.ajax({
                    url: '{{ route('admin.bookings.show', ':id') }}'.replace(':id', bookingId),
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const booking = response.data;
                            const counselorInfo = booking.counselor ?
                                `<span class="badge bg-success">${booking.counselor.name}</span>` :
                                `<span class="badge bg-warning">Not Assigned</span>`;

                            const modalContent = `
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card border-0 bg-light mb-3">
                                            <div class="card-body">
                                                <h6 class="text-muted mb-3"><i class="fas fa-calendar-alt me-2"></i> Booking Information</h6>
                                                <div class="row mb-2">
                                                    <div class="col-6"><small class="text-muted">Booking ID</small></div>
                                                    <div class="col-6 text-end"><strong>#${booking.id}</strong></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-6"><small class="text-muted">Date</small></div>
                                                    <div class="col-6 text-end"><strong>${booking.month} ${booking.year}</strong></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-6"><small class="text-muted">Time Slot</small></div>
                                                    <div class="col-6 text-end"><strong>${booking.slot}</strong></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-6"><small class="text-muted">Language</small></div>
                                                    <div class="col-6 text-end"><strong>${booking.language}</strong></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-6"><small class="text-muted">Counselor</small></div>
                                                    <div class="col-6 text-end">${counselorInfo}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-0 bg-light mb-3">
                                            <div class="card-body">
                                                <h6 class="text-muted mb-3"><i class="fas fa-user-graduate me-2"></i> Student Information</h6>
                                                <div class="row mb-2">
                                                    <div class="col-6"><small class="text-muted">Name</small></div>
                                                    <div class="col-6 text-end"><strong>${booking.student.name}</strong></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-6"><small class="text-muted">Student ID</small></div>
                                                    <div class="col-6 text-end"><strong>${booking.student_id}</strong></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-6"><small class="text-muted">Email</small></div>
                                                    <div class="col-6 text-end"><strong>${booking.student.email}</strong></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6"><small class="text-muted">Phone</small></div>
                                                    <div class="col-6 text-end"><strong>${booking.student.phone || 'Not Provided'}</strong></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <small>Booking created on ${booking.created_at_formatted}. Last updated on ${booking.updated_at_formatted}.</small>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('.booking-details-content').html(modalContent);
                        }
                    },
                    error: function() {
                        $('.booking-details-content').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Failed to load booking details. Please try again.
                            </div>
                        `);
                    }
                });
            });

            // Delete booking functionality
            let bookingToDelete = null;
            let deleteForm = null;

            $(document).on('click', '.delete-booking', function(e) {
                e.preventDefault();
                bookingToDelete = $(this).data('booking-id');
                const bookingName = $(this).data('booking-name');
                deleteForm = $(this).closest('form');

                $('#deleteBookingName').text(bookingName);
                $('#deleteConfirmationModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                if (deleteForm) {
                    const deleteBtn = $(this);
                    deleteBtn.html(
                            '<span class="spinner-border spinner-border-sm me-2"></span> Deleting...')
                        .prop('disabled', true);

                    deleteForm.submit();
                }
            });

            // Reset delete button state when modal is hidden
            $('#deleteConfirmationModal').on('hidden.bs.modal', function() {
                $('#confirmDelete').html('Delete Booking').prop('disabled', false);
                bookingToDelete = null;
                deleteForm = null;
            });

            // Show success/error messages
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif
        });
    </script>
@endsection
