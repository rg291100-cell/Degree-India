@extends('admin.layouts.master')

@section('title', 'Edit Booking Slot')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold">
                                <i class="fas fa-edit me-2"></i>Edit Booking Slot
                            </h5>
                            <a href="{{ route('admin.slots.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Slots
                            </a>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 20px">
                        <form action="{{ route('admin.slots.update', $slot->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="slot_time" class="form-label">Slot Time Display *</label>
                                    <input type="text" name="slot_time" id="slot_time" class="form-control" required
                                        value="{{ old('slot_time', $slot->slot_time) }}"
                                        placeholder="e.g., 9:00 AM - 10:00 AM">
                                    @error('slot_time')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">This is what users will see</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="max_bookings" class="form-label">Maximum Bookings *</label>
                                    <input type="number" name="max_bookings" id="max_bookings" class="form-control"
                                        value="{{ old('max_bookings', $slot->max_bookings) }}"
                                        min="{{ $slot->current_bookings }}" required>
                                    @error('max_bookings')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Current bookings: {{ $slot->current_bookings }} (minimum value)
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <label for="start_time">Start Time</label>
                                    <input type="text" class="form-control" id="start_time" name="start_time"
                                        value="{{ old('start_time', $slot ? date('h:i A', strtotime($slot->start_time)) : '') }}"
                                        placeholder="e.g., 10:00 AM">
                                    <small class="form-text text-muted">Format: HH:MM AM/PM (e.g., 09:00 AM, 02:30
                                        PM)</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="end_time">End Time</label>
                                    <input type="text" class="form-control" id="end_time" name="end_time"
                                        value="{{ old('end_time', $slot ? date('h:i A', strtotime($slot->end_time)) : '') }}"
                                        placeholder="e.g., 11:00 AM">
                                    <small class="form-text text-muted">Format: HH:MM AM/PM (e.g., 09:00 AM, 02:30
                                        PM)</small>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Days Available</label>
                                    <div class="row">
                                        @foreach ($days as $day)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="days_available[]"
                                                        value="{{ $day }}" id="day_{{ strtolower($day) }}"
                                                        {{ is_array(old('days_available', $slot->days_available)) && in_array($day, old('days_available', $slot->days_available ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="day_{{ strtolower($day) }}">
                                                        {{ $day }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('days_available')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Leave unchecked for all days</div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                            value="1" {{ old('is_active', $slot->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active (available for booking)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info Card -->
                            <div class="card mt-4 border-info">
                                <div class="card-header bg-info bg-opacity-10 border-info">
                                    <h6 class="mb-0 text-info">
                                        <i class="fas fa-info-circle me-2"></i>Slot Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row small">
                                        <div class="col-md-4">
                                            <strong>Created:</strong><br>
                                            {{ $slot->created_at->format('M d, Y h:i A') }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Last Updated:</strong><br>
                                            {{ $slot->updated_at->format('M d, Y h:i A') }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Status:</strong><br>
                                            <span class="badge bg-{{ $slot->is_active ? 'success' : 'danger' }}">
                                                {{ $slot->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Slot
                                </button>
                                <a href="{{ route('admin.slots.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                                <button type="button" class="btn btn-danger float-end" onclick="confirmDelete()">
                                    <i class="fas fa-trash me-2"></i>Delete Slot
                                </button>
                            </div>
                        </form>

                        <!-- Delete Form -->
                        <form id="deleteForm" action="{{ route('admin.slots.destroy', $slot->id) }}" method="POST"
                            class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-generate slot time display based on start and end times
        document.getElementById('start_time').addEventListener('change', updateSlotTime);
        document.getElementById('end_time').addEventListener('change', updateSlotTime);

        function updateSlotTime() {
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;

            if (startTime && endTime) {
                const startFormatted = formatTime(startTime);
                const endFormatted = formatTime(endTime);
                document.getElementById('slot_time').value = `${startFormatted} - ${endFormatted}`;
            }
        }

        function formatTime(timeStr) {
            const [hours, minutes] = timeStr.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            return `${hour12}:${minutes} ${ampm}`;
        }

        // Populate form on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Format times for display
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;

            if (startTime) {
                const startFormatted = formatTime(startTime);
                const endFormatted = formatTime(endTime);
                document.getElementById('slot_time').value = `${startFormatted} - ${endFormatted}`;
            }
        });

        // Delete confirmation
        function confirmDelete() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;

            if (startTime && endTime) {
                const start = new Date('2000-01-01T' + startTime);
                const end = new Date('2000-01-01T' + endTime);

                if (end <= start) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Time',
                        text: 'End time must be after start time!'
                    });
                }
            }
        });
    </script>

    <!-- Include SweetAlert for delete confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add some custom CSS -->
    <style>
        .form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
        }

        .form-switch .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
