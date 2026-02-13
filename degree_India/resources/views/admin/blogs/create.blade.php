@extends('admin.layouts.master')

@section('title', 'Create Blogs')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
</style>

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    {{-- <div class="card-header">
                        <h3 class="card-title">Create New Blog</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div> --}}

                    <!-- Header Section -->
                    <div class="card-header card-header-gradient rounded-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="card-title mb-1">Create New Blog Article
                                </h3>
                                <small>
                                    Craft engaging content to educate and inspire students
                                </small>
                            </div>
                            <div>
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left mr-1"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Title -->
                                    <div class="form-group mt-3">
                                        <label for="title">Blog Title *</label>
                                        <input type="text" name="title" id="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" required>
                                        @error('title')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Excerpt -->
                                    <div class="form-group mt-3">
                                        <label for="excerpt">Short Excerpt</label>
                                        <textarea name="excerpt" id="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3">{{ old('excerpt') }}</textarea>
                                        <small class="text-muted">Brief summary of the blog (max 500 characters)</small>
                                        @error('excerpt')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Content -->
                                    <div class="form-group mt-3">
                                        <label for="content">Blog Content *</label>
                                        <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="15">{{ old('content') }}</textarea>
                                        @error('content')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Featured Image -->
                                    <div class="form-group mt-3">
                                        <label for="featured_image">Featured Image</label>
                                        <div class="custom-file">
                                            <input type="file" name="featured_image" id="featured_image"
                                                class="form-control custom-file-input @error('featured_image') is-invalid @enderror"
                                                accept="image/*">
                                        </div>
                                        @error('featured_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="image-preview mt-2 d-none">
                                            <img id="preview-image" class="img-fluid rounded" src="#" alt="Preview">
                                        </div>
                                    </div>

                                    <!-- Category -->
                                    <div class="form-group mt-3">
                                        <label for="category_id">Category</label>
                                        <select name="category_id" id="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- SEO Section -->
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h4 class="card-title">SEO Settings</h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- Meta Title -->
                                            <div class="form-group mt-3">
                                                <label for="meta_title">Meta Title</label>
                                                <input type="text" name="meta_title" id="meta_title"
                                                    class="form-control @error('meta_title') is-invalid @enderror"
                                                    value="{{ old('meta_title') }}">
                                                <small class="text-muted">Recommended: 50-60 characters</small>
                                                @error('meta_title')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Meta Description -->
                                            <div class="form-group mt-3">
                                                <label for="meta_description">Meta Description</label>
                                                <textarea name="meta_description" id="meta_description"
                                                    class="form-control @error('meta_description') is-invalid @enderror" rows="3">{{ old('meta_description') }}</textarea>
                                                <small class="text-muted">Recommended: 150-160 characters</small>
                                                @error('meta_description')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Meta Keywords -->
                                            <div class="form-group mt-3">
                                                <label for="meta_keywords">Meta Keywords</label>
                                                <input type="text" name="meta_keywords" id="meta_keywords"
                                                    class="form-control @error('meta_keywords') is-invalid @enderror"
                                                    value="{{ old('meta_keywords') }}">
                                                <small class="text-muted">Separate with commas (e.g., education, college,
                                                    career)</small>
                                                @error('meta_keywords')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save as Draft
                            </button>
                            <button type="submit" name="status" value="published" class="btn btn-success">
                                <i class="fas fa-check-circle"></i> Publish Now
                            </button>
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
    <!-- Include TinyMCE for rich text editor -->
    <script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: '#content',
            height: 500,
            menubar: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | \
                                                                                                                                                                                                       alignleft aligncenter alignright alignjustify | \
                                                                                                                                                                                                       bullist numlist outdent indent | removeformat | help'
        });

        // Image preview
        document.getElementById('featured_image').addEventListener('change', function(e) {
            const preview = document.getElementById('preview-image');
            const previewContainer = document.querySelector('.image-preview');

            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('d-none');
                }

                reader.readAsDataURL(this.files[0]);
            }
        });

        // Update file input label
        document.getElementById('featured_image').addEventListener('change', function(e) {
            const fileName = this.files[0]?.name || 'Choose file';
            this.nextElementSibling.textContent = fileName;
        });
    </script>
@endsection
