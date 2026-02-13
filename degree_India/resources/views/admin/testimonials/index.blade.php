@extends('admin.layouts.master')

@section('title', 'Testimonials Management')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
<style>
    .drag-handle {
        cursor: move;
        display: inline-flex;
        align-items: center;
    }

    .drag-handle:hover {
        color: #0d6efd;
    }

    .testimonial-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 14px;
    }

    .status-badge {
        width: 80px;
    }

    .img-thumbnail {
        transition: transform 0.2s;
    }

    .img-thumbnail:hover {
        transform: scale(1.1);
    }

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
                    <h5 class="mb-0"><i class="fas fa-quote-right me-2"></i>Testimonials Management</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addTestimonialModal">
                        <i class="fas fa-plus me-1"></i> Add New Testimonial
                    </button>
                </div>
                <div class="card-body" style="padding: 20px;">
                    <div class="table-responsive">
                        <table class="table table-hover" id="testimonialsTable">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Image</th>
                                    <th>Testimonial</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($testimonials as $testimonial)
                                    <tr data-id="{{ $testimonial->id }}">
                                        <td>
                                            <div class="drag-handle">
                                                <i class="fas fa-bars"></i>
                                                <span class="ms-2">{{ $testimonial->order }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($testimonial->image && Storage::disk('public')->exists($testimonial->image))
                                                <img src="{{ asset('storage/' . $testimonial->image) }}"
                                                    alt="{{ $testimonial->name }}"
                                                    class="testimonial-image img-thumbnail view-image"
                                                    data-src="{{ asset('storage/' . $testimonial->image) }}"
                                                    data-title="{{ $testimonial->name }}">
                                            @else
                                                <div
                                                    class="testimonial-image d-flex align-items-center justify-content-center bg-light">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            <strong class="d-block">{{ $testimonial->title }}</strong>
                                            @if ($testimonial->subtitle)
                                                <div class="text-muted small mb-1">
                                                    {{ Str::limit($testimonial->subtitle, 50) }}</div>
                                            @endif
                                            <div class="small">{{ Str::limit($testimonial->description, 80) }}</div>
                                        </td>

                                        <td>
                                            <div class="status-badge">
                                                @if ($testimonial->status)
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
                                                    data-id="{{ $testimonial->id }}"
                                                    {{ $testimonial->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button class="btn btn-outline-warning edit-testimonial"
                                                    data-id="{{ $testimonial->id }}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger delete-testimonial"
                                                    data-id="{{ $testimonial->id }}" title="Delete">
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

    <!-- Add Testimonial Modal -->
    <div class="modal fade" id="addTestimonialModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <div class="modal-title"><i class="fas fa-plus-circle me-2"></i>Add New Testimonial</div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addTestimonialForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12 mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required
                                    placeholder="Enter testimonial title">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="subtitle" class="form-label">Subtitle</label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle"
                                    placeholder="Enter subtitle">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" required
                                    placeholder="Enter testimonial description"></textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*">
                                <div class="form-text">Max 2MB, JPG, PNG, GIF, SVG, WEBP formats</div>
                                <div class="mt-2" id="imagePreview"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="addTestimonialBtn">
                            <i class="fas fa-save me-1"></i>
                            <span>Add Testimonial</span>
                            <span class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Testimonial Modal -->
    <div class="modal fade" id="editTestimonialModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <div class="modal-title"><i class="fas fa-edit me-2"></i>Edit Testimonial</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTestimonialForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_testimonial_id" name="id">
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12 mb-3">
                                <label for="edit_title" class="form-label">Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="edit_subtitle" class="form-label">Subtitle</label>
                                <input type="text" class="form-control" id="edit_subtitle" name="subtitle">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="edit_description" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_description" name="description" rows="4" required></textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="edit_image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="edit_image" name="image"
                                    accept="image/*">
                                <div class="form-text">Leave empty to keep current image</div>
                                <div class="mt-3">
                                    <p class="mb-1"><strong>Current Image:</strong></p>
                                    <img id="current_image_preview" src="" alt="Current Image"
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;"
                                        class="img-thumbnail mb-2">
                                    <div id="new_image_preview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary text-white" id="editTestimonialBtn">
                            <i class="fas fa-sync-alt me-1"></i>
                            <span>Update Testimonial</span>
                            <span class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image View Modal -->
    <div class="modal fade" id="imageViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <div class="modal-title" id="imageModalTitle"></div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid rounded-circle"
                        style="max-width: 300px;">
                </div>
                <div class="modal-footer">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script>
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {

            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            // Display error message from session if exists
            @if (session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            $('#testimonialsTable').DataTable({
                "pageLength": 5,
                "ordering": true,
                "info": true,
                "paging": true,
                "searching": false,
                "language": {
                    "emptyTable": "No colleges available"
                }
            });

            // Initialize rating star
            $("#rating").rateYo({
                rating: 5,
                starWidth: "25px",
                fullStar: true,
                onSet: function(rating, rateYoInstance) {
                    $("#rating_input").val(rating);
                }
            });

            $("#edit_rating").rateYo({
                rating: 5,
                starWidth: "25px",
                fullStar: true,
                onSet: function(rating, rateYoInstance) {
                    $("#edit_rating_input").val(rating);
                }
            });

            // Make rows sortable
            $('#testimonialsTable tbody').sortable({
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
                    $('#testimonialsTable tbody tr').each(function(index) {
                        orders.push({
                            id: $(this).data('id'),
                            order: index + 1
                        });
                    });


                }
            });

            // View Image
            $(document).on('click', '.view-image', function() {
                const imageSrc = $(this).data('src');
                const imageTitle = $(this).data('title') || 'Testimonial Image';

                $('#modalImage').attr('src', imageSrc);
                $('#imageModalTitle').html('<i class="fas fa-user me-2"></i>' + imageTitle);
                $('#imageViewModal').modal('show');
            });

            // Image preview for add form
            $('#image').change(function() {
                previewImage(this, '#imagePreview');
            });

            // Image preview for edit form
            $('#edit_image').change(function() {
                previewImage(this, '#new_image_preview');
            });

            function previewImage(input, previewSelector) {
                const file = input.files[0];
                if (file) {
                    // Check file size
                    if (file.size > 2097152) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: 'File size must be less than 2MB',
                            toast: true,
                            position: 'top-end',
                            timer: 3000
                        });
                        $(input).val('');
                        $(previewSelector).empty();
                        return;
                    }

                    // Check file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File Type',
                            text: 'Please upload valid image format',
                            toast: true,
                            position: 'top-end',
                            timer: 3000
                        });
                        $(input).val('');
                        $(previewSelector).empty();
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $(previewSelector).html(`
                            <div class="alert alert-info p-2 mb-2 small">
                                <i class="fas fa-info-circle me-2"></i>Image Preview
                            </div>
                            <img src="${e.target.result}" alt="Preview" 
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;"
                                 class="img-thumbnail">
                        `);
                    }
                    reader.readAsDataURL(file);
                }
            }

            // Add Testimonial
            $('#addTestimonialForm').submit(function(e) {
                e.preventDefault();
                const btn = $('#addTestimonialBtn');
                btn.prop('disabled', true);
                btn.find('.spinner-border').removeClass('d-none');

                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('admin.testimonials.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#addTestimonialModal').modal('hide');
                            $('#addTestimonialForm')[0].reset();
                            $('#imagePreview').empty();
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('Something went wrong!');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        btn.find('.spinner-border').addClass('d-none');
                    }
                });
            });

            // Edit Testimonial - Get Data
            $(document).on('click', '.edit-testimonial', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: `${baseUrl}/admin/testimonials/${id}/edit`,
                    type: 'GET',
                    success: function(response) {
                        $('#edit_testimonial_id').val(response.id);
                        $('#edit_name').val(response.name);
                        $('#edit_designation').val(response.designation || '');
                        $('#edit_company').val(response.company || '');
                        $('#edit_title').val(response.title);
                        $('#edit_subtitle').val(response.subtitle || '');
                        $('#edit_description').val(response.description);

                        // Set rating
                        $("#edit_rating").rateYo("rating", response.rating);
                        $("#edit_rating_input").val(response.rating);

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
                        $('#editTestimonialModal').modal('show');
                    },
                    error: function() {
                        toastr.error('Failed to load testimonial data');
                    }
                });
            });

            // Update Testimonial
            $('#editTestimonialForm').submit(function(e) {
                e.preventDefault();
                const id = $('#edit_testimonial_id').val();
                const btn = $('#editTestimonialBtn');
                btn.prop('disabled', true);
                btn.find('.spinner-border').removeClass('d-none');

                let formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: `${baseUrl}/admin/testimonials/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#editTestimonialModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('Something went wrong!');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        btn.find('.spinner-border').addClass('d-none');
                    }
                });
            });

            // Delete Testimonial
            $(document).on('click', '.delete-testimonial', function() {
                const id = $(this).data('id');
                const $row = $(this).closest('tr');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `${baseUrl}/admin/testimonials/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    table.row($row).remove().draw();
                                }
                            },
                            error: function() {
                                toastr.error('Something went wrong!');
                            }
                        });
                    }
                });
            });

            // Status Toggle
            $(document).on('change', '.status-toggle', function() {
                const id = $(this).data('id');
                const status = $(this).is(':checked') ? 1 : 0;
                const $badge = $(this).closest('td').find('.status-badge .badge');

                $.ajax({
                    url: `${baseUrl}/admin/testimonials/${id}/status`,
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
                            toastr.success(response.message);
                        }
                    },
                    error: function() {
                        $(this).prop('checked', !status);
                        toastr.error('Failed to update status');
                    }
                });
            });

            // Reset modals
            $('#addTestimonialModal').on('hidden.bs.modal', function() {
                $('#addTestimonialForm')[0].reset();
                $('#imagePreview').empty();
                $("#rating").rateYo("rating", 5);
                $("#rating_input").val(5);
            });

            $('#editTestimonialModal').on('hidden.bs.modal', function() {
                $('#current_image_preview').hide();
                $('#new_image_preview').empty();
            });
        });
    </script>
@endsection
