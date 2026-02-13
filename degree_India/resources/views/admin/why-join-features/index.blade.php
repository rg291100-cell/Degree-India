@extends('admin.layouts.master')

@section('title', 'Why Join Us Features')

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

    .badge-success {
        background-color: #28a745 !important;
        color: #fff !important;
    }

    .badge-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    .badge-secondary {
        background-color: #6c757d !important;
        color: #fff !important;
    }
</style>

@section('content')
    <div class="container-fluid mt-4">


        <div class="card-header d-flex justify-content-between">
            <div class="card-tools">
                <h3 class="card-title">Why Join Us Features</h3>
                <small>Manage the features displayed in the "Why Join Us" section</small>
            </div>
            <div class="card-tools">
                <a href="{{ route('admin.why-join-features.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Course
                </a>
            </div>
        </div>



        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($features->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover" id="featureTable">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Icon</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable">
                                        @foreach ($features as $feature)
                                            <tr data-id="{{ $feature->id }}">
                                                <td>
                                                    <i class="fas fa-arrows-alt-v handle me-2" style="cursor: move;"></i>
                                                    {{ $feature->order }}
                                                </td>
                                                <td>
                                                    <i class="{{ $feature->icon }} fa-lg"></i>
                                                </td>
                                                <td>{{ $feature->title }}</td>
                                                <td>{{ Str::limit($feature->description, 50) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $feature->is_active ? 'success' : 'danger' }}">
                                                        {{ $feature->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{-- <a href="{{ route('admin.why-join-features.show', $feature) }}"
                                                        class="btn btn-sm btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a> --}}
                                                    <a href="{{ route('admin.why-join-features.edit', $feature) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.why-join-features.destroy', $feature) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this feature?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                No features found. <a href="{{ route('admin.why-join-features.create') }}">Create one</a>.
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        let baseUrl = "{{ config('app.url') }}";
        document.addEventListener('DOMContentLoaded', function() {
            const sortable = document.getElementById('sortable');

            if (sortable) {
                new Sortable(sortable, {
                    handle: '.handle',
                    animation: 150,
                    onEnd: function(evt) {
                        const order = [];
                        document.querySelectorAll('#sortable tr').forEach((row, index) => {
                            order.push(row.getAttribute('data-id'));
                        });

                        fetch('{{ route('admin.why-join-features.update-order') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    order: order
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update order numbers in table
                                    document.querySelectorAll('#sortable tr').forEach((row,
                                        index) => {
                                        row.querySelector('td:first-child').innerHTML =
                                            `<i class="fas fa-arrows-alt-v handle me-2" style="cursor: move;"></i> ${index}`;
                                    });
                                }
                            });
                    }
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#featureTable').DataTable({
                "pageLength": 5,
                "responsive": true,
                "ordering": true,
                "info": true,
                "paging": true,
                "searching": false,
                "language": {
                    "emptyTable": "No courses available"
                },
                "dom": 'lrtip' // Hide default search box
            });



            // Toast notification
            function showToast(message, type = 'success') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: type,
                    title: message
                });
            }

            // Display success/error messages from session
            @if (session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif

            @if (session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
        });
    </script>
@endsection
