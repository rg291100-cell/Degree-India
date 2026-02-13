@extends('admin.layouts.master')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@section('content')
    <div class="container-fluid">

        <div class="row align-items-center mt-4 mb-4">
            <div class="col-md-8 col-12">
                <h2 class="page-title mb-1">Edit Role: {{ $role->name }}</h2>
            </div>

            <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                    ← Back to List
                </a>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Role Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $role->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input type="text" class="form-control" id="slug"
                                            value="{{ $role->slug }}" readonly>
                                        <small class="text-muted">Auto-generated from name</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $role->description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is_default" name="is_default"
                                        {{ $role->is_default ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_default">Set as default role for new
                                        users</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h5 class="mb-3">Permissions</h5>
                                <div class="row">
                                    @foreach ($permissions as $module => $modulePermissions)
                                        <div class="col-md-4 mb-4">
                                            <div class="card border">
                                                <div
                                                    class="card-header bg-light d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0">{{ ucfirst($module) }}</h6>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input module-checkbox"
                                                            data-module="{{ $module }}">
                                                        <label class="form-check-label small">Select All</label>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    @foreach ($modulePermissions as $permission)
                                                        <div class="form-check mb-2">
                                                            <input type="checkbox"
                                                                class="form-check-input permission-checkbox"
                                                                id="permission_{{ $permission->id }}" name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="permission_{{ $permission->id }}">
                                                                <strong>{{ $permission->name }}</strong>
                                                                @if ($permission->description)
                                                                    <br><small
                                                                        class="text-muted">{{ $permission->description }}</small>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Module checkbox functionality
            document.addEventListener('DOMContentLoaded', function() {
                const moduleCheckboxes = document.querySelectorAll('.module-checkbox');

                moduleCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const module = this.getAttribute('data-module');
                        const permissionCheckboxes = document.querySelectorAll(
                            `.card-header:contains(${module})`).closest('.card').querySelectorAll(
                            '.permission-checkbox');

                        permissionCheckboxes.forEach(permissionCheckbox => {
                            permissionCheckbox.checked = this.checked;
                        });
                    });
                });

                // Check if all permissions in a module are checked
                document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const card = this.closest('.card');
                        const moduleCheckbox = card.querySelector('.module-checkbox');
                        const allPermissions = card.querySelectorAll('.permission-checkbox');
                        const checkedPermissions = card.querySelectorAll(
                            '.permission-checkbox:checked');

                        moduleCheckbox.checked = allPermissions.length === checkedPermissions.length;
                        moduleCheckbox.indeterminate = checkedPermissions.length > 0 &&
                            checkedPermissions.length < allPermissions.length;
                    });
                });
            });
        </script>
    @endpush
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
