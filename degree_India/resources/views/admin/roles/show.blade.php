@extends('admin.layouts.master')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@section('content')
    <div class="container-fluid">
        <div class="row align-items-center mt-4 mb-4">
            <div class="col-md-8 col-12">
                <h2 class="page-title mb-1">Role Details</h2>
            </div>

            <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                    ← Back to List
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Role Information</h5>

                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="120">Name:</th>
                                <td><strong>{{ $role->name }}</strong></td>
                            </tr>
                            <tr>
                                <th>Slug:</th>
                                <td><code>{{ $role->slug }}</code></td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td>{{ $role->description ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @if ($role->is_default)
                                        <span class="badge bg-success">Default Role</span>
                                    @else
                                        <span class="badge bg-secondary">Custom Role</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $role->created_at->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Updated:</th>
                                <td>{{ $role->updated_at->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Permissions:</th>
                                <td><span class="badge bg-primary">{{ $role->permissions->count() }}</span></td>
                            </tr>
                        </table>


                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <span>Assigned Permissions</span>
                            <span class="badge bg-primary">{{ $role->permissions->count() }} Permissions</span>
                        </h5>

                        @if ($role->permissions->count() > 0)
                            <div class="row">
                                @foreach ($role->permissions->groupBy('module') as $module => $permissions)
                                    <div class="col-md-6 mb-3">
                                        <div class="border rounded p-3 h-100">
                                            <h6 class="border-bottom pb-2 mb-3">
                                                <i class="fas fa-folder text-primary me-2"></i>
                                                {{ ucfirst($module) }}
                                                <span
                                                    class="badge bg-light text-dark float-end">{{ $permissions->count() }}</span>
                                            </h6>

                                            <div class="permission-list">
                                                @foreach ($permissions as $permission)
                                                    <div class="d-flex align-items-start mb-2 pb-2 border-bottom">
                                                        <div class="flex-grow-1">
                                                            <div class="fw-medium">{{ $permission->name }}</div>
                                                            <small class="text-muted d-block">
                                                                <code>{{ $permission->slug }}</code>
                                                            </small>
                                                            @if ($permission->description)
                                                                <small
                                                                    class="text-muted">{{ $permission->description }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="mb-3">
                                    <i class="fas fa-key fa-3x text-muted"></i>
                                </div>
                                <h5>No Permissions Assigned</h5>
                                <p class="text-muted">This role doesn't have any permissions yet.</p>
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus"></i> Add Permissions
                                </a>
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
@endsection
