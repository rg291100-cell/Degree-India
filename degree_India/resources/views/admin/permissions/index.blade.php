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
</style>

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4 mt-3">
                <h2 class="page-title">Permission Management</h2>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h4 class="header-title">Permissions List</h4>
                                <p class="text-muted">Manage system permissions</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                    ← Back to Role List
                                </a>
                                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create Permission
                                </a>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-hover table-centered mb-0" id="permissionTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Module</th>
                                        <th>Roles</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->id }}</td>
                                            <td>
                                                <strong>{{ $permission->name }}</strong>
                                                @if ($permission->description)
                                                    <p class="text-muted mb-0 small">{{ $permission->description }}</p>
                                                @endif
                                            </td>
                                            <td>{{ $permission->slug }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $permission->module }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-info">{{ $permission->roles_count ?? $permission->roles->count() }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.permissions.edit', $permission) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.permissions.destroy', $permission) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this permission?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


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
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {

            $('#permissionTable').DataTable({
                "pageLength": 5,
                "responsive": true,
                "order": [
                    [5, 'asc']
                ],
                "language": {
                    "search": "Search :",
                    "lengthMenu": "Show _MENU_",
                    "info": "Showing _START_ to _END_ of _TOTAL_ ",
                    "paginate": {
                        "previous": "‹",
                        "next": "›"
                    }
                }
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
@endsection
