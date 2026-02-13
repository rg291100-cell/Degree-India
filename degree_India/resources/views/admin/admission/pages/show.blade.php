@extends('admin.layouts.master')

@section('title', 'Admission Details')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css"
    rel="stylesheet">
<style>
    :root {
        --primary-color: #4361ee;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --info-color: #17a2b8;
        --light-bg: #f8f9fa;
        --card-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        --border-radius: 0.75rem;
    }

    .page-container {
        background-color: #f5f7fb;
        min-height: calc(100vh - 60px);
        padding: 20px;
    }

    .card-custom {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        border: none;
        margin-bottom: 1.5rem;
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

    .card-header-custom {
        background: white;
        border-bottom: 1px solid #eaeaea;
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header-custom h4 {
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header-custom h4 i {
        color: var(--primary-color);
    }

    .card-body-custom {
        padding: 1.5rem;
    }

    .student-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), #3a56d4);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 2rem;
        margin: 0 auto;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
    }

    .info-card {
        background: var(--light-bg);
        border-radius: 0.5rem;
        padding: 1.25rem;
        height: 100%;
        border-left: 4px solid var(--primary-color);
    }

    .info-card h6 {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card h6 i {
        color: var(--primary-color);
        font-size: 0.875rem;
    }

    .info-item {
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e9ecef;
    }

    .info-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .info-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-weight: 500;
        color: #2c3e50;
        font-size: 0.875rem;
    }

    .status-badge-large {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .badge-pending {
        background: rgba(255, 193, 7, 0.1);
        color: #856404;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }

    .badge-approved {
        background: rgba(40, 167, 69, 0.1);
        color: #155724;
        border: 1px solid rgba(40, 167, 69, 0.3);
    }

    .badge-completed {
        background: rgba(67, 97, 238, 0.1);
        color: #0d47a1;
        border: 1px solid rgba(67, 97, 238, 0.3);
    }

    .badge-rejected {
        background: rgba(220, 53, 69, 0.1);
        color: #721c24;
        border: 1px solid rgba(220, 53, 69, 0.3);
    }

    .payment-progress-container {
        background: var(--light-bg);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }

    .payment-stats {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .stat-box {
        text-align: center;
        flex: 1;
        padding: 0.75rem;
    }

    .stat-box:not(:last-child) {
        border-right: 1px solid #dee2e6;
    }

    .stat-amount {
        font-size: 1.5rem;
        font-weight: 700;
        display: block;
    }

    .stat-amount.paid {
        color: var(--success-color);
    }

    .stat-amount.due {
        color: var(--warning-color);
    }

    .stat-amount.total {
        color: var(--primary-color);
    }

    .stat-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .progress-custom {
        height: 12px;
        border-radius: 6px;
        background: #e9ecef;
        overflow: hidden;
        margin: 1rem 0;
    }

    .progress-bar-paid {
        background: linear-gradient(90deg, var(--success-color), #5cd85c);
    }

    .progress-bar-due {
        background: linear-gradient(90deg, var(--warning-color), #ffdb6d);
    }

    .payment-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .payment-card:hover {
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .payment-mode-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .payment-cash {
        background: rgba(40, 167, 69, 0.1);
        color: #155724;
    }

    .payment-cheque {
        background: rgba(23, 162, 184, 0.1);
        color: #0c5460;
    }

    .payment-online {
        background: rgba(67, 97, 238, 0.1);
        color: #0d47a1;
    }

    .payment-transfer {
        background: rgba(108, 117, 125, 0.1);
        color: #495057;
    }

    .btn-action-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-custom {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary-custom {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary-custom:hover {
        background: #3a56d4;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    .btn-success-custom {
        background: var(--success-color);
        color: white;
    }

    .btn-success-custom:hover {
        background: #218838;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-warning-custom {
        background: var(--warning-color);
        color: #212529;
    }

    .btn-warning-custom:hover {
        background: #e0a800;
        color: #212529;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }

    .form-control-custom {
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
    }

    .form-label-custom {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .section-title {
        font-weight: 600;
        color: #2c3e50;
        margin: 1.5rem 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-bg);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .page-container {
            padding: 10px;
        }

        .card-body-custom {
            padding: 1rem;
        }

        .payment-stats {
            flex-direction: column;
            gap: 1rem;
        }

        .stat-box:not(:last-child) {
            border-right: none;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 1rem;
        }
    }
</style>

@section('content')
    <div class="page-container">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">
                    <i class="fas fa-user-graduate text-primary me-2"></i>
                    Admission Details
                </h3>
                {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="margin-bottom: 0;">
                        <li class="breadcrumb-item text-black"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item text-black"><a href="{{ route('admin.admission.index') }}">Admissions</a>
                        </li>
                        <li class="breadcrumb-item active">#{{ $admission->id }}</li>
                    </ol>
                </nav> --}}
            </div>
            <div>
                {{-- <span class="status-badge-large {{ 'badge-' . $admission->admission_status }}">
                    <i class="fas fa-circle fa-xs"></i>
                    {{ ucfirst($admission->admission_status) }}
                </span> --}}


                <a href="{{ route('admin.admission.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Student & Course Details -->
            <div class="col-lg-8">
                <!-- Student & Course Information Card -->
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h4><i class="fas fa-user-circle me-2"></i>Student & Course Information</h4>
                    </div>
                    <div class="card-body-custom">
                        <div class="row">
                            <!-- Student Avatar & Basic Info -->
                            <div class="col-lg-3 text-center mb-3 mb-lg-0">
                                <div class="student-avatar-large mb-3">
                                    {{ substr($admission->user->name, 0, 1) }}
                                </div>
                                <h5 class="mb-1">{{ $admission->user->name }}</h5>
                                <p class="text-muted mb-2" style="font-size: 0.875rem;">Student</p>

                            </div>

                            <!-- Student Details -->
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="info-card">
                                            <h6><i class="fas fa-user"></i> Student Information</h6>
                                            <div class="info-item">
                                                <div class="info-label">Full Name</div>
                                                <div class="info-value">{{ $admission->user->name }}</div>
                                            </div>
                                            <div class="info-item">
                                                <div class="info-label">Email Address</div>
                                                <div class="info-value">{{ $admission->user->email }}</div>
                                            </div>
                                            <div class="info-item">
                                                <div class="info-label">Phone Number</div>
                                                <div class="info-value">{{ $admission->user->phone ?? 'Not provided' }}
                                                </div>
                                            </div>
                                            <div class="info-item">
                                                <div class="info-label">Registration Date</div>
                                                <div class="info-value">{{ $admission->user->created_at->format('d M Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="info-card">
                                            <h6><i class="fas fa-book-open"></i> Course Information</h6>
                                            <div class="info-item">
                                                <div class="info-label">Course Title</div>
                                                <div class="info-value">{{ $admission->course->title }}</div>
                                            </div>
                                            <div class="info-item">
                                                <div class="info-label">Course Duration</div>
                                                <div class="info-value">
                                                    {{ $admission->course->duration ?? 'N/A' }}
                                                    {{ $admission->course->duration_unit ?? '' }}
                                                </div>
                                            </div>
                                            <div class="info-item">
                                                <div class="info-label">Total Sessions</div>
                                                <div class="info-value">{{ $admission->course->total_sessions }} sessions
                                                </div>
                                            </div>
                                            <div class="info-item">
                                                <div class="info-label">Admission Date</div>
                                                <div class="info-value">
                                                    {{ $admission->created_at->format('d M Y, h:i A') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Progress Card -->
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h4><i class="fas fa-credit-card me-2"></i>Payment Overview</h4>
                    </div>
                    <div class="card-body-custom">
                        <div class="payment-progress-container">
                            <div class="payment-stats">
                                <div class="stat-box">
                                    <span class="stat-amount total">₹{{ number_format($admission->total_fees, 0) }}</span>
                                    <span class="stat-label">Total Fees</span>
                                </div>
                                <div class="stat-box">
                                    <span class="stat-amount paid">₹{{ number_format($admission->paid_amount, 0) }}</span>
                                    <span class="stat-label">Amount Paid</span>
                                </div>
                                <div class="stat-box">
                                    <span class="stat-amount due">₹{{ number_format($admission->due_amount, 0) }}</span>
                                    <span class="stat-label">Pending Amount</span>
                                </div>
                            </div>

                            <div class="progress-custom">
                                @php
                                    $paidPercentage = ($admission->paid_amount / $admission->total_fees) * 100;
                                    $duePercentage = 100 - $paidPercentage;
                                @endphp
                                <div class="progress-bar-paid" style="width: {{ $paidPercentage }}%"></div>
                                <div class="progress-bar-due" style="width: {{ $duePercentage }}%"></div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    {{ round($paidPercentage, 1) }}% Paid
                                </div>
                                <div class="text-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ round($duePercentage, 1) }}% Due
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Right Column - Status & Payment History -->
            <div class="col-lg-4">
                <!-- Update Status Card -->
                <div class="card-custom mb-4">
                    <div class="card-header-custom">
                        <h4><i class="fas fa-sync-alt me-2"></i>Update Admission Status</h4>
                    </div>
                    <div class="card-body-custom">
                        <form method="POST" action="{{ route('admin.admission.update-status', $admission->id) }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label-custom">Current Status</label>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="status-badge-large {{ 'badge-' . $admission->admission_status }}">
                                        <i class="fas fa-circle fa-xs"></i>
                                        {{ ucfirst($admission->admission_status) }}
                                    </span>
                                    <span class="text-muted" style="font-size: 0.875rem;">
                                        Updated: {{ $admission->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-custom">Change Status To</label>
                                <select name="status" class="form-select form-control-custom" required>
                                    <option value="pending"
                                        {{ $admission->admission_status == 'pending' ? 'selected' : '' }}>
                                        <i class="fas fa-clock me-1"></i> Pending
                                    </option>
                                    <option value="approved"
                                        {{ $admission->admission_status == 'approved' ? 'selected' : '' }}>
                                        <i class="fas fa-check-circle me-1"></i> Approved
                                    </option>
                                    <option value="rejected"
                                        {{ $admission->admission_status == 'rejected' ? 'selected' : '' }}>
                                        <i class="fas fa-times-circle me-1"></i> Rejected
                                    </option>
                                    <option value="completed"
                                        {{ $admission->admission_status == 'completed' ? 'selected' : '' }}>
                                        <i class="fas fa-graduation-cap me-1"></i> Completed
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-custom">Remarks (Optional)</label>
                                <textarea name="remarks" class="form-control-custom" rows="3" style="width: 333px;"
                                    placeholder="Add remarks about this status change">{{ $admission->remarks }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary-custom btn-custom w-100"
                                style="background-color: rgb(95, 95, 251);color: white;">
                                <i class="fas fa-save me-1"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                {{-- <div class="card-custom mb-4">
                    <div class="card-header-custom">
                        <h4><i class="fas fa-bolt me-2"></i>Quick Actions</h4>
                    </div>
                    <div class="card-body-custom">
                        <div class="btn-action-group">
                            <a href="{{ route('admin.admission.download-letter', $admission->id) }}"
                                class="btn btn-primary-custom btn-custom">
                                <i class="fas fa-download me-1"></i> Admission Letter
                            </a>

                            <a href="#" class="btn btn-success-custom btn-custom">
                                <i class="fas fa-receipt me-1"></i> Generate Invoice
                            </a>

                            @if ($admission->admission_status == 'approved' && !$admission->is_notified)
                                <a href="{{ route('admin.admission.send-notification', $admission->id) }}"
                                    class="btn btn-warning-custom btn-custom">
                                    <i class="fas fa-envelope me-1"></i> Send Email
                                </a>
                            @endif

                            <a href="{{ route('admin.users.show', $admission->user->id) }}"
                                class="btn btn-info-custom btn-custom"
                                style="background: var(--info-color); color: white;">
                                <i class="fas fa-user me-1"></i> View Student
                            </a>
                        </div>
                    </div>
                </div> --}}

                <!-- Payment History Card -->
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h4>
                            <i class="fas fa-history me-2"></i>
                            Payment History
                            <span class="badge bg-primary rounded-pill ms-2">{{ count($admission->feePayments) }}</span>
                        </h4>
                    </div>
                    <div class="card-body-custom" style="max-height: 400px; overflow-y: auto;">
                        @if (count($admission->feePayments) > 0)
                            @foreach ($admission->feePayments as $payment)
                                <div class="payment-card">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1" style="font-weight: 600; font-size: 1rem;">
                                                ₹{{ number_format($payment->amount, 0) }}
                                            </h6>
                                            <small class="text-muted">
                                                <i class="far fa-calendar me-1"></i>
                                                {{ $payment->payment_date->format('d M Y') }}
                                            </small>
                                        </div>
                                        <span class="payment-mode-badge payment-{{ $payment->payment_mode }}">
                                            {{ ucfirst($payment->payment_mode) }}
                                        </span>
                                    </div>

                                    @if ($payment->receipt_number)
                                        <div class="mb-2">
                                            <small class="text-muted">Receipt #:</small>
                                            <span class="badge bg-light text-dark">{{ $payment->receipt_number }}</span>
                                        </div>
                                    @endif

                                    @if ($payment->remarks)
                                        <p class="mb-2" style="font-size: 0.875rem;">
                                            <i class="fas fa-comment me-1 text-muted"></i>
                                            {{ Str::limit($payment->remarks, 60) }}
                                        </p>
                                    @endif

                                    @if ($payment->proof_document)
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small>
                                                <i class="fas fa-paperclip text-muted me-1"></i>
                                                Proof Document
                                            </small>
                                            <a href="{{ asset('storage/' . $payment->proof_document) }}" target="_blank"
                                                class="btn btn-sm btn-link">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </div>
                                    @endif

                                    @if ($payment->collector)
                                        <div class="mt-2 pt-2 border-top">
                                            <small class="text-muted">
                                                <i class="fas fa-user-tie me-1"></i>
                                                Collected by: {{ $payment->collector->name }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="fas fa-wallet"></i>
                                <p class="mt-2">No payment records found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Record Payment Form Card -->
            <div class="card-custom">
                <div class="card-header-custom">
                    <h4><i class="fas fa-plus-circle me-2"></i>Record New Payment</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.admission.record-payment', $admission->id) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Amount *</label>
                                <input type="number" name="amount" class="form-control" min="1"
                                    max="{{ $admission->due_amount }}" step="0.01" placeholder="Enter amount"
                                    required>
                                @error('amount')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Payment Mode *</label>
                                <select name="payment_mode" class="form-select" required>
                                    <option value="">Select Payment Mode</option>
                                    <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                    <option value="cheque" {{ old('payment_mode') == 'cheque' ? 'selected' : '' }}>Cheque
                                    </option>
                                    <option value="bank_transfer"
                                        {{ old('payment_mode') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                    </option>
                                    <option value="online" {{ old('payment_mode') == 'online' ? 'selected' : '' }}>Online
                                        Payment</option>
                                    <option value="upi" {{ old('payment_mode') == 'upi' ? 'selected' : '' }}>UPI
                                    </option>
                                    <option value="card" {{ old('payment_mode') == 'card' ? 'selected' : '' }}>Card
                                    </option>
                                </select>
                                @error('payment_mode')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Payment Date *</label>
                                <input type="date" name="payment_date" class="form-control"
                                    value="{{ old('payment_date', date('Y-m-d')) }}" required>
                                @error('payment_date')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Receipt Number</label>
                                <input type="text" name="receipt_number" class="form-control" placeholder="Optional"
                                    value="{{ old('receipt_number') }}">
                                @error('receipt_number')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" class="form-control" rows="3" placeholder="Add payment remarks (optional)">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Proof Document</label>
                                <input type="file" name="proof_document" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                <small class="text-muted">Max: 5MB | Formats: JPG, PNG, PDF, DOC</small>
                                @error('proof_document')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror

                                <!-- Preview existing document if any -->
                                @if (isset($admission) && $admission->latestPayment && $admission->latestPayment->proof_document)
                                    <div class="mt-2">
                                        <small>Current document:</small>
                                        <a href="{{ asset('storage/' . $admission->latestPayment->proof_document) }}"
                                            target="_blank" class="d-block text-primary">
                                            <i class="fas fa-paperclip"></i> View existing document
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>



                        <!-- Payment Details Summary -->
                        <div class="alert alert-info mb-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Payment Summary:</strong>
                                    <div class="mt-2">
                                        <span class="me-3">Total Fees:
                                            ₹{{ number_format($admission->total_fees, 2) }}</span>
                                        <span class="me-3">Paid: ₹{{ number_format($admission->paid_amount, 2) }}</span>
                                        <span>Due: ₹{{ number_format($admission->due_amount, 2) }}</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <small>Available for payment: ₹{{ number_format($admission->due_amount, 2) }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-1"></i> Reset Form
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-1"></i> Record Payment
                            </button>
                        </div>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const amountInput = document.querySelector('input[name="amount"]');
                            const dueAmount = {{ $admission->due_amount }};

                            // Set max value to due amount
                            amountInput.setAttribute('max', dueAmount);

                            // Real-time validation
                            amountInput.addEventListener('input', function() {
                                const value = parseFloat(this.value) || 0;

                                if (value > dueAmount) {
                                    this.classList.add('is-invalid');
                                    showError(`Amount cannot exceed due amount (₹${dueAmount.toLocaleString('en-IN')})`);
                                } else {
                                    this.classList.remove('is-invalid');
                                    hideError();
                                }
                            });

                            // Auto-update other fields based on payment mode
                            const paymentModeSelect = document.querySelector('select[name="payment_mode"]');
                            const transactionIdInput = document.querySelector('input[name="transaction_id"]');
                            const chequeNumberInput = document.querySelector('input[name="cheque_number"]');

                            paymentModeSelect.addEventListener('change', function() {
                                const mode = this.value;

                                if (mode === 'online' || mode === 'upi' || mode === 'card') {
                                    transactionIdInput.required = true;
                                    transactionIdInput.placeholder = "Transaction ID required";
                                } else {
                                    transactionIdInput.required = false;
                                    transactionIdInput.placeholder = "For online payments";
                                }

                                if (mode === 'cheque') {
                                    chequeNumberInput.required = true;
                                    chequeNumberInput.placeholder = "Cheque number required";
                                } else {
                                    chequeNumberInput.required = false;
                                    chequeNumberInput.placeholder = "For cheque payments";
                                }
                            });

                            function showError(message) {
                                // Remove existing error message
                                let existingError = amountInput.parentNode.querySelector('.amount-error');
                                if (existingError) existingError.remove();

                                // Create new error message
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'text-danger small amount-error';
                                errorDiv.textContent = message;
                                amountInput.parentNode.appendChild(errorDiv);
                            }

                            function hideError() {
                                const errorDiv = amountInput.parentNode.querySelector('.amount-error');
                                if (errorDiv) errorDiv.remove();
                            }

                            // Form submission validation
                            const form = document.querySelector('form');
                            form.addEventListener('submit', function(e) {
                                const amount = parseFloat(amountInput.value) || 0;

                                if (amount <= 0) {
                                    e.preventDefault();
                                    alert('Please enter a valid payment amount.');
                                    amountInput.focus();
                                    return false;
                                }

                                if (amount > dueAmount) {
                                    e.preventDefault();
                                    alert(
                                        `Payment amount cannot exceed due amount (₹${dueAmount.toLocaleString('en-IN')})`
                                    );
                                    amountInput.focus();
                                    return false;
                                }

                                // Additional validations
                                const paymentMode = paymentModeSelect.value;
                                if (paymentMode === 'cheque' && !chequeNumberInput.value.trim()) {
                                    e.preventDefault();
                                    alert('Please enter cheque number for cheque payment.');
                                    chequeNumberInput.focus();
                                    return false;
                                }

                                if ((paymentMode === 'online' || paymentMode === 'upi' || paymentMode === 'card') &&
                                    !transactionIdInput.value.trim()) {
                                    e.preventDefault();
                                    alert('Please enter transaction ID for online payment.');
                                    transactionIdInput.focus();
                                    return false;
                                }

                                return true;
                            });
                        });
                    </script>

                    <style>
                        /* Custom form styling */
                        .form-control:focus,
                        .form-select:focus {
                            border-color: #28a745;
                            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
                        }

                        /* Custom button styling */
                        .btn-success {
                            background-color: #28a745;
                            border-color: #28a745;
                            padding: 8px 20px;
                            font-weight: 500;
                        }

                        .btn-success:hover {
                            background-color: #218838;
                            border-color: #1e7e34;
                            transform: translateY(-1px);
                            transition: all 0.2s ease;
                        }

                        /* File input styling */
                        .form-control[type="file"] {
                            padding: 6px;
                        }

                        /* Responsive adjustments */
                        @media (max-width: 768px) {
                            .row>div {
                                margin-bottom: 15px;
                            }

                            .d-flex {
                                flex-direction: column;
                                gap: 10px;
                            }

                            .d-flex button {
                                width: 100%;
                            }
                        }
                    </style>
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
            // Toast notification
            function showToast(message, type = 'success') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: type === 'success' ? '#d4edda' : '#f8d7da',
                    color: type === 'success' ? '#155724' : '#721c24',
                    iconColor: type === 'success' ? '#28a745' : '#dc3545',
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

            // Set max payment amount to due amount
            $('input[name="amount"]').attr('max', '{{ $admission->due_amount }}');

            // Add tooltips to action buttons
            $('[title]').tooltip({
                trigger: 'hover',
                placement: 'top'
            });

            // Form validation for payment amount
            $('form').on('submit', function(e) {
                const amountInput = $('input[name="amount"]');
                const dueAmount = parseFloat('{{ $admission->due_amount }}');
                const enteredAmount = parseFloat(amountInput.val());

                if (enteredAmount > dueAmount) {
                    e.preventDefault();
                    showToast(`Payment amount cannot exceed due amount (₹${dueAmount})`, 'error');
                    amountInput.focus();
                }
            });
        });
    </script>
@endsection
