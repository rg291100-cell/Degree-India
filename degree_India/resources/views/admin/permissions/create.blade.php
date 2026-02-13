@extends('admin.layouts.master')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@section('content')
    <div class="container-fluid">

        <div class="row align-items-center mt-4 mb-4">
            <div class="col-md-8 col-12">
                <h2 class="page-title mb-1">Create New Permission</h2>
            </div>

            <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">
                    ← Back to List
                </a>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.permissions.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Permission Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" placeholder="e.g., View Users"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Use descriptive names like "View Users", "Create Courses",
                                    etc.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="module" class="form-label">Module *</label>
                                        <select class="form-select @error('module') is-invalid @enderror" id="module"
                                            name="module" required>
                                            <option value="">Select Module</option>
                                            @foreach ($modules as $module)
                                                <option value="{{ $module }}"
                                                    {{ old('module') == $module ? 'selected' : '' }}>
                                                    {{ ucfirst($module) }}
                                                </option>
                                            @endforeach
                                            <option value="custom" {{ old('module') == 'custom' ? 'selected' : '' }}>Custom
                                                Module</option>
                                        </select>
                                        <div id="custom-module-container"
                                            style="display: {{ old('module') == 'custom' ? 'block' : 'none' }};"
                                            class="mt-2">
                                            <input type="text"
                                                class="form-control @error('custom_module') is-invalid @enderror"
                                                id="custom-module" name="custom_module" value="{{ old('custom_module') }}"
                                                placeholder="Enter custom module name">
                                            @error('custom_module')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @error('module')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Group permissions by module (e.g., Users, Courses,
                                            Settings)</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug-preview" class="form-label">Slug Preview</label>
                                        <input type="text" class="form-control" id="slug-preview" readonly>
                                        <small class="text-muted">Auto-generated slug for API usage</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="3" placeholder="Describe what this permission allows...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Permission</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>

    @push('scripts')
        <script>
            // Auto-generate slug preview
            document.getElementById('name').addEventListener('input', function() {
                const name = this.value.toLowerCase();
                const slug = name.replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, '-');
                document.getElementById('slug-preview').value = slug;
            });

            // Custom module toggle
            document.getElementById('module').addEventListener('change', function() {
                const customModuleContainer = document.getElementById('custom-module-container');
                if (this.value === 'custom') {
                    customModuleContainer.style.display = 'block';
                    document.getElementById('custom-module').focus();
                } else {
                    customModuleContainer.style.display = 'none';
                }
            });

            // Initialize slug preview on page load
            document.addEventListener('DOMContentLoaded', function() {
                const nameInput = document.getElementById('name');
                if (nameInput.value) {
                    const name = nameInput.value.toLowerCase();
                    const slug = name.replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, '-');
                    document.getElementById('slug-preview').value = slug;
                }
            });
        </script>
    @endpush

    <style>
        .permission-preview {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .permission-preview h6 {
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
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
