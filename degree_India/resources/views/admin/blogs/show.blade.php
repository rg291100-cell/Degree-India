@extends('admin.layouts.master')

@section('title', 'Blog Details: ' . $blog->title)

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<style>
    :root {
        --primary-color: #4361ee;
        --success-color: #06d6a0;
        --warning-color: #ffd166;
        --danger-color: #ef476f;
        --dark-color: #2b2d42;
        --light-color: #f8f9fa;
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    body {
        background-color: #f5f7fb;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin-bottom: 1.5rem;
    }



    .card-header {
        background: linear-gradient(135deg, gray 0%, #dbdbdb 100%);
        color: white !important;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }

    .card-header .card-title {
        font-weight: 600;
        margin: 0;
        font-size: 1.4rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.5rem 1.25rem;
        transition: var(--transition);
    }

    .btn i {
        margin-right: 6px;
    }

    .blog-content {
        line-height: 1.7;
        color: #495057;
    }

    .blog-content img {
        max-width: 100%;
        border-radius: 8px;
        margin: 1rem 0;
    }

    .info-card {
        background: white;
        padding: 1.25rem;
        border-radius: 10px;
        border-left: 4px solid var(--primary-color);
        margin-bottom: 1rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .info-card h5 {
        color: var(--dark-color);
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 1.1rem;
    }

    .info-card .info-item {
        display: flex;
        margin-bottom: 0.75rem;
        align-items: flex-start;
    }

    .info-item .info-icon {
        width: 36px;
        height: 36px;
        background: rgba(67, 97, 238, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        margin-right: 12px;
        flex-shrink: 0;
    }

    .info-item .info-content h6 {
        font-size: 0.9rem;
        font-weight: 600;
        margin: 0;
        color: #6c757d;
    }

    .info-item .info-content p {
        margin: 0;
        font-weight: 500;
        color: var(--dark-color);
    }

    p {
        font-size: 12px !important;
    }

    .featured-image-container {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .featured-image-container img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .featured-image-container:hover img {
        transform: scale(1.03);
    }

    .action-btn-group .btn {
        width: 100%;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem;
        border-radius: 10px;
        font-weight: 500;
    }

    .action-btn-group .btn i {
        margin-right: 10px;
        font-size: 1.1rem;
    }

    .preview-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
    }

    .preview-card h4 {
        color: var(--dark-color);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .preview-card p {
        color: #6c757d;
        margin-bottom: 1.25rem;
    }

    .preview-btn {
        background: linear-gradient(135deg, #20c997 0%, #17a589 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }



    .seo-keywords {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 8px;
    }

    .keyword-badge {
        background: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .stats-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 0.9rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .stats-badge i {
        margin-right: 6px;
    }

    .back-btn {
        background: #6c757d;
        color: white;
        border: none;
        padding: 0.6rem 1.25rem;
        border-radius: 8px;
        transition: var(--transition);
    }


    .edit-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        transition: var(--transition);
    }



    .content-section {
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .content-section h5 {
        color: var(--primary-color);
        font-weight: 600;
        border-bottom: 2px solid rgba(67, 97, 238, 0.1);
        padding-bottom: 0.75rem;
        margin-bottom: 1rem;
    }

    .text-muted {
        color: #6c757d !important;
    }
</style>

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h4 font-weight-bold mb-0" style="color: var(--dark-color);">
                            Blog Details
                        </h2>
                        <p class="text-muted mb-0">View and manage blog post details</p>
                    </div>
                    <div>
                        <span
                            class="status-badge 
                        @if ($blog->status == 'published') bg-success
                        @elseif($blog->status == 'draft') bg-warning
                        @else bg-secondary @endif text-white">
                            <i
                                class="fas @if ($blog->status == 'published') fa-check-circle 
                            @elseif($blog->status == 'draft') fa-edit 
                            @else fa-archive @endif me-1"></i>
                            {{ ucfirst($blog->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">{{ $blog->title }}</h3>
                        <div>
                            <span class="stats-badge bg-light text-dark me-2">
                                <i class="fas fa-eye me-1"></i> 1.2k views
                            </span>
                            <span class="stats-badge bg-light text-dark">
                                <i class="fas fa-comment me-1"></i> 24 comments
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Featured Image -->
                        @if ($blog->featured_image)
                            <div class="featured-image-container">
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-dark bg-opacity-75 px-3 py-2">
                                        <i class="fas fa-image me-1"></i> Featured Image
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Excerpt -->
                        <div class="content-section">
                            <h5><i class="fas fa-quote-left me-2"></i>Excerpt</h5>
                            <p class="lead text-muted mb-0">{{ $blog->excerpt }}</p>
                        </div>

                        <!-- Content -->
                        <div class="content-section">
                            <h5><i class="fas fa-align-left me-2"></i>Content</h5>
                            <div class="blog-content mt-3">
                                {!! $blog->content !!}
                            </div>
                        </div>

                        <!-- Blog Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-card">
                                    <h5><i class="fas fa-info-circle me-2"></i>Blog Details</h5>

                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="info-content">
                                            <h6>Author</h6>
                                            <p>{{ $blog->user->name }}</p>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-folder"></i>
                                        </div>
                                        <div class="info-content">
                                            <h6>Category</h6>
                                            <p>{{ $blog->category->name ?? 'Uncategorized' }}</p>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-calendar-plus"></i>
                                        </div>
                                        <div class="info-content">
                                            <h6>Created At</h6>
                                            <p>{{ $blog->created_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                        <div class="info-content">
                                            <h6>Last Updated</h6>
                                            <p>{{ $blog->updated_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-card">
                                    <h5><i class="fas fa-search me-2"></i>SEO Information</h5>

                                    @if ($blog->seo_fields)
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-heading"></i>
                                            </div>
                                            <div class="info-content">
                                                <h6>Meta Title</h6>
                                                <p>{{ $blog->seo_fields['meta_title'] ?? 'Not set' }}</p>
                                            </div>
                                        </div>

                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="info-content">
                                                <h6>Meta Description</h6>
                                                <p style="font-size: 15px; white-space: normal; word-break: break-word;">
                                                    {{ $blog->seo_fields['meta_description'] ?? 'Not set' }}
                                                </p>
                                            </div>

                                        </div>

                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-tags"></i>
                                            </div>
                                            <div class="info-content">
                                                <h6>Keywords</h6>
                                                @if (isset($blog->seo_fields['meta_keywords']) && is_array($blog->seo_fields['meta_keywords']))
                                                    <div class="seo-keywords">
                                                        @foreach ($blog->seo_fields['meta_keywords'] as $keyword)
                                                            <span class="keyword-badge">{{ $keyword }}</span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-muted mb-0">Not set</p>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                            <p class="text-muted mb-0">No SEO data available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-top-0 pt-0">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.blogs.index') }}" class="back-btn">
                                <i class="fas fa-arrow-left me-2"></i> Back to List
                            </a>
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="edit-btn">
                                <i class="fas fa-edit me-2"></i> Edit Blog
                            </a>
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
            $('.change-status-btn').click(function() {
                const blogId = $(this).data('blog-id');
                const status = $(this).data('status');
                const statusText = $(this).text().trim();

                Swal.fire({
                    title: 'Change Status?',
                    html: `Are you sure you want to <strong>${statusText}</strong> this blog post?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4361ee',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, change it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `${baseUrl}/admin/blogs/${blogId}/status`,
                            type: 'PATCH',
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: status
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Updating...',
                                    text: 'Please wait while we update the status',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                });
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Blog status has been updated',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update status. Please try again.',
                                    icon: 'error',
                                    confirmButtonColor: '#4361ee'
                                });
                            }
                        });
                    }
                });
            });

            // Add some interactive effects
            $('.card').hover(
                function() {
                    $(this).css('transform', 'translateY(-5px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );

            $('.btn').hover(
                function() {
                    $(this).css('transform', 'translateY(-2px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );
        });
    </script>
@endsection
