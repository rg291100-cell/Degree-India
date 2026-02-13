@extends('admin.layouts.master')

@section('title', 'Colleges Management')

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

    td {
        font-size: 12px;
    }

    /* Filter Form Styling */
    .filter-form {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #dee2e6;
    }

    .filter-form .form-control-sm {
        font-size: 0.875rem;
    }

    .active-filters {
        background: #e7f1ff;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        border-left: 4px solid #0d6efd;
    }

    .active-filters-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
    }

    .export-buttons .btn {
        padding: 6px 12px;
        font-size: 0.875rem;
    }
</style>

@section('content')
    @php
        $role = auth()->user()->role_id;
    @endphp
    <div class="container-fluid mt-4">
        <!-- Header with Export Buttons -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Colleges Management</h1>
            <div class="d-flex gap-2">
                <!-- Export Buttons -->
                <div class="btn-group export-buttons" role="group">
                    <button type="button" class="btn btn-outline-primary" onclick="exportData('print')">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="exportData('pdf')">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="exportData('csv')">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                </div>

                @hasPermission('create-colleges')
                    <a href="{{ route('admin.colleges.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New College
                    </a>
                @endhasPermission
            </div>
        </div>



        <!-- Stats Summary -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Colleges
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $colleges->total() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-university fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Published
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $colleges->where('status', 'published')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    With Admin
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $colleges->whereNotNull('user_id')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Courses
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $colleges->sum('courses_count') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Colleges List
                    @if (request()->hasAny(['status', 'type', 'state', 'search']))
                        <small class="text-muted">(Filtered Results)</small>
                    @endif
                </h6>
                <div class="text-muted small">
                    Showing {{ $colleges->firstItem() ?? 0 }} to {{ $colleges->lastItem() ?? 0 }} of
                    {{ $colleges->total() }} colleges
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="collegeTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Courses</th>
                                <th>Status</th>
                                <th>Admin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($colleges as $college)
                                <tr>
                                    <td>{{ $college->id }}</td>
                                    <td>
                                        @if ($college->logo && file_exists(public_path('storage/' . $college->logo)))
                                            <img src="{{ asset('storage/' . $college->logo) }}" alt="{{ $college->name }}"
                                                width="50" height="50" class="rounded-circle object-fit-cover">
                                        @else
                                            <img src="{{ asset('images/Collegelogo.jpg') }}" alt="{{ $college->name }}"
                                                width="50" height="50" class="rounded-circle object-fit-cover">
                                        @endif
                                    </td>

                                    <td>
                                        <strong>{{ $college->name }}</strong><br>
                                        <small class="text-muted">{{ $college->short_description }}</small>
                                    </td>
                                    <td>
                                        {{ $college->city }}, {{ $college->state }}<br>
                                        <small class="text-muted">{{ $college->country }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-capitalize">{{ $college->type }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-secondary">{{ $college->courses_count ?? $college->courses->count() }}
                                            courses</span>
                                    </td>
                                    <td>
                                        @if ($college->status == 'published')
                                            <span class="badge bg-success">Published</span>
                                        @elseif($college->status == 'draft')
                                            <span class="badge bg-warning">Draft</span>
                                        @else
                                            <span class="badge bg-danger">Archived</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($college->admin)
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="avatar-sm bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <i class="fas fa-user-tie text-success fa-sm"></i>
                                                </div>
                                                <div>
                                                    <small class="d-block">{{ $college->admin->name }}</small>
                                                    <small class="text-muted">{{ $college->admin->email }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge bg-warning">Not Assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.colleges.show', $college) }}"
                                                class="btn btn-info btn-sm" style="height: 25px;" data-toggle="tooltip"
                                                data-placement="top" title="View College Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.colleges.edit', $college) }}"
                                                class="btn btn-warning btn-sm" style="height: 25px;"
                                                data-toggle="tooltip" data-placement="top" title="Edit College">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="{{ route('admin.colleges.account-details', $college) }}"
                                                class="btn btn-secondary btn-sm" style="height: 25px; padding: 2px 8px;"
                                                data-toggle="tooltip" data-placement="top"
                                                title="View Bank Account Details">
                                                <i class="fas fa-university"></i>
                                            </a>

                                            <!-- Assign Admin Button -->
                                            @hasPermission('assign-college-admin')
                                                <button type="button" class="btn btn-success btn-sm assign-admin-btn"
                                                    style="height: 25px;" data-college-id="{{ $college->id }}"
                                                    data-college-name="{{ $college->name }}"
                                                    data-user-id="{{ $college->user_id }}"
                                                    data-admin-name="{{ $college->admin->name ?? '' }}"
                                                    data-bs-toggle="modal" data-bs-target="#assignAdminModal">
                                                    <i class="fas fa-user-plus"></i>
                                                </button>
                                            @endhasPermission

                                            <form action="{{ route('admin.colleges.destroy', $college) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    style="height: 25px;" onclick="return confirm('Are you sure?')"
                                                    data-toggle="tooltip" data-placement="top" title="Delete College">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="py-4">
                                            <i class="fas fa-university fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No Colleges Found</h5>
                                            @if (request()->hasAny(['status', 'type', 'state', 'search']))
                                                <p class="text-muted">No colleges match your filter criteria.</p>
                                            @else
                                                <p class="text-muted">No colleges have been added yet.</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($colleges->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $colleges->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal for Assigning Admin -->
        <div class="modal fade" id="assignAdminModal" tabindex="-1" role="dialog"
            aria-labelledby="assignAdminModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Assign Admin to College</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="assignAdminForm" method="POST" action="{{ route('admin.colleges.assign-admin') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="college_id" name="college_id">

                            <div class="form-group mb-3">
                                <label for="college_name">College Name</label>
                                <input type="text" class="form-control" id="college_name" readonly>
                            </div>

                            <div class="form-group">
                                <label for="user_id">Select Admin</label>
                                <select class="form-control" id="user_id" name="user_id" required>
                                    <option value="">Select Admin</option>
                                    @foreach ($collegeAdminUserList as $college_admin)
                                        <option value="{{ $college_admin->id }}">{{ $college_admin->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Display currently assigned admin -->
                            <div class="form-group mt-3" id="currentAdminDiv" style="display:none;">
                                <small class="text-muted">Currently assigned: <span id="currentAdminName"></span></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Assign Admin</button>
                        </div>
                    </form>
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
            // Initialize DataTable
            $('#collegeTable').DataTable({
                "pageLength": 5,
                "ordering": true,
                "info": true,
                "paging": true,
                "searching": false,
                "language": {
                    "emptyTable": "No colleges available"
                }
            });

            // Export function
            window.exportData = function(format) {
                // Get current filter values
                const status = $('#status').val();
                const type = $('#type').val();
                const state = $('#state').val();
                const search = $('#search').val();

                // Build export URL with current filters
                let url = '{{ route('admin.colleges.index') }}?export=' + format;

                if (status) url += '&status=' + status;
                if (type) url += '&type=' + type;
                if (state) url += '&state=' + state;
                if (search) url += '&search=' + encodeURIComponent(search);

                if (format === 'print') {
                    // Open print view in new window
                    window.open(url + '&auto_print=1', '_blank');
                } else {
                    // Download PDF or CSV
                    window.location.href = url;
                }
            };

            // Assign Admin Modal
            $('#assignAdminModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var collegeId = button.data('college-id');
                var collegeName = button.data('college-name');
                var currentUserId = button.data('user-id');
                var adminName = button.data('admin-name');

                var modal = $(this);
                modal.find('#college_id').val(collegeId);
                modal.find('#college_name').val(collegeName);
                modal.find('#user_id').val(currentUserId || '');

                // Show current admin if exists
                if (currentUserId && adminName) {
                    modal.find('#currentAdminName').text(adminName);
                    modal.find('#currentAdminDiv').show();
                } else {
                    modal.find('#currentAdminDiv').hide();
                }
            });

            // Handle form submission
            $('#assignAdminForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var url = $(this).attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: response.success,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });

                            // Close modal
                            $('#assignAdminModal').modal('hide');

                            // Reload page after showing message
                            setTimeout(function() {
                                location.reload();
                            }, 1500);

                        } else if (response.error) {
                            Swal.fire({
                                toast: true,
                                icon: 'error',
                                title: response.error,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '\n';
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: errorMessage,
                                confirmButtonText: 'OK'
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.error) {
                            Swal.fire({
                                toast: true,
                                icon: 'error',
                                title: xhr.responseJSON.error,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong! Please try again.',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
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
