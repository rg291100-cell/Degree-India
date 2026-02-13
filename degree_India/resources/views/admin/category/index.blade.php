@extends('admin.layouts.master')

@section('title', 'Categories Management')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css"
    rel="stylesheet">
<style>
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-group .dropdown-menu {
        min-width: 120px;
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

    .category-icon {
        font-size: 1.2rem;
        margin-right: 8px;
        display: inline-block;
    }

    .color-preview {
        width: 24px;
        height: 24px;
        border-radius: 4px;
        display: inline-block;
        margin-right: 8px;
        border: 1px solid #dee2e6;
    }

    .input-group-text .color-preview {
        width: 20px;
        height: 20px;
        margin-right: 0;
    }

    .color-picker-input {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }
</style>

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Categories List</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#categoryModal" id="addCategoryBtn">
                            <i class="fas fa-plus"></i> Add New Category
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="categoryTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Icon</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr id="category-{{ $category->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($category->icon)
                                                    <div class="d-flex align-items-center">

                                                        <i class="{{ $category->icon }} category-icon"
                                                            @if ($category->color) style="color: {{ $category->color }}" @endif></i>
                                                    </div>
                                                @else
                                                    <span class="text-muted">No Icon</span>
                                                @endif
                                            </td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>{{ Str::limit($category->description, 50) }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $category->status == 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($category->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $category->order }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info edit-btn" data-id="{{ $category->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn"
                                                    data-id="{{ $category->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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

    <!-- Add/Edit Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoryForm">
                    <div class="modal-body">
                        <input type="hidden" id="categoryId" name="id">

                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon (Font Awesome class)</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <div id="iconPreview"></div>
                                </span>
                                <input type="text" class="form-control" id="icon" name="icon"
                                    placeholder="fas fa-home or fab fa-facebook" oninput="updateIconPreview()">
                            </div>
                            <small class="text-muted">Enter Font Awesome icon class (e.g., fas fa-home)</small>
                            <div class="text-danger" id="iconError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="color" class="form-label">Icon Color</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <div id="colorPreview" class="color-preview"></div>
                                </span>
                                <input type="text" class="form-control color-picker-input" id="color" name="color"
                                    placeholder="#000000 or red" value="#007bff">
                            </div>
                            <small class="text-muted">Enter color name (red, blue) or hex code (#FF0000)</small>
                            <div class="text-danger" id="colorError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="text-danger" id="nameError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            <div class="text-danger" id="descriptionError"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_status" class="form-label">Status *</label>
                                    <select class="form-select" id="category_status" name="status" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <div class="text-danger" id="category_statusError"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Order</label>
                                    <input type="number" class="form-control" id="order" name="order"
                                        value="0" min="0">
                                    <div class="text-danger" id="orderError"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js">
    </script>
    <script>
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {
            // Initialize DataTable
            $('#categoryTable').DataTable({
                "pageLength": 5,
                "order": [
                    [6, 'asc']
                ],
                "language": {
                    "search": "Search categories:",
                    "lengthMenu": "Show _MENU_ categories",
                    "info": "Showing _START_ to _END_ of _TOTAL_ categories",
                    "paginate": {
                        "previous": "‹",
                        "next": "›"
                    }
                }
            });

            // Initialize color picker
            $('#color').colorpicker({
                format: 'hex',
                useAlpha: false
            }).on('changeColor', function(e) {
                updateIconPreview();
            });

            // Function to update icon preview
            window.updateIconPreview = function() {
                let iconClass = $('#icon').val();
                let color = $('#color').val();
                let iconPreview = $('#iconPreview');
                let colorPreview = $('#colorPreview');

                // Update color preview
                if (color) {
                    colorPreview.css('background-color', color);
                } else {
                    colorPreview.css('background-color', '#007bff');
                }

                // Update icon preview
                if (iconClass) {
                    iconPreview.html('<i class="' + iconClass + '" style="font-size: 1.2rem; color: ' + (
                        color || '#007bff') + '"></i>');
                } else {
                    iconPreview.html('<span class="text-muted">No icon</span>');
                }
            }

            // Reset form and open modal for adding new category
            $('#addCategoryBtn').click(function() {
                $('#categoryForm')[0].reset();
                $('#categoryId').val('');
                $('#modalTitle').text('Add New Category');
                $('#saveBtn').text('Save Category');
                $('#category_status').val('active');
                $('#order').val('0');
                $('#color').val('#007bff');
                $('#color').colorpicker('setValue', '#007bff');
                $('#iconPreview').html('');
                $('#colorPreview').css('background-color', '#007bff');
                clearErrors();
            });

            // Edit category
            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();
                let categoryId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.categories.show', ':id') }}".replace(':id', categoryId),
                    type: 'GET',
                    success: function(response) {
                        $('#categoryId').val(response.id);
                        $('#name').val(response.name);
                        $('#description').val(response.description);
                        $('#category_status').val(response.status);
                        $('#order').val(response.order);
                        $('#icon').val(response.icon);
                        $('#color').val(response.color || '#007bff');
                        $('#color').colorpicker('setValue', response.color || '#007bff');

                        // Update previews
                        updateIconPreview();

                        $('#modalTitle').text('Edit Category');
                        $('#saveBtn').text('Update Category');

                        let modal = new bootstrap.Modal(document.getElementById(
                            'categoryModal'));
                        modal.show();
                        clearErrors();
                    },
                    error: function(xhr) {
                        showToast('Error loading category data', 'error');
                    }
                });
            });

            // Save/Update category
            $('#categoryForm').submit(function(e) {
                e.preventDefault();

                let categoryId = $('#categoryId').val();
                let url = categoryId ?
                    "{{ route('admin.categories.update', ':id') }}".replace(':id', categoryId) :
                    "{{ route('admin.categories.store') }}";

                let formData = $('#categoryForm').serialize();

                if (categoryId) {
                    formData += '&_method=PUT';
                }

                formData += '&_token={{ csrf_token() }}';

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            let modal = bootstrap.Modal.getInstance(document.getElementById(
                                'categoryModal'));
                            modal.hide();
                            showToast(response.message, 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 1200);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            clearErrors();
                            $.each(errors, function(field, messages) {
                                let errorField = field === 'status' ?
                                    'category_status' : field;
                                $('#' + errorField + 'Error').text(messages[0]);
                            });
                        } else {
                            showToast("Something went wrong!", 'error');
                        }
                    }
                });
            });

            // Delete category
            let deleteId;
            $(document).on('click', '.delete-btn', function() {
                deleteId = $(this).data('id');
                let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                modal.show();
            });

            $('#confirmDelete').click(function() {
                $.ajax({
                    url: "{{ route('admin.categories.destroy', ':id') }}".replace(':id', deleteId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            let modal = bootstrap.Modal.getInstance(document.getElementById(
                                'deleteModal'));
                            modal.hide();
                            showToast(response.message, 'success');
                            $('#category-' + deleteId).fadeOut(300, function() {
                                $(this).remove();
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            });
                        }
                    },
                    error: function(xhr) {
                        showToast('Error deleting category', 'error');
                    }
                });
            });

            // Clear error messages
            function clearErrors() {
                $('.text-danger').text('');
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

            // Initialize preview on page load
            updateIconPreview();
        });
    </script>
@endsection
