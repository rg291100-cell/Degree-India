@extends('admin.layouts.master')

@section('title', isset($editEntry) ? 'Edit Contact Information' : 'Add Contact Information')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<style>
    .form-label {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .card-header {
        border-bottom: 2px solid rgba(0, 0, 0, .125);
    }

    .table-active {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    .btn-outline-warning.active {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }

    .preview-image {
        max-width: 100px;
        max-height: 100px;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 2px;
        margin-top: 5px;
    }

    .image-preview-container {
        margin-top: 10px;
    }
</style>

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="page-title mb-1">
                        <i class="fas {{ isset($editEntry) ? 'fa-edit' : 'fa-plus' }} me-2"></i>
                        {{ isset($editEntry) ? 'Edit Contact Information' : 'Add Contact Information' }}
                    </h3>
                    <p class="page-subtitle mb-0">
                        {{ isset($editEntry) ? 'Update registration contact details with images' : 'Create new contact information with image uploads' }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form Section -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-light">

                    </div>
                    <div class="card-body" style="padding: 20px !important;">
                        <form method="POST"
                            action="{{ !is_null($editEntry) ? route('admin.register-contect.update', $editEntry->id) : route('admin.register-contect.store') }}"
                            enctype="multipart/form-data">


                            @csrf
                            @if (isset($editEntry))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Location Image -->
                                <div class="col-md-12 mb-3">
                                    <label for="location_image" class="form-label">Location Image *</label>
                                    <input type="file" id="location_image" name="location_image"
                                        class="form-control @error('location_image') is-invalid @enderror" accept="image/*"
                                        {{ !isset($editEntry) ? 'required' : '' }}>
                                    @error('location_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Image Preview -->
                                    @if (isset($editEntry) && $editEntry->location_image)
                                        <div class="image-preview-container">
                                            <p class="mb-1">Current Image:</p>
                                            <img src="{{ asset('storage/' . $editEntry->location_image) }}"
                                                alt="Location Image" class="preview-image">
                                        </div>
                                    @endif
                                    <div id="locationImagePreview" class="image-preview-container"></div>
                                    <small class="text-muted">Upload location image (JPG, PNG, GIF, SVG)</small>
                                </div>

                                <!-- Name Image -->
                                <div class="col-md-12 mb-3">
                                    <label for="name_image" class="form-label">Name Image *</label>
                                    <input type="file" id="name_image" name="name_image"
                                        class="form-control @error('name_image') is-invalid @enderror" accept="image/*"
                                        {{ !isset($editEntry) ? 'required' : '' }}>
                                    @error('name_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Image Preview -->
                                    @if (isset($editEntry) && $editEntry->name_image)
                                        <div class="image-preview-container">
                                            <p class="mb-1">Current Image:</p>
                                            <img src="{{ asset('storage/' . $editEntry->name_image) }}" alt="Name Image"
                                                class="preview-image">
                                        </div>
                                    @endif
                                    <div id="nameImagePreview" class="image-preview-container"></div>
                                    <small class="text-muted">Upload name image (JPG, PNG, GIF, SVG)</small>
                                </div>

                                <!-- Phone Image -->
                                <div class="col-md-6 mb-3">
                                    <label for="phone_image" class="form-label">Phone Number Image *</label>
                                    <input type="file" id="phone_image" name="phone_image"
                                        class="form-control @error('phone_image') is-invalid @enderror" accept="image/*"
                                        {{ !isset($editEntry) ? 'required' : '' }}>
                                    @error('phone_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Image Preview -->
                                    @if (isset($editEntry) && $editEntry->phone_image)
                                        <div class="image-preview-container">
                                            <p class="mb-1">Current Image:</p>
                                            <img src="{{ asset('storage/' . $editEntry->phone_image) }}" alt="Phone Image"
                                                class="preview-image">
                                        </div>
                                    @endif
                                    <div id="phoneImagePreview" class="image-preview-container"></div>
                                </div>

                                <!-- Email Image -->
                                <div class="col-md-6 mb-3">
                                    <label for="email_image" class="form-label">Email Address Image *</label>
                                    <input type="file" id="email_image" name="email_image"
                                        class="form-control @error('email_image') is-invalid @enderror" accept="image/*"
                                        {{ !isset($editEntry) ? 'required' : '' }}>
                                    @error('email_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Image Preview -->
                                    @if (isset($editEntry) && $editEntry->email_image)
                                        <div class="image-preview-container">
                                            <p class="mb-1">Current Image:</p>
                                            <img src="{{ asset('storage/' . $editEntry->email_image) }}" alt="Email Image"
                                                class="preview-image">
                                        </div>
                                    @endif
                                    <div id="emailImagePreview" class="image-preview-container"></div>
                                </div>

                                <!-- OTP Image -->
                                <div class="col-md-12 mb-3">
                                    <label for="otp_image" class="form-label">OTP Image (Optional)</label>
                                    <input type="file" id="otp_image" name="otp_image"
                                        class="form-control @error('otp_image') is-invalid @enderror" accept="image/*">
                                    @error('otp_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Image Preview -->
                                    @if (isset($editEntry) && $editEntry->otp_image)
                                        <div class="image-preview-container">
                                            <p class="mb-1">Current Image:</p>
                                            <img src="{{ asset('storage/' . $editEntry->otp_image) }}" alt="OTP Image"
                                                class="preview-image">
                                        </div>
                                    @endif
                                    <div id="otpImagePreview" class="image-preview-container"></div>
                                    <small class="text-muted">Upload OTP image (optional)</small>
                                </div>

                                <!-- Date Field -->
                                <div class="col-md-12 mb-3">
                                    <label for="date" class="form-label">Date *</label>
                                    <input type="date" id="date" name="date"
                                        class="form-control @error('date') is-invalid @enderror"
                                        value="{{ old('date', isset($editEntry) && $editEntry->date ? \Carbon\Carbon::parse($editEntry->date)->format('Y-m-d') : '') }}"
                                        required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.register-contect.create') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas {{ isset($editEntry) ? 'fa-save' : 'fa-plus' }} me-1"></i>
                                    {{ isset($editEntry) ? 'Update Information' : 'Create Information' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Existing Entries Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>
                            All Contact Entries
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($entries->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Location Image</th>
                                            <th>Name Image</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entries as $entry)
                                            <tr
                                                class="{{ isset($editEntry) && $editEntry->id == $entry->id ? 'table-active' : '' }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-calendar text-muted me-2"></i>
                                                        {{ $entry->date ? \Carbon\Carbon::parse($entry->date)->format('d M Y') : 'N/A' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($entry->location_image)
                                                        <img src="{{ asset('storage/' . $entry->location_image) }}"
                                                            alt="Location"
                                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($entry->name_image)
                                                        <img src="{{ asset('storage/' . $entry->name_image) }}"
                                                            alt="Name"
                                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.register-contect.create', ['edit' => $entry->id]) }}"
                                                        class="btn btn-sm btn-outline-warning {{ isset($editEntry) && $editEntry->id == $entry->id ? 'active' : '' }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Showing {{ $entries->count() }} entries
                                </small>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No contact entries found</p>
                            </div>
                        @endif
                    </div>
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
        // Image preview functionality
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(previewId).html('<img src="' + e.target.result + '" class="preview-image" alt="Preview">');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Initialize image previews
        $(document).ready(function() {
            // Location image preview
            $('#location_image').change(function() {
                previewImage(this, '#locationImagePreview');
            });

            // Name image preview
            $('#name_image').change(function() {
                previewImage(this, '#nameImagePreview');
            });

            // Phone image preview
            $('#phone_image').change(function() {
                previewImage(this, '#phoneImagePreview');
            });

            // Email image preview
            $('#email_image').change(function() {
                previewImage(this, '#emailImagePreview');
            });

            // OTP image preview
            $('#otp_image').change(function() {
                previewImage(this, '#otpImagePreview');
            });
        });
    </script>
@endsection
