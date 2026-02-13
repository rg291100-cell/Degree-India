@extends('admin.layouts.master')

@section('title', 'Blogs Management')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    :root {
        --primary-color: #4361ee;
        --primary-light: #eef2ff;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --info-color: #3b82f6;
        --danger-color: #ef4444;
        --dark-color: #1f2937;
        --light-color: #f9fafb;
        --border-color: #e5e7eb;
    }

    .blog-management {
        padding: 1.5rem;
    }

    td {
        font-size: 13px;
    }

    .header-section {
        background: linear-gradient(135deg, #bdbdbe 0%, #e0e0e0 100%);
        /* border-radius: 16px; */
        padding: 1rem;
        color: white;
        margin-bottom: 2rem;
        /* box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); */
    }

    .header-section h1 {
        font-weight: 700;
        font-size: 2.25rem;
        margin-bottom: 0.5rem;
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        border: 1px solid var(--border-color);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.5rem;
    }

    .stat-icon.published {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .stat-icon.draft {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .stat-icon.archived {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
    }

    .stat-icon.total {
        background: rgba(59, 130, 246, 0.1);
        color: var(--info-color);
    }

    .stat-info h3 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: var(--dark-color);
    }

    .stat-info p {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 0;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .btn-refresh {
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        color: #374151;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-refresh:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    .btn-add {
        background: var(--primary-color);
        border: none;
        color: white;
        padding: 0.625rem 1.5rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        background: #3730a3;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
    }

    .blog-table-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-color);
    }

    .table-header {
        background: #f9fafb;
        padding: 1.25rem;
        border-bottom: 1px solid var(--border-color);
    }

    .table-header h5 {
        color: var(--dark-color);
        font-weight: 600;
        margin-bottom: 0;
    }

    .blog-image {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #e5e7eb;
        transition: transform 0.3s ease;
    }

    .blog-image:hover {
        transform: scale(1.5);
        z-index: 10;
        position: relative;
    }

    .title-column {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .blog-title {
        color: var(--dark-color);
        font-weight: 500;
        display: block;
    }

    .blog-excerpt {
        color: #6b7280;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: block;
    }

    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .status-published {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-draft {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-archived {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .action-buttons-cell {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-view {
        background: rgba(59, 130, 246, 0.1);
        color: var(--info-color);
    }

    .btn-view:hover {
        background: var(--info-color);
        color: white;
    }

    .btn-edit {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .btn-edit:hover {
        background: var(--success-color);
        color: white;
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    .btn-delete:hover {
        background: var(--danger-color);
        color: white;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: 1px solid #d1d5db !important;
        border-radius: 6px !important;
        margin: 0 2px !important;
        padding: 0.375rem 0.75rem !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary-color) !important;
        color: white !important;
        border-color: var(--primary-color) !important;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .empty-state h5 {
        color: #9ca3af;
        font-weight: 500;
    }

    .date-badge {
        background: #f3f4f6;
        color: #4b5563;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    @media (max-width: 768px) {
        .header-section {
            padding: 1.5rem;
        }

        .header-section h1 {
            font-size: 1.75rem;
        }

        .stats-cards {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons a {
            width: 100%;
            justify-content: center;
        }
    }
</style>

@section('content')
    @php
        $role = auth()->user()->role_id;
    @endphp
    <div class="blog-management">
        <!-- Header Section -->
        <div class="header-section">
            <h1>Blogs Management</h1>
            <p>Manage educational content, career guidance articles, and college information for students. Create, edit, and
                organize blog posts effectively.</p>
        </div>

        <!-- Stats Cards -->
        @php
            $publishedCount = $blogs->where('status', 'published')->count();
            $draftCount = $blogs->where('status', 'draft')->count();
            $archivedCount = $blogs->where('status', 'archived')->count();
        @endphp

        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $blogs->count() }}</h3>
                    <p>Total Blogs</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon published">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $publishedCount }}</h3>
                    <p>Published</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon draft">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $draftCount }}</h3>
                    <p>Drafts</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon archived">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $archivedCount }}</h3>
                    <p>Archived</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('admin.blogs.index') }}" class="btn-refresh">
                <i class="fas fa-sync-alt"></i> Refresh
            </a>
            <a href="{{ route('admin.blogs.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Add New Blog
            </a>
        </div>

        <!-- Blog Table -->
        <div class="blog-table-card">
            <div class="table-header">
                <h5>All Blog Posts</h5>
            </div>

            <div class="table-responsive" style="padding: 20px;">
                <table class="table table-hover mb-0" id="blogsTable">
                    <thead>
                        <tr>
                            <th width="70">Image</th>
                            <th>Title </th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th width="140">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blogs as $blog)
                            <tr>
                                <td>
                                    @if ($blog->featured_image)
                                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                                            class="blog-image" data-bs-toggle="tooltip" title="Click to enlarge">
                                    @else
                                        <div
                                            style="width: 50px; height: 50px; border-radius: 8px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="title-column">
                                    <span class="blog-title">{{ $blog->title ?? '' }}</span>

                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div
                                            style="width: 32px; height: 32px; border-radius: 50%; background: #3b82f6; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem; margin-right: 0.5rem;">
                                            {{ substr($blog->user->name ?? 'A', 0, 1) }}
                                        </div>
                                        <span>{{ $blog->user->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 500;">
                                        {{ $blog->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($blog->status == 'published')
                                        <span class="status-badge status-published">
                                            <i class="fas fa-check-circle"></i> Published
                                        </span>
                                    @elseif($blog->status == 'draft')
                                        <span class="status-badge status-draft">
                                            <i class="fas fa-edit"></i> Draft
                                        </span>
                                    @else
                                        <span class="status-badge status-archived">
                                            <i class="fas fa-archive"></i> Archived
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="date-badge">
                                        <i class="far fa-calendar"></i>
                                        {{ $blog->created_at->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons-cell">
                                        @hasPermission('show-blogs')
                                            <a href="{{ route('admin.blogs.show', $blog) }}" class="btn-action btn-view"
                                                title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endhasPermission

                                        @hasPermission('edit-blogs')
                                            <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn-action btn-edit"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endhasPermission

                                        @hasPermission('delete-blogs')
                                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Delete"
                                                    onclick="return confirmDelete(event)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endhasPermission
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-newspaper"></i>
                                        <h5>No blogs found</h5>
                                        <p>Start by creating your first blog post</p>
                                        <a href="{{ route('admin.blogs.create') }}" class="btn-add mt-3"
                                            style="display: inline-flex;">
                                            <i class="fas fa-plus"></i> Create First Blog
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Image Preview Modal -->
        <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Blog Image Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="previewImage" src="" alt="Blog Image" class="img-fluid rounded"
                            style="max-height: 500px;">
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
            // Initialize DataTable
            $('#blogsTable').DataTable({
                "pageLength": 10,
                "order": [
                    [5, 'desc']
                ],
                "language": {
                    "search": "Search blogs:",
                    "lengthMenu": "Show _MENU_ blogs per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ blogs",
                    "paginate": {
                        "previous": "‹",
                        "next": "›"
                    },
                    "emptyTable": "No blogs available"
                },
                "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 6]
                    },
                    {
                        "searchable": false,
                        "targets": [0, 5, 6]
                    }
                ]
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Image preview modal
            $(document).on('click', '.blog-image', function() {
                const imageUrl = $(this).attr('src');
                $('#previewImage').attr('src', imageUrl);
                const imagePreviewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
                imagePreviewModal.show();
            });

            // Custom delete confirmation
            function confirmDelete(event) {
                event.preventDefault();
                const form = event.target.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This blog post will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

                return false;
            }

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
