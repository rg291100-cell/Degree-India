@extends('admin.layouts.master')

@section('title', 'Conversation Summary - Booking #' . $booking->id)

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    .conversation-container {
        background: #f8f9fa;
        min-height: 100vh;
    }

    .conversation-header {
        background: linear-gradient(135deg, #a3a3a3 0%, #eeedef 100%);
        color: white;
        padding: 30px 0;
        margin-bottom: 30px;
    }

    .booking-info-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        border-left: 5px solid #667eea;
    }

    .summary-form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .status-badge {
        font-size: 0.85em;
        padding: 6px 15px;
        border-radius: 20px;
    }

    .key-point-item {
        background: #f8f9fa;
        border-left: 4px solid #667eea;
        padding: 12px 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .key-point-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .timeline {
        position: relative;
        padding-left: 30px;
        margin-left: 15px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
        padding-left: 20px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #667eea;
        border: 3px solid white;
        box-shadow: 0 0 0 3px #667eea;
    }

    .ql-toolbar {
        border-radius: 10px 10px 0 0;
        background: #f8f9fa;
    }

    .ql-container {
        border-radius: 0 0 10px 10px;
        min-height: 200px;
        font-family: inherit;
    }

    .attachment-preview {
        background: #f8f9fa;
        border: 1px dashed #dee2e6;
        border-radius: 10px;
        padding: 15px;
        margin-top: 10px;
    }

    .btn-action {
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .summary-preview {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        border-left: 5px solid #28a745;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 20px;
    }
</style>

@section('content')
    <div class="conversation-container mt-4">
        <!-- Header -->
        <div class="conversation-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h3 mb-2">
                            <i class="fas fa-comments me-2"></i> Conversation Summary
                        </h1>
                        <p class="mb-0 opacity-75">Record and manage counseling session details</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('admin.booking-slot.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-2"></i> Back to Bookings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Booking Information -->
            <div class="booking-info-card">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="mb-3">Session Details</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small class="text-muted d-block">Student</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div
                                            class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $booking->student->name ?? 'N/A' }}</h6>
                                            <small class="text-muted">{{ $booking->student->email ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small class="text-muted d-block">Assigned Counselor</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div
                                            class="avatar-sm bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-user-tie text-success"></i>
                                        </div>
                                        <div>
                                            @if ($booking->counselor)
                                                <h6 class="mb-0">{{ $booking->counselor->name }}</h6>
                                                <small class="text-muted">{{ $booking->counselor->email }}</small>
                                            @else
                                                <span class="text-danger">Not Assigned</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <small class="text-muted d-block">Session Date & Time</small>
                                <h6 class="mb-0">{{ $booking->month }} {{ $booking->year }} | {{ $booking->slot }}</h6>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Language</small>
                                <h6 class="mb-0">{{ $booking->language }}</h6>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Booking ID</small>
                                <h6 class="mb-0">#{{ $booking->id }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-end">
                            @if ($exists)
                                <span class="badge bg-success status-badge">
                                    <i class="fas fa-check-circle me-1"></i> Summary Saved
                                </span>
                                <div class="mt-3">
                                    <small class="text-muted d-block">Last Updated</small>
                                    <h6 class="mb-0">{{ $conversationSummary->updated_at->format('M d, Y h:i A') }}</h6>
                                </div>
                            @else
                                <span class="badge bg-warning status-badge">
                                    <i class="fas fa-exclamation-circle me-1"></i> No Summary
                                </span>
                                <div class="mt-3">
                                    <small class="text-muted">No conversation summary recorded yet</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Form/Preview -->
            <div class="summary-form-card">
                @if (!$exists || request()->has('edit'))
                    <!-- Conversation Form -->
                    <form method="POST" action="{{ route('admin.bookings.conversation.store', $booking->id) }}"
                        id="conversationForm">
                        @csrf

                        <h4 class="mb-4">
                            <i class="fas fa-edit me-2"></i>
                            {{ $exists ? 'Edit Conversation Summary' : 'Record Conversation Summary' }}
                        </h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meeting_date" class="form-label">Meeting Date *</label>
                                    <input type="date" class="form-control" id="meeting_date" name="meeting_date"
                                        value="{{ $conversationSummary->meeting_date ?? date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meeting_time" class="form-label">Meeting Time *</label>
                                    <input type="time" class="form-control" id="meeting_time" name="meeting_time"
                                        value="{{ $conversationSummary->meeting_time ?? $booking->slot }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Duration</label>
                                    <input type="text" class="form-control" id="duration" name="duration"
                                        placeholder="e.g., 45 minutes" value="{{ $conversationSummary->duration ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select" id="status12" name="status" required
                                        style="display: block !important;">
                                        @foreach (['scheduled' => 'Scheduled', 'completed' => 'Completed', 'cancelled' => 'Cancelled', 'rescheduled' => 'Rescheduled'] as $value => $label)
                                            <option value="{{ $value }}" style="display: block !important;"
                                                {{ ($conversationSummary->status ?? 'scheduled') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="follow_up_date" class="form-label">Follow-up Date</label>
                                    <input type="date" class="form-control" id="follow_up_date" name="follow_up_date"
                                        value="{{ $conversationSummary->follow_up_date ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="summary" class="form-label">Conversation Summary *</label>
                            <textarea class="form-control" id="summary" name="summary" rows="6"
                                placeholder="Describe the key discussion points, student concerns, recommendations, etc." required>{{ $conversationSummary->summary ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Key Discussion Points</label>
                            <div id="keyPointsContainer">
                                @if ($exists && !empty($conversationSummary->key_points))
                                    @foreach ($conversationSummary->key_points as $index => $point)
                                        @if (!empty($point))
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="key_points[]"
                                                    value="{{ $point }}" placeholder="Enter key point">
                                                <button type="button" class="btn btn-outline-danger remove-key-point">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="key_points[]"
                                            placeholder="Enter key point">
                                        <button type="button" class="btn btn-outline-danger remove-key-point">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addKeyPoint">
                                <i class="fas fa-plus me-1"></i> Add Point
                            </button>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4"
                                placeholder="Any additional observations, recommendations, or follow-up actions">{{ $conversationSummary->notes ?? '' }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="follow_up_notes" class="form-label">Follow-up Notes</label>
                            <textarea class="form-control" id="follow_up_notes" name="follow_up_notes" rows="3"
                                placeholder="Notes for follow-up session or next steps">{{ $conversationSummary->follow_up_notes ?? '' }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                @if ($exists)
                                    <a href="{{ route('admin.bookings.conversation', $booking->id) }}"
                                        class="btn btn-outline-secondary btn-action">
                                        <i class="fas fa-times me-2"></i> Cancel
                                    </a>
                                @endif
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary btn-action">
                                    <i class="fas fa-save me-2"></i>
                                    {{ $exists ? 'Update Summary' : 'Save Summary' }}
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <!-- Summary Preview -->
                    <div class="summary-preview">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">
                                <i class="fas fa-file-alt me-2"></i> Conversation Summary
                            </h4>
                            <div>
                                <a href="{{ route('admin.bookings.conversation', ['id' => $booking->id, 'edit' => true]) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <small class="text-muted d-block">Meeting Date</small>
                                <strong>{{ $conversationSummary->meeting_date ?? 'Not set' }}</strong>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted d-block">Meeting Time</small>
                                <strong>{{ $conversationSummary->meeting_time ?? 'Not set' }}</strong>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted d-block">Duration</small>
                                <strong>{{ $conversationSummary->duration ?? 'Not specified' }}</strong>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted d-block">Status</small>
                                <span
                                    class="badge bg-{{ $conversationSummary->status == 'completed' ? 'success' : ($conversationSummary->status == 'scheduled' ? 'info' : 'warning') }}">
                                    {{ ucfirst($conversationSummary->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Conversation Summary</h6>
                            <div class="bg-white p-3 rounded border">
                                {!! nl2br(e($conversationSummary->summary)) !!}
                            </div>
                        </div>

                        @if (!empty($conversationSummary->key_points))
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">Key Discussion Points</h6>
                                <div class="timeline">
                                    @foreach ($conversationSummary->key_points as $point)
                                        @if (!empty($point))
                                            <div class="timeline-item">
                                                <strong>{{ $point }}</strong>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($conversationSummary->notes)
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Additional Notes</h6>
                                <div class="bg-light p-3 rounded">
                                    {!! nl2br(e($conversationSummary->notes)) !!}
                                </div>
                            </div>
                        @endif

                        @if ($conversationSummary->follow_up_date || $conversationSummary->follow_up_notes)
                            <div class="mt-4 p-3 bg-info bg-opacity-10 rounded border border-info">
                                <h6 class="text-info mb-3">
                                    <i class="fas fa-calendar-check me-2"></i> Follow-up Information
                                </h6>
                                @if ($conversationSummary->follow_up_date)
                                    <div class="mb-2">
                                        <strong>Follow-up Date:</strong> {{ $conversationSummary->follow_up_date }}
                                    </div>
                                @endif
                                @if ($conversationSummary->follow_up_notes)
                                    <div>
                                        <strong>Follow-up Notes:</strong><br>
                                        {!! nl2br(e($conversationSummary->follow_up_notes)) !!}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="mt-4 pt-3 border-top text-end">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Created: {{ $conversationSummary->created_at->format('M d, Y h:i A') }} |
                                Updated: {{ $conversationSummary->updated_at->format('M d, Y h:i A') }}
                            </small>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Session History (if any) -->
            {{-- @if ($exists)
                <div class="summary-form-card">
                    <h4 class="mb-4">
                        <i class="fas fa-history me-2"></i> Session History
                    </h4>

                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted d-block">Recorded By</small>
                                <strong>{{ $conversationSummary->counselor->name ?? 'Unknown' }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Student Response</small>
                                <span class="badge bg-success">Cooperative</span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Satisfaction Level</small>
                                <div class="rating">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                    <span class="ms-2">4/5</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download me-1"></i> Download as PDF
                        </button>
                        <button class="btn btn-outline-secondary btn-sm ms-2">
                            <i class="fas fa-print me-1"></i> Print Summary
                        </button>
                        <button class="btn btn-outline-success btn-sm ms-2" id="sendEmailBtn">
                            <i class="fas fa-envelope me-1"></i> Email to Student
                        </button>
                    </div>
                </div>
            @endif --}}
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
            // Add key point
            $('#addKeyPoint').click(function() {
                const newInput = `
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="key_points[]" placeholder="Enter key point">
                <button type="button" class="btn btn-outline-danger remove-key-point">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
                $('#keyPointsContainer').append(newInput);
            });

            // Remove key point
            $(document).on('click', '.remove-key-point', function() {
                $(this).closest('.input-group').remove();
            });

            // Form validation
            $('#conversationForm').submit(function(e) {
                const summary = $('#summary').val().trim();
                if (summary.length < 10) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Summary Too Short',
                        text: 'Please provide a detailed conversation summary (at least 10 characters).'
                    });
                    return false;
                }

                // Show loading
                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span> Saving...')
                    .prop('disabled', true);
            });

            // Status change effects
            $('#status').change(function() {
                const status = $(this).val();
                if (status === 'completed') {
                    $('#follow_up_date').prop('required', false);
                } else if (status === 'scheduled') {
                    $('#follow_up_date').prop('required', true);
                }
            });

            // Set min date for follow-up
            const today = new Date().toISOString().split('T')[0];
            $('#follow_up_date').attr('min', today);
            $('#meeting_date').attr('max', today);

            // Send email functionality
            $('#sendEmailBtn').click(function() {
                Swal.fire({
                    title: 'Send Summary to Student',
                    text: 'This will email the conversation summary to the student.',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Send Email',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Here you would typically make an AJAX call
                        Swal.fire(
                            'Email Sent!',
                            'The conversation summary has been sent to the student.',
                            'success'
                        );
                    }
                });
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
