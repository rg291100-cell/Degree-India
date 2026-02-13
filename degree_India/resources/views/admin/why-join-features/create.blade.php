@extends('admin.layouts.master')

@section('title', 'Add Feature - Why Join Us')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

@section('content')
    <div class="container-fluid mt-4">

        <div class="card-header d-flex justify-content-between">
            <div class="card-tools" style="padding-left: 12px;">
                <h3 class="card-title">Add New Feature</h3>
                <small> Add a new feature to the "Why Join Us" section</small>
            </div>

            <div class="card-tools">
                <a href="{{ route('admin.why-join-features.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back To List
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.why-join-features.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title') }}" required
                                            placeholder="Enter Title">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="icon" class="form-label">Icon *</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i id="icon-preview"></i></span>
                                            <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                                id="icon" name="icon" value="{{ old('icon') }}"
                                                placeholder="fas fa-users" required>
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="openIconPicker()">
                                                <i class="fas fa-icons"></i> Pick Icon
                                            </button>
                                        </div>
                                        <small class="text-muted">Enter FontAwesome icon class (e.g., fas fa-users)</small>
                                        @error('icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="3" placeholder="Enter Description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="order" class="form-label">Order</label>
                                        <input type="number" class="form-control" id="order" name="order"
                                            value="{{ old('order', 0) }}" min="0">
                                        <small class="text-muted">Lower number appears first</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                                {{ old('is_active') ? 'checked' : '' }} value="1">
                                            <label class="form-check-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Save Feature
                                </button>
                                <a href="{{ route('admin.why-join-features.index') }}" class="btn btn-light">
                                    Cancel
                                </a>
                            </div>
                        </form>
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
        function openIconPicker() {
            // This would typically open a modal with icon selection
            // For now, we'll use a simple alert
            alert('Icon picker would open here. For now, enter FontAwesome icon class manually.');
        }

        // Update icon preview
        document.getElementById('icon').addEventListener('input', function() {
            const preview = document.getElementById('icon-preview');
            preview.className = this.value;
        });
    </script>
@endsection
