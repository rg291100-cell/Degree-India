@extends('admin.layouts.master')

@section('title', 'Create Booking Slot')
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
                                <i class="fas fa-plus-circle me-2"></i>Create New Booking Slot
                            </h5>
                            <a href="{{ route('admin.slots.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Slots
                            </a>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 20px">
                        <form action="{{ route('admin.slots.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="slot_time" class="form-label">Slot Time Display *</label>
                                    <input type="text" name="slot_time" id="slot_time" class="form-control" required
                                        placeholder="e.g., 9:00 AM - 10:00 AM">
                                    <div class="form-text">This is what users will see</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="max_bookings" class="form-label">Maximum Bookings *</label>
                                    <input type="number" name="max_bookings" id="max_bookings" class="form-control"
                                        value="1" min="1" required>
                                    <div class="form-text">Maximum students per slot</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="start_time" class="form-label">Start Time *</label>
                                    <input type="time" name="start_time" id="start_time" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="end_time" class="form-label">End Time *</label>
                                    <input type="time" name="end_time" id="end_time" class="form-control" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Days Available</label>
                                    <div class="row">
                                        @foreach ($days as $day)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="days_available[]"
                                                        value="{{ $day }}" id="day_{{ strtolower($day) }}">
                                                    <label class="form-check-label" for="day_{{ strtolower($day) }}">
                                                        {{ $day }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-text">Leave unchecked for all days</div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                            checked>
                                        <label class="form-check-label" for="is_active">
                                            Active (available for booking)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Create Slot
                                </button>
                                <a href="{{ route('admin.slots.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
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
    </script>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
