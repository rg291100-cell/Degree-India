@extends('admin.layouts.master')

@section('title', 'Manage Booking Slots')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
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
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1">Manage Booking Slots</h1>
                <p class="text-muted mb-0">Create and manage time slots for student bookings</p>
            </div>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateSlotsModal">
                    <i class="fas fa-plus me-2"></i>Generate Slots
                </button>
                <a href="{{ route('admin.slots.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle me-2"></i>Add Single Slot
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-primary bg-opacity-10 rounded-3 p-2 me-2">
                                <i class="fas fa-clock text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">{{ $stats['total_slots'] }}</h4>
                                <p class="text-muted mb-0 small">Total Slots</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-success bg-opacity-10 rounded-3 p-2 me-2">
                                <i class="fas fa-check-circle text-success fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">{{ $stats['active_slots'] }}</h4>
                                <p class="text-muted mb-0 small">Active Slots</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-info bg-opacity-10 rounded-3 p-2 me-2">
                                <i class="fas fa-calendar-alt text-info fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">{{ $stats['available_slots'] }}</h4>
                                <p class="text-muted mb-0 small">Available Slots</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-container bg-warning bg-opacity-10 rounded-3 p-2 me-2">
                                <i class="fas fa-exclamation-triangle text-warning fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">{{ $stats['full_slots'] }}</h4>
                                <p class="text-muted mb-0 small">Full Slots</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slots Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">Booking Slots ({{ $slots->count() }})</h5>
                    {{-- <form action="{{ route('admin.slots.reset-bookings') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-warning"
                            onclick="return confirm('Reset all booking counts? This will recalculate from actual bookings.')">
                            <i class="fas fa-sync-alt me-1"></i> Reset Bookings
                        </button>
                    </form> --}}
                </div>
            </div>
            <div class="card-body" style="padding: 20px;">
                <div class="table-responsive">
                    <table class="table table-hover" id="slotsTable">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Slot Time</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($slots as $slot)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark border">#{{ $slot->id }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ date('g:i A', strtotime($slot->start_time)) }} -
                                            {{ date('g:i A', strtotime($slot->end_time)) }}
                                        </small>
                                    </td>
                                    <td>
                                        @php
                                            $start = strtotime($slot->start_time);
                                            $end = strtotime($slot->end_time);
                                            $duration = ($end - $start) / 60;
                                        @endphp
                                        <span
                                            class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill px-3">
                                            {{ $duration }} min
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-{{ $slot->getStatusColor() }}">
                                            {{ $slot->getStatusText() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons justify-content-center">
                                            <button class="btn btn-sm btn-outline-primary toggle-status-btn"
                                                data-slot-id="{{ $slot->id }}"
                                                title="{{ $slot->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i class="fas fa-power-off"></i>
                                            </button>
                                            <a href="{{ route('admin.slots.edit', $slot->id) }}"
                                                class="btn btn-sm btn-outline-success" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.slots.destroy', $slot->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure?')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="py-5">
                                            <div class="empty-state-icon mb-3">
                                                <i class="fas fa-clock fa-3x text-muted opacity-50"></i>
                                            </div>
                                            <h5 class="text-muted mb-2">No Slots Created</h5>
                                            <p class="text-muted mb-4">
                                                Create your first booking slot to get started
                                            </p>
                                            <a href="{{ route('admin.slots.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Create First Slot
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

    <!-- Generate Slots Modal -->
    <div class="modal fade" id="generateSlotsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <i class="fas fa-magic me-2"></i>Generate Multiple Slots
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.slots.generate-slots') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="start_hour" class="form-label">Start Hour</label>
                                <select name="start_hour" id="start_hour" class="form-control" required>
                                    @for ($i = 7; $i <= 22; $i++)
                                        <option value="{{ $i }}" {{ $i == 9 ? 'selected' : '' }}>
                                            {{ sprintf('%02d:00', $i) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="end_hour" class="form-label">End Hour</label>
                                <select name="end_hour" id="end_hour" class="form-control" required>
                                    @for ($i = 8; $i <= 23; $i++)
                                        <option value="{{ $i }}" {{ $i == 18 ? 'selected' : '' }}>
                                            {{ sprintf('%02d:00', $i) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="duration" class="form-label">Duration (minutes)</label>
                                <select name="duration" id="duration" class="form-control" required>
                                    <option value="30">30 minutes</option>
                                    <option value="60" selected>60 minutes</option>
                                    <option value="90">90 minutes</option>
                                    <option value="120">120 minutes</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="max_bookings" class="form-label">Max Bookings per Slot</label>
                                <input type="number" name="max_bookings" id="max_bookings" class="form-control"
                                    value="1" min="1" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Days Available</label>
                                <div class="row">
                                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="days[]"
                                                    value="{{ $day }}" id="day_{{ strtolower($day) }}" checked>
                                                <label class="form-check-label" for="day_{{ strtolower($day) }}">
                                                    {{ $day }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Generate Slots</button>
                    </div>
                </form>
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
            // Toggle slot status
            $('.toggle-status-btn').on('click', function() {
                const slotId = $(this).data('slot-id');
                const button = $(this);

                $.ajax({
                    url: '{{ route('admin.slots.toggle-status', ':id') }}'.replace(':id',
                        slotId),
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Reload page to update status
                            location.reload();
                        }
                    },
                    error: function() {
                        alert('Error updating slot status');
                    }
                });
            });

            // Initialize DataTable
            $('#slotsTable').DataTable({
                "pageLength": 5,
                "order": [
                    [1, 'asc']
                ],
                "language": {
                    "search": "Search slots:",
                    "lengthMenu": "Show _MENU_ slots",
                    "info": "Showing _START_ to _END_ of _TOTAL_ slots",
                    "paginate": {
                        "previous": "‹",
                        "next": "›"
                    }
                }
            });
        });
    </script>
@endsection
