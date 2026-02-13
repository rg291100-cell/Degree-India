@extends('admin.layouts.master')
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

    .section-header hr {
        border-top: 2px solid #e3e6f0;
        margin: 0;
    }

    .account-details-list .detail-item {
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 15px;
    }

    .account-details-list .detail-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .detail-label {
        font-size: 15px !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 14px;
        margin-top: 2px;
    }

    .custom-file-label::after {
        content: "Browse";
    }

    .input-group-text {
        background-color: #f8f9fc;
        border-right: none;
        height: 100%;
    }

    .input-group .form-control {
        border-left: none;
    }

    .input-group .form-control:focus {
        border-color: #bac8f3;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .card {
        border-radius: 0.5rem;
        border: 1px solid #e3e6f0;
    }

    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .select2-container .select2-selection--single {
        height: calc(1.5em + 0.75rem + 2px) !important;
    }
</style>

@section('title', 'Account Details - ' . ($college->name ?? 'College'))

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 d-flex align-items-center">
                    Account Details
                    @if ($college)
                        <span class="text-muted ml-2">- {{ $college->name }}</span>
                    @endif
                </h1>
                <p class="mb-0 mt-1 text-muted">
                    Manage banking information and payment details for college
                </p>
            </div>
            <div>
                <a href="{{ route('admin.colleges.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Colleges
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Main Form Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Edit Account Information
                        </h6>
                        <span class="badge badge-pill badge-light">
                            College ID: {{ $college->id ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.colleges.account-details.store', $college) }}" method="POST"
                            enctype="multipart/form-data" id="accountDetailsForm">
                            @csrf

                            <!-- Bank Account Details -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="section-header mb-3">
                                        <h5 class="text-primary mb-0 d-flex align-items-center">
                                            Bank Account Details
                                        </h5>
                                        <hr class="mt-2">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="account_holder_name" class="font-weight-bold text-dark">
                                            Account Holder Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="account_holder_name" id="account_holder_name"
                                                class="form-control @error('account_holder_name') is-invalid @enderror"
                                                value="{{ old('account_holder_name', $accountDetail->account_holder_name ?? '') }}"
                                                placeholder="Enter account holder name" required>
                                        </div>
                                        @error('account_holder_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="bank_name" class="font-weight-bold text-dark">
                                            Bank Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-landmark"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="bank_name" id="bank_name"
                                                class="form-control @error('bank_name') is-invalid @enderror"
                                                value="{{ old('bank_name', $accountDetail->bank_name ?? '') }}"
                                                placeholder="e.g., SBI, HDFC, ICICI" required>
                                        </div>
                                        @error('bank_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group mt-3">
                                        <label for="account_number" class="font-weight-bold text-dark">
                                            Account Number <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-credit-card"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="account_number" id="account_number"
                                                class="form-control @error('account_number') is-invalid @enderror"
                                                value="{{ old('account_number', $accountDetail->account_number ?? '') }}"
                                                placeholder="Enter account number" required>
                                        </div>
                                        @error('account_number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mt-3">
                                        <label for="account_type" class="font-weight-bold text-dark">
                                            Account Type <span class="text-danger">*</span>
                                        </label>
                                        <select name="account_type" id="account_type" class="form-control select2" required>
                                            <option value="">Select Type</option>
                                            <option value="savings"
                                                {{ old('account_type', $accountDetail->account_type ?? '') == 'savings' ? 'selected' : '' }}>
                                                Savings Account
                                            </option>
                                            <option value="current"
                                                {{ old('account_type', $accountDetail->account_type ?? '') == 'current' ? 'selected' : '' }}>
                                                Current Account
                                            </option>
                                        </select>
                                        @error('account_type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="ifsc_code" class="font-weight-bold text-dark">
                                            IFSC Code <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-hashtag"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="ifsc_code" id="ifsc_code"
                                                class="form-control @error('ifsc_code') is-invalid @enderror"
                                                value="{{ old('ifsc_code', $accountDetail->ifsc_code ?? '') }}"
                                                placeholder="e.g., SBIN0001234" required>
                                        </div>
                                        @error('ifsc_code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="micr_code" class="font-weight-bold text-dark">
                                            MICR Code
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-barcode"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="micr_code" id="micr_code"
                                                class="form-control @error('micr_code') is-invalid @enderror"
                                                value="{{ old('micr_code', $accountDetail->micr_code ?? '') }}"
                                                placeholder="Optional">
                                        </div>
                                        @error('micr_code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mt-3">
                                        <label for="branch_name" class="font-weight-bold text-dark">
                                            Branch Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="branch_name" id="branch_name"
                                                class="form-control @error('branch_name') is-invalid @enderror"
                                                value="{{ old('branch_name', $accountDetail->branch_name ?? '') }}"
                                                placeholder="Enter branch name with city" required>
                                        </div>
                                        @error('branch_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Digital Payment Details -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="section-header mb-3">
                                        <h5 class="text-success mb-0 d-flex align-items-center">
                                            Digital Payment Details
                                        </h5>
                                        <hr class="mt-2">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="upi_id" class="font-weight-bold text-dark">
                                            UPI ID
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-qrcode"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="upi_id" id="upi_id"
                                                class="form-control @error('upi_id') is-invalid @enderror"
                                                value="{{ old('upi_id', $accountDetail->upi_id ?? '') }}"
                                                placeholder="username@upi">
                                        </div>
                                        <small class="text-muted">e.g., collegename@sbi, collegename@okhdfcbank</small>
                                        @error('upi_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="registered_mobile" class="font-weight-bold text-dark">
                                            Registered Mobile
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="registered_mobile" id="registered_mobile"
                                                class="form-control @error('registered_mobile') is-invalid @enderror"
                                                value="{{ old('registered_mobile', $accountDetail->registered_mobile ?? '') }}"
                                                placeholder="+91XXXXXXXXXX">
                                        </div>
                                        @error('registered_mobile')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mt-3">
                                        <label for="qr_code" class="font-weight-bold text-dark">
                                            UPI QR Code
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" name="qr_code" id="qr_code"
                                                class="form-control custom-file-input @error('qr_code') is-invalid @enderror"
                                                accept="image/*">

                                        </div>
                                        <small class="text-muted">Upload PNG, JPG, or JPEG image of UPI QR code</small>
                                        @error('qr_code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <!-- QR Code Preview & Actions -->
                                        <div class="mt-3" id="qrCodeSection">
                                            <div id="qrPreview" class="text-center mb-2">
                                                @if ($accountDetail && $accountDetail->qr_code_path)
                                                    <div class="card border" style="max-width: 200px;">
                                                        <div class="card-body p-2">
                                                            <img src="{{ Storage::url($accountDetail->qr_code_path) }}"
                                                                alt="QR Code" class="img-fluid rounded"
                                                                style="max-height: 180px;">
                                                        </div>
                                                        <div class="card-footer p-2 bg-light">
                                                            <div class="d-flex justify-content-between">
                                                                <a href="{{ Storage::url($accountDetail->qr_code_path) }}"
                                                                    target="_blank"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                                <a href="{{ route('admin.colleges.download-qr', $college) }}"
                                                                    class="btn btn-sm btn-outline-success">
                                                                    <i class="fas fa-download"></i> Download
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="{{ route('admin.colleges.index') }}"
                                                class="btn btn-outline-secondary">
                                                <i class="fas fa-times mr-1"></i> Cancel
                                            </a>
                                        </div>
                                        <div>
                                            <button type="reset" class="btn btn-outline-warning mr-2">
                                                <i class="fas fa-redo mr-1"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save mr-1"></i> Save Account Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Current Details & Info -->
            <div class="col-lg-8">
                <!-- Current Account Details Card -->
                @if ($accountDetail && $accountDetail->account_holder_name)
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-info">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="fas fa-info-circle mr-1"></i> Current Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6 border-right">
                                    <div class="account-details-list">
                                        <div class="detail-item mb-4">
                                            <div class="detail-label text-black small">Account Holder</div>
                                            <div class="detail-value font-weight-bold text-dark">
                                                <i class="fas fa-user-circle mr-2 text-primary"></i>
                                                {{ $accountDetail->account_holder_name }}
                                            </div>
                                        </div>

                                        <div class="detail-item mb-4">
                                            <div class="detail-label text-black small">Bank & Account</div>
                                            <div class="detail-value">
                                                <div class="font-weight-bold text-dark">
                                                    <i class="fas fa-landmark mr-2 text-primary"></i>
                                                    {{ $accountDetail->bank_name }}
                                                </div>
                                                <div class="text-muted small mt-2">
                                                    <i class="fas fa-credit-card mr-2"></i>
                                                    Account: ****{{ substr($accountDetail->account_number, -4) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="detail-item mb-4">
                                            <div class="detail-label text-black small">Branch & IFSC</div>
                                            <div class="detail-value">
                                                <div class="text-dark">
                                                    <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                                                    {{ $accountDetail->branch_name }}
                                                </div>
                                                <div class="text-muted small mt-2">
                                                    <i class="fas fa-hashtag mr-2"></i>
                                                    IFSC: {{ $accountDetail->ifsc_code }}
                                                </div>
                                            </div>
                                        </div>

                                        @if ($accountDetail->micr_code)
                                            <div class="detail-item mb-4">
                                                <div class="detail-label text-black small">MICR Code</div>
                                                <div class="detail-value text-dark">
                                                    <i class="fas fa-barcode mr-2 text-primary"></i>
                                                    {{ $accountDetail->micr_code }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="account-details-list">
                                        <div class="detail-item mb-4">
                                            <div class="detail-label text-black small">Account Type</div>
                                            <div class="detail-value">
                                                <span
                                                    class="badge bg-{{ $accountDetail->account_type == 'savings' ? 'success' : 'info' }} p-2"
                                                    style="font-size: 14px;">
                                                    <i class="fas fa-wallet mr-2"></i>
                                                    {{ ucfirst($accountDetail->account_type) }} Account
                                                </span>
                                            </div>
                                        </div>

                                        @if ($accountDetail->upi_id)
                                            <div class="detail-item mb-4">
                                                <div class="detail-label text-black small">UPI ID</div>
                                                <div class="detail-value">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-qrcode mr-2 text-success fa-lg"></i>

                                                        <span class="font-weight-bold text-dark">
                                                            {{ $accountDetail->upi_id }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($accountDetail->registered_mobile)
                                            <div class="detail-item mb-4">
                                                <div class="detail-label text-black small">Registered Mobile</div>
                                                <div class="detail-value text-dark">
                                                    <i class="fas fa-phone mr-2 text-primary"></i>
                                                    {{ $accountDetail->registered_mobile }}
                                                </div>
                                            </div>
                                        @endif

                                        <div class="detail-item mb-4">
                                            <div class="detail-label text-black small">QR Code</div>
                                            <div class="detail-value">
                                                @if ($accountDetail && $accountDetail->qr_code_path)
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-3">
                                                            <img src="{{ Storage::url($accountDetail->qr_code_path) }}"
                                                                alt="QR Code" class="img-thumbnail"
                                                                style="width: 80px; height: 80px; object-fit: cover;">
                                                        </div>
                                                        <div>
                                                            <div class="mb-2">
                                                                <a href="{{ Storage::url($accountDetail->qr_code_path) }}"
                                                                    target="_blank"
                                                                    class="btn btn-sm btn-outline-primary btn-block">
                                                                    <i class="fas fa-eye mr-1"></i> View
                                                                </a>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('admin.colleges.download-qr', $college) }}"
                                                                    class="btn btn-sm btn-outline-success btn-block">
                                                                    <i class="fas fa-download mr-1"></i> Download
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted font-italic">No QR code uploaded</span>
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- No Account Details Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-light">
                            <h6 class="m-0 font-weight-bold text-dark">
                                <i class="fas fa-info-circle mr-1"></i> Current Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-5">
                                <i class="fas fa-university fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Account Details Found</h5>
                                <p class="text-muted mb-0">Add account details using the form above</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let baseUrl = "{{ config('app.url') }}";
        // QR Code Preview
        document.getElementById('qr_code').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('qrPreview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = `
                    <div class="card border" style="max-width: 200px;">
                        <div class="card-body p-2">
                            <img src="${e.target.result}" alt="QR Preview" class="img-fluid rounded" style="max-height: 180px;">
                        </div>
                        <div class="card-footer p-2 bg-light">
                            <div class="text-center text-muted small">
                                Preview of new QR code
                            </div>
                        </div>
                    </div>
                `;
                }

                reader.readAsDataURL(file);
            } else {
                // Restore original if exists
                @if ($accountDetail && $accountDetail->qr_code_path)
                    preview.innerHTML = `
                    <div class="card border" style="max-width: 200px;">
                        <div class="card-body p-2">
                            <img src="{{ Storage::url($accountDetail->qr_code_path) }}" 
                                 alt="QR Code" class="img-fluid rounded" style="max-height: 180px;">
                        </div>
                        <div class="card-footer p-2 bg-light">
                            <div class="d-flex justify-content-between">
                                <a href="{{ Storage::url($accountDetail->qr_code_path) }}"
                                    target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('admin.colleges.download-qr', $college) }}"
                                    class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                @else
                    preview.innerHTML = '';
                @endif
            }
        });

        // File input label update
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            let fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file';
            let label = e.target.nextElementSibling;
            label.innerHTML = `<i class="fas fa-upload mr-1"></i> ${fileName}`;
        });

        // Initialize Select2 if available
        $(document).ready(function() {
            if ($.fn.select2) {
                $('#account_type').select2({
                    minimumResultsForSearch: -1,
                    placeholder: "Select account type",
                    width: '100%'
                });
            }

            // Form validation
            $('#accountDetailsForm').on('submit', function() {
                $('.btn-primary').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
            });

            @if (session('success'))
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: "{{ session('success') }}",
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    toast: true,
                    icon: 'error',
                    title: "{{ session('error') }}",
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif
        });
    </script>
@endpush
