@extends('admin.layouts.master')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@section('content')
    <div class="container-fluid">
        <div class="row align-items-center mt-4 mb-4">
            <div class="col-md-8 col-12">
                <h2 class="page-title mb-1">Edit Permission: {{ $permission->name }}</h2>
            </div>

            <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">
                    ← Back to List
                </a>
            </div>
        </div>


        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Permission Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $permission->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input type="text" class="form-control" id="slug"
                                            value="{{ $permission->slug }}" readonly>
                                        <small class="text-muted">Auto-generated from name</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="module" class="form-label">Module *</label>
                                        <select class="form-select @error('module') is-invalid @enderror" id="module"
                                            name="module" required>
                                            <option value="">Select Module</option>
                                            @foreach ($modules as $module)
                                                <option value="{{ $module }}"
                                                    {{ old('module', $permission->module) == $module ? 'selected' : '' }}>
                                                    {{ ucfirst($module) }}
                                                </option>
                                            @endforeach
                                            <option value="custom">Custom Module</option>
                                        </select>
                                        <div id="custom-module-container" style="display: none;" class="mt-2">
                                            <input type="text" class="form-control" id="custom-module"
                                                name="custom_module" placeholder="Enter custom module name">
                                        </div>
                                        @error('module')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $permission->description) }}</textarea>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Permission</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Permission Details</h5>

                        <div class="mb-3">
                            <label class="form-label text-muted">Created</label>
                            <p>{{ $permission->created_at->format('M d, Y h:i A') }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Last Updated</label>
                            <p>{{ $permission->updated_at->format('M d, Y h:i A') }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Assigned to Roles</label>
                            <p class="h4 text-primary">{{ $permission->roles->count() }}</p>
                        </div>

                        @if ($permission->roles->count() > 0)
                            <div class="mb-3">
                                <label class="form-label text-muted">Roles with this permission:</label>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach ($permission->roles as $role)
                                        <a href="{{ route('admin.roles.show', $role) }}"
                                            class="badge bg-info text-decoration-none">
                                            {{ $role->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Danger Zone</h5>
                        <p class="text-muted">Once you delete a permission, there is no going back. Please be certain.</p>

                        <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST"
                            onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Delete Permission
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Custom module toggle
            document.getElementById('module').addEventListener('change', function() {
                const customModuleContainer = document.getElementById('custom-module-container');
                if (this.value === 'custom') {
                    customModuleContainer.style.display = 'block';
                } else {
                    customModuleContainer.style.display = 'none';
                }
            });

            function confirmDelete() {
                const rolesCount = {{ $permission->roles->count() }};

                if (rolesCount > 0) {
                    alert('This permission is assigned to ' + rolesCount +
                        ' role(s). Please remove it from all roles before deleting.');
                    return false;
                }

                return confirm('Are you sure you want to delete this permission? This action cannot be undone.');
            }
        </script>
    @endpush

    <style>
        .danger-zone {
            border: 2px solid #f87171;
            background: rgba(248, 113, 113, 0.05);
        }
    </style>
@endsection


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
