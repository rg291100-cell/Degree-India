@extends('admin.layouts.master')

@section('title', 'Edit Registration Contact')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<style>
    .form-label {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .invalid-feedback {
        display: block;
    }

    .card-header {
        border-bottom: 2px solid rgba(0, 0, 0, .125);
    }
</style>

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Header -->
        <div class="page-header mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="page-title mb-1">
                        <i class="fas fa-edit me-2"></i>
                        Edit Registration Contact
                    </h3>
                    <p class="page-subtitle mb-0">
                        Update contact information for registration flow
                    </p>
                </div>

            </div>
        </div>

        <!-- Main Card -->
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0">Contact Information</h6>
            </div>
            <div class="card-body" style="padding:20px !important;">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Please fix the following errors:
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.register-contect.update', $content->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror"
                                id="location" name="location" value="{{ old('location', $content->location) }}"
                                placeholder="Enter location (e.g., Head Office, Branch Office)">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $content->name) }}"
                                placeholder="Enter contact person name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone_no" class="form-label">Phone No<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone_no') is-invalid @enderror"
                                id="phone_no" name="phone_no" value="{{ old('phone_no', $content->phone_no) }}"
                                placeholder="Enter phone number">
                            @error('phone_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $content->email) }}"
                                placeholder="Enter email address">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="otp" class="form-label">OTP </label>
                            <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp"
                                name="otp" value="{{ old('otp', $content->otp) }}"
                                placeholder="Enter OTP (if applicable)">
                            @error('otp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave empty if not required</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Last Updated</label>
                            <div class="form-control bg-light">
                                {{ $content->updated_at->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-4 mt-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.register-contect.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Contact
                            </button>
                        </div>
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

@endsection
