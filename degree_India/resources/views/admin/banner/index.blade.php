@extends('admin.layouts.master')

@section('title', 'Banner Management')


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
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

    .drag-handle {
        cursor: move;
        display: inline-flex;
        align-items: center;
    }

    .drag-handle:hover {
        color: #0d6efd;
    }

    .table tbody tr {
        cursor: pointer;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        transition: transform 0.2s;
    }

    .img-thumbnail:hover {
        transform: scale(1.1);
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }

    .status-badge {
        width: 80px;
    }

    .image-modal {
        max-width: 90vw;
    }

    .image-modal .modal-body img {
        width: 100%;
        height: auto;
        max-height: 80vh;
        object-fit: contain;
    }
</style>


@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-images me-2"></i>Banner Management</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBannerModal">
                        <i class="fas fa-plus me-1"></i> Add New Banner
                    </button>
                </div>
                <div class="card-body" style="padding: 20px;">
                    <!-- Banner List with DataTable -->
                    <div class="table-responsive">
                        <table class="table table-hover" id="bannersTable">
                            <thead>
                                <tr>
                                    <th width="50">Order</th>
                                    <th width="80">Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Button</th>
                                    <th width="100">Status</th>
                                    <th width="120" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banners as $banner)
                                    <tr data-id="{{ $banner->id }}">
                                        <td>
                                            <div class="drag-handle">
                                                <span class="ms-2">{{ $banner->order }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($banner->image && Storage::disk('public')->exists($banner->image))
                                                <img src="{{ asset('storage/' . $banner->image) }}"
                                                    alt="{{ $banner->title }}"
                                                    style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;"
                                                    class="img-thumbnail view-image"
                                                    data-src="{{ asset('storage/' . $banner->image) }}"
                                                    data-title="{{ $banner->title }}">
                                            @else
                                                <div class="img-thumbnail d-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 40px; background: #f8f9fa;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $banner->title ?? 'No Title' }}</strong>
                                            @if ($banner->title)
                                                <small class="text-muted d-block">ID: {{ $banner->id }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($banner->description)
                                                <div class="small">{{ Str::limit($banner->description, 50) }}</div>
                                            @else
                                                <span class="text-muted small">No description</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($banner->button_text)
                                                <span class="badge bg-info">{{ $banner->button_text }}</span>
                                                @if ($banner->button_link)
                                                    <small class="d-block text-truncate" style="max-width: 150px;">
                                                        <a href="{{ $banner->button_link }}" target="_blank"
                                                            class="text-decoration-none">
                                                            {{ Str::limit($banner->button_link, 25) }}
                                                        </a>
                                                    </small>
                                                @endif
                                            @else
                                                <span class="text-muted small">No button</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="status-badge">
                                                @if ($banner->status)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i> Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times-circle me-1"></i> Inactive
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-check form-switch mt-1">
                                                <input type="checkbox" class="form-check-input status-toggle"
                                                    data-id="{{ $banner->id }}" {{ $banner->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button class="btn btn-outline-primary edit-banner"
                                                    data-id="{{ $banner->id }}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger delete-banner"
                                                    data-id="{{ $banner->id }}" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
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

    <!-- Add Banner Modal -->
    <div class="modal fade" id="addBannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <div class="modal-title"><i class="fas fa-plus-circle me-2"></i>Add New Banner</div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addBannerForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Title <span
                                        class="text-muted">(Optional)</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Enter banner title">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*" required>
                                <div class="form-text">Max 2MB, JPG, PNG, GIF, SVG, JFIF, WEBP formats</div>
                                <div class="mt-2" id="imagePreview"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">Description <span
                                        class="text-muted">(Optional)</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                    placeholder="Enter banner description"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="button_text" class="form-label">Button Text <span
                                        class="text-muted">(Optional)</span></label>
                                <input type="text" class="form-control" id="button_text" name="button_text"
                                    placeholder="e.g., Learn More, Shop Now, Read More">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="button_link" class="form-label">Button Link <span
                                        class="text-muted">(Optional)</span></label>
                                <input type="url" class="form-control" id="button_link" name="button_link"
                                    placeholder="https://example.com">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="addBannerBtn">
                            <i class="fas fa-save me-1"></i>
                            <span>Add Banner</span>
                            <span class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Banner Modal -->
    <div class="modal fade" id="editBannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <div class="modal-title "><i class="fas fa-edit me-2"></i>Edit Banner</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editBannerForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_banner_id" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_title" class="form-label">Title <span
                                        class="text-muted">(Optional)</span></label>
                                <input type="text" class="form-control" id="edit_title" name="title"
                                    placeholder="Enter banner title">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_image" class="form-label">Image <span
                                        class="text-muted">(Optional)</span></label>
                                <input type="file" class="form-control" id="edit_image" name="image"
                                    accept="image/*">
                                <div class="form-text">Leave empty to keep current image</div>
                                <div class="mt-3">
                                    <p class="mb-1"><strong>Current Image:</strong></p>
                                    <img id="current_image_preview" src="" alt="Current Image"
                                        style="max-width: 200px; max-height: 100px; object-fit: cover; border-radius: 4px;"
                                        class="img-thumbnail mb-2">
                                    <div id="new_image_preview" class="mt-2"></div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="edit_description" class="form-label">Description <span
                                        class="text-muted">(Optional)</span></label>
                                <textarea class="form-control" id="edit_description" name="description" rows="3"
                                    placeholder="Enter banner description"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_button_text" class="form-label">Button Text <span
                                        class="text-muted">(Optional)</span></label>
                                <input type="text" class="form-control" id="edit_button_text" name="button_text"
                                    placeholder="e.g., Learn More">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_button_link" class="form-label">Button Link <span
                                        class="text-muted">(Optional)</span></label>
                                <input type="url" class="form-control" id="edit_button_link" name="button_link"
                                    placeholder="https://example.com">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary text-white" id="editBannerBtn">
                            <i class="fas fa-sync-alt me-1"></i>
                            <span>Update Banner</span>
                            <span class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image View Modal -->
    <div class="modal fade" id="imageViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <div class="modal-title" id="imageModalTitle" style="font-size: 15px;"></div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <a href="#" id="downloadImage" class="btn btn-primary">
                        <i class="fas fa-download me-1"></i> Download
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <script>
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#bannersTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "order": [
                    [0, 'asc']
                ],
                "columnDefs": [{
                        "orderable": true,
                        "targets": [0]
                    },
                    {
                        "orderable": false,
                        "targets": [1, 5, 6]
                    }
                ],
                "language": {
                    "search": '<i class="fas fa-search me-1"></i> Search:',
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries available",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "paginate": {
                        "first": '<i class="fas fa-angle-double-left"></i>',
                        "last": '<i class="fas fa-angle-double-right"></i>',
                        "next": '<i class="fas fa-angle-right"></i>',
                        "previous": '<i class="fas fa-angle-left"></i>'
                    }
                }
            });

            // Make rows sortable
            $('#bannersTable tbody').sortable({
                handle: ".drag-handle",
                cursor: "move",
                helper: function(e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function(index) {
                        $(this).width($originals.eq(index).width());
                    });
                    return $helper;
                },
                update: function(event, ui) {
                    var orders = [];
                    $('#bannersTable tbody tr').each(function(index) {
                        orders.push({
                            id: $(this).data('id'),
                            order: index + 1
                        });
                    });

                    $.ajax({
                        url: '{{ route('admin.banners.order') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            orders: orders
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                // Update order numbers in table
                                $('#bannersTable tbody tr').each(function(index) {
                                    $(this).find('.drag-handle span').text(index +
                                        1);
                                });
                            }
                        },
                        error: function() {
                            toastr.error('Failed to update order');
                            location.reload();
                        }
                    });
                }
            });

            // View Image in Modal
            $(document).on('click', '.view-image', function() {
                const imageSrc = $(this).data('src');
                const imageTitle = $(this).data('title') || 'Banner Image';

                $('#modalImage').attr('src', imageSrc);
                $('#imageModalTitle').html('<i class="fas fa-image me-2"></i>' + imageTitle);
                $('#downloadImage').attr('href', imageSrc).attr('download', 'banner-' + Date.now() +
                    '.jpg');
                $('#imageViewModal').modal('show');
            });

            // Image preview for add form
            $('#image').change(function() {
                const file = this.files[0];
                if (file) {
                    // Check file size (2MB = 2097152 bytes)
                    if (file.size > 2097152) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: 'File size must be less than 2MB',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        $(this).val('');
                        $('#imagePreview').empty();
                        return;
                    }

                    // Check file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml',
                        'image/jfif', 'image/webp'
                    ];
                    if (!validTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File Type',
                            text: 'Please upload JPG, PNG, GIF, SVG, JFIF or WEBP image.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        $(this).val('');
                        $('#imagePreview').empty();
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').html(`
                            <div class="alert alert-info p-2 mb-2">
                                <i class="fas fa-info-circle me-2"></i>Image Preview
                            </div>
                            <img src="${e.target.result}" alt="Preview" 
                                 style="max-width: 100%; max-height: 200px; border-radius: 8px;"
                                 class="img-thumbnail">
                        `);
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Image preview for edit form
            $('#edit_image').change(function() {
                const file = this.files[0];
                if (file) {
                    // Check file size (2MB = 2097152 bytes)
                    if (file.size > 2097152) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: 'File size must be less than 2MB',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        $(this).val('');
                        $('#new_image_preview').empty();
                        return;
                    }

                    // Check file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml',
                        'image/jfif', 'image/webp'
                    ];
                    if (!validTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File Type',
                            text: 'Please upload JPG, PNG, GIF, SVG, JFIF or WEBP image.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        $(this).val('');
                        $('#new_image_preview').empty();
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#new_image_preview').html(`
                            <div class="alert alert-warning p-2 mb-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>New Image Preview (Will replace current)
                            </div>
                            <img src="${e.target.result}" alt="New Preview" 
                                 style="max-width: 200px; max-height: 100px; border-radius: 4px;"
                                 class="img-thumbnail">
                        `);
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#new_image_preview').empty();
                }
            });

            // Add Banner
            $('#addBannerForm').submit(function(e) {
                e.preventDefault();
                const btn = $('#addBannerBtn');
                btn.prop('disabled', true);
                btn.find('.spinner-border').removeClass('d-none');

                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('admin.banners.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#addBannerModal').modal('hide');
                            $('#addBannerForm')[0].reset();
                            $('#imagePreview').empty();
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul class="mb-0">';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                            errorHtml += '</ul>';

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: errorHtml,
                                showConfirmButton: true
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong!',
                                showConfirmButton: true
                            });
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        btn.find('.spinner-border').addClass('d-none');
                    }
                });
            });

            // Edit Banner - Get Data
            $(document).on('click', '.edit-banner', function() {
                const id = $(this).data('id');
                const row = $(this).closest('tr');

                // Show loading
                $('#editBannerBtn').prop('disabled', true).find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: `${baseUrl}/admin/banners/${id}/edit`,
                    type: 'GET',
                    success: function(response) {
                        $('#edit_banner_id').val(response.id);
                        $('#edit_title').val(response.title || '');
                        $('#edit_description').val(response.description || '');
                        $('#edit_button_text').val(response.button_text || '');
                        $('#edit_button_link').val(response.button_link || '');

                        // Show current image
                        if (response.image) {
                            const imageUrl = '/storage/' + response.image;
                            $('#current_image_preview')
                                .attr('src', imageUrl)
                                .show();
                        } else {
                            $('#current_image_preview').hide();
                        }

                        $('#new_image_preview').empty();
                        $('#editBannerModal').modal('show');
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load banner data',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    },
                    complete: function() {
                        $('#editBannerBtn').prop('disabled', false).find('.spinner-border')
                            .addClass('d-none');
                    }
                });
            });

            // Update Banner
            $('#editBannerForm').submit(function(e) {
                e.preventDefault();
                const id = $('#edit_banner_id').val();
                const btn = $('#editBannerBtn');
                btn.prop('disabled', true);
                btn.find('.spinner-border').removeClass('d-none');

                let formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: `${baseUrl}/admin/banners/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#editBannerModal').modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul class="mb-0">';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                            errorHtml += '</ul>';

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: errorHtml,
                                showConfirmButton: true
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong!',
                                showConfirmButton: true
                            });
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        btn.find('.spinner-border').addClass('d-none');
                    }
                });
            });

            // Delete Banner
            $(document).on('click', '.delete-banner', function() {
                const id = $(this).data('id');
                const $row = $(this).closest('tr');
                const title = $row.find('td:eq(2) strong').text();

                Swal.fire({
                    title: 'Delete Banner?',
                    html: `<p>Are you sure you want to delete <strong>${title || 'this banner'}</strong>?</p>
                           <p class="text-danger">This action cannot be undone.</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '<i class="fas fa-trash me-1"></i> Yes, delete it!',
                    cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return $.ajax({
                            url: `${baseUrl}/admin/banners/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            }
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const response = result.value;
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            table.row($row).remove().draw();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete banner',
                                showConfirmButton: true
                            });
                        }
                    }
                });
            });

            // Status Toggle
            $(document).on('change', '.status-toggle', function() {
                const id = $(this).data('id');
                const status = $(this).is(':checked') ? 1 : 0;
                const $badge = $(this).closest('td').find('.status-badge .badge');
                const $icon = $badge.find('i');

                $.ajax({
                    url: `${baseUrl}/admin/banners/${id}/status`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            if (status) {
                                $badge.removeClass('bg-danger').addClass('bg-success')
                                    .html('<i class="fas fa-check-circle me-1"></i> Active');
                            } else {
                                $badge.removeClass('bg-success').addClass('bg-danger')
                                    .html('<i class="fas fa-times-circle me-1"></i> Inactive');
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated',
                                text: response.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    },
                    error: function() {
                        $(this).prop('checked', !status);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update status',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
            });

            // Reset add modal on close
            $('#addBannerModal').on('hidden.bs.modal', function() {
                $('#addBannerForm')[0].reset();
                $('#imagePreview').empty();
            });

            // Reset edit modal on close
            $('#editBannerModal').on('hidden.bs.modal', function() {
                $('#editBannerForm')[0].reset();
                $('#current_image_preview').hide();
                $('#new_image_preview').empty();
            });

            // Improve table row hover
            $('#bannersTable tbody tr').on('mouseenter', function() {
                $(this).addClass('table-active');
            }).on('mouseleave', function() {
                $(this).removeClass('table-active');
            });
        });
    </script>
@endsection
