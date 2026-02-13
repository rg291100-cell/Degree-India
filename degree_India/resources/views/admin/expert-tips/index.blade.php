@extends('admin.layouts.master')
@section('title', 'Expert Tips')
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
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Expert Tips List</h4>

                    <a href="{{ route('admin.expert-tips.create') }}" class="btn btn-primary btn-sm float-end">
                        <i class="fas fa-plus"></i> Add New Expert Tip
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="expertTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Thumbnail</th>
                                    <th>Title</th>
                                    <th>Video Link</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expertTips as $tip)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($tip->thumbnail)
                                                <img src="{{ $tip->thumbnail }}" alt="{{ $tip->title }}" width="80"
                                                    class="img-thumbnail">
                                            @else
                                                <span class="badge bg-warning">No Thumbnail</span>
                                            @endif
                                        </td>
                                        <td>{{ $tip->title }}</td>
                                        <td>
                                            @if ($tip->video_link)
                                                <a href="{{ $tip->video_link }}" target="_blank" class="text-primary">
                                                    <i class="fas fa-external-link-alt"></i> View Video
                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $tip->is_active ? 'success' : 'danger' }}">
                                                {{ $tip->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.expert-tips.edit', $tip) }}"
                                                    class="btn btn-sm btn-warning" style="height: 25px;">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.expert-tips.show', $tip) }}"
                                                    class="btn btn-sm btn-primary" style="height: 25px;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.expert-tips.destroy', $tip) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')" style="height: 25px;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No expert tips found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $expertTips->links() }}
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

            $('#expertTable').DataTable({
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

            // Toast notification function
            function showToast(message, type = 'success') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: type === 'success' ? '#d4edda' : '#f8d7da',
                    color: type === 'success' ? '#155724' : '#721c24',
                    iconColor: type === 'success' ? '#28a745' : '#dc3545',
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



            // Add tooltips to action buttons
            $('[title]').tooltip({
                trigger: 'hover',
                placement: 'top'
            });
        });
    </script>
@endsection
