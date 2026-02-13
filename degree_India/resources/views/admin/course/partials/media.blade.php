{{-- admin/course/partials/media.blade.php --}}
<div class="row">
    <div class="col-md-6">
        <!-- Thumbnail Image -->
        <div class="form-group mb-4">
            <label for="thumbnail_image" class="form-label">
                <i class="fas fa-image mr-1"></i> Thumbnail Image
                @empty($course)
                    *
                @endempty
            </label>

            <!-- For Edit Mode: Show current thumbnail -->
            @isset($course)
                @if ($course->thumbnail_image)
                    <div class="mb-3">
                        <p class="mb-1"><strong>Current Thumbnail:</strong></p>
                        <img src="{{ Storage::url($course->thumbnail_image) }}" class="img-thumbnail mb-2"
                            style="max-width: 200px; max-height: 150px; object-fit: cover;">
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="remove_thumbnail"
                                name="remove_thumbnail" value="1">
                            <label class="custom-control-label text-danger" for="remove_thumbnail">
                                Remove current thumbnail
                            </label>
                        </div>
                    </div>
                @endif
            @endisset

            <div class="custom-file">
                <input type="file"
                    class="form-control custom-file-input @error('thumbnail_image') is-invalid @enderror"
                    id="thumbnail_image" name="thumbnail_image" accept="image/*"
                    @empty($course) required @endisset>
                <label class="custom-file-label" for="thumbnail_image">
                    @isset($course)
                        @if ($course->thumbnail_image)
                            Replace thumbnail...
                        @else
                            Choose thumbnail...
                        @endif
                    @else
                        Choose thumbnail...
                    @endisset
                </label>
            </div>
            @error('thumbnail_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Recommended: 600x400px, JPG/PNG/WebP, Max 2MB
            </small>
            
            <!-- Thumbnail Preview -->
            <div id="thumbnailPreview" class="mt-2" style="display: none;">
                <p class="mb-1"><strong>New Preview:</strong></p>
                <img src="" class="img-thumbnail" style="max-width: 200px; max-height: 150px; object-fit: cover;">
            </div>
        </div>

        <!-- Banner Image -->
        <div class="form-group mb-4">
            <label for="banner_image" class="form-label">
                <i class="fas fa-image mr-1"></i> Banner Image
                @empty($course)
                    *
                @endempty
                    </label>

                <!-- For Edit Mode: Show current banner -->
                @isset($course)
                    @if ($course->banner_image)
                        <div class="mb-3">
                            <p class="mb-1"><strong>Current Banner:</strong></p>
                            <img src="{{ Storage::url($course->banner_image) }}" class="img-thumbnail mb-2"
                                style="max-width: 300px; max-height: 120px; object-fit: cover;">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="remove_banner" name="remove_banner"
                                    value="1">
                                <label class="custom-control-label text-danger" for="remove_banner">
                                    Remove current banner
                                </label>
                            </div>
                        </div>
                    @endif
                @endisset

                <div class="custom-file">
                    <input type="file"
                        class="form-control custom-file-input @error('banner_image') is-invalid @enderror"
                        id="banner_image" name="banner_image" accept="image/*"
                        @empty($course) required @endisset>
                <label class="custom-file-label" for="banner_image">
                    @isset($course)
                        @if ($course->banner_image)
                            Replace banner...
                        @else
                            Choose banner...
                        @endif
                    @else
                        Choose banner...
                    @endisset
                </label>
            </div>
            @error('banner_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Recommended: 1200x400px, JPG/PNG/WebP, Max 5MB
            </small>
            
            <!-- Banner Preview -->
            <div id="bannerPreview" class="mt-2" style="display: none;">
                <p class="mb-1"><strong>New Preview:</strong></p>
                <img src="" class="img-thumbnail" style="max-width: 300px; max-height: 120px; object-fit: cover;">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!-- Gallery Images -->
        <div class="form-group">
            <label for="gallery_images" class="form-label">
                <i class="fas fa-images mr-1"></i> Gallery Images
            </label>
            
            <!-- For Edit Mode: Show existing gallery images -->
           @isset($course)
                @if (!empty($course->gallery_images))
                    @php
                        $galleryImages = is_array($course->gallery_images)
                            ? $course->gallery_images
                            : json_decode($course->gallery_images, true);
                    @endphp

                    @if (count($galleryImages) > 0)
                        <div class="mb-3">
                            <p class="mb-1"><strong>Current Gallery Images:</strong></p>

                            <div class="row">
                                @foreach ($galleryImages as $index => $image)
                                    <div class="col-4 col-md-3 mb-2 position-relative">
                                        <img
                                            src="{{ Storage::url($image) }}"
                                            class="img-thumbnail"
                                            style="width: 100px; height: 100px; object-fit: cover;"
                                        >

                                        <input type="hidden" name="existing_gallery_images[]" value="{{ $image }}">

                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-existing-image"
                                            data-index="{{ $index }}"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <small class="text-muted">
                                {{ count($galleryImages) }} image(s) in gallery
                            </small>
                        </div>
                    @endif
                @endif
            @endisset

            
            <div class="custom-file">
            <input
                type="file"
                class="form-control custom-file-input"
                id="gallery_images"
                name="gallery_images[]"
                multiple
                accept="image/*"
            >

            <label class="custom-file-label" for="gallery_images">
                @isset($course)
                    @if (!empty($course->gallery_images))
                        @php
                            $existingGallery = is_array($course->gallery_images)
                                ? $course->gallery_images
                                : json_decode($course->gallery_images, true);
                        @endphp
                        @if (is_array($existingGallery) && count($existingGallery) > 0)
                            Add more images...
                        @else
                            Choose gallery images...
                        @endif
                    @else
                        Choose gallery images...
                    @endif
                @else
                    Choose gallery images...
                @endisset
            </label>
        </div>

            @error('gallery_images')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @error('gallery_images.*')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                You can select multiple images (Max 5 images, 5MB each)
            </small>

            <!-- New Gallery Images Preview -->
            <div id="galleryPreview" class="row mt-3"></div>
            
            <!-- Hidden field to track removed existing images -->
            <input type="hidden" id="removed_gallery_images" name="removed_gallery_images" value="">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // File input label update
        $('.custom-file-input').change(function(e) {
            var fileName = '';
            if (this.files && this.files.length > 1) {
                fileName = this.files.length + ' files selected';
            } else if (this.files && this.files[0]) {
                fileName = e.target.files[0].name;
            }
            $(this).next('.custom-file-label').html(fileName);
        });

        // Thumbnail image preview
        $('#thumbnail_image').change(function() {
            const input = $(this)[0];
            const preview = $('#thumbnailPreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.find('img').attr('src', e.target.result);
                    preview.show();
                };
                reader.readAsDataURL(input.files[0]);
                
                // Uncheck remove checkbox if user uploads new image
                $('#remove_thumbnail').prop('checked', false);
            } else {
                preview.hide();
            }
        });

        // Banner image preview
        $('#banner_image').change(function() {
            const input = $(this)[0];
            const preview = $('#bannerPreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.find('img').attr('src', e.target.result);
                    preview.show();
                };
                reader.readAsDataURL(input.files[0]);
                
                // Uncheck remove checkbox if user uploads new image
                $('#remove_banner').prop('checked', false);
            } else {
                preview.hide();
            }
        });

        // Gallery image preview
        $('#gallery_images').change(function() {
            const files = $(this)[0].files;
            const preview = $('#galleryPreview');
            preview.empty();

            if (files.length > 5) {
                alert('Maximum 5 images allowed');
                $(this).val('');
                return;
            }

            // Check total images (existing + new)
            const existingCount = $('input[name="existing_gallery_images[]"]').length;
            if (existingCount + files.length > 5) {
                alert(`Maximum 5 images total allowed. You have ${existingCount} existing images and trying to add ${files.length} more.`);
                $(this).val('');
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = (function(file, index) {
                    return function(e) {
                        preview.append(`
                            <div class="col-4 col-md-3 mb-2 position-relative">
                                <img src="${e.target.result}" 
                                     class="img-thumbnail" 
                                     style="width: 100px; height: 100px; object-fit: cover;">
                                <button type="button" 
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-new-image"
                                        data-index="${index}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `);
                    };
                })(files[i], i);
                reader.readAsDataURL(files[i]);
            }
        });

        // Remove new gallery image
        $(document).on('click', '.remove-new-image', function() {
            const index = $(this).data('index');
            const input = $('#gallery_images')[0];
            const dt = new DataTransfer();
            
            // Remove file from FileList
            for (let i = 0; i < input.files.length; i++) {
                if (i !== index) {
                    dt.items.add(input.files[i]);
                }
            }
            input.files = dt.files;
            
            // Remove preview
            $(this).closest('.col-4').remove();
            
            // Update file input label
            const fileName = input.files.length > 0 ? input.files.length + ' files selected' : 'Choose gallery images...';
            $('#gallery_images').next('.custom-file-label').html(fileName);
        });

        // Remove existing gallery image
        let removedImages = [];
        $(document).on('click', '.remove-existing-image', function() {
            const index = $(this).data('index');
            const imageDiv = $(this).closest('.col-4');
            const hiddenInput = imageDiv.find('input[name="existing_gallery_images[]"]');
            
            if (hiddenInput.length) {
                const imagePath = hiddenInput.val();
                removedImages.push(imagePath);
                $('#removed_gallery_images').val(JSON.stringify(removedImages));
            }
            
            imageDiv.fadeOut(300, function() {
                $(this).remove();
            });
        });

        // Remove thumbnail checkbox handler
        $('#remove_thumbnail').change(function() {
            if ($(this).is(':checked')) {
                $('#thumbnail_image').prop('required', true);
                $('#thumbnailPreview').hide();
                $('#thumbnail_image').val('');
                $('#thumbnail_image').next('.custom-file-label').html('Choose thumbnail...');
            } else {
                @empty($course)
                    $('#thumbnail_image').prop('required', true);
                @else
                    $('#thumbnail_image').prop('required', false);
                @endempty
                        } }); // Remove banner checkbox handler $('#remove_banner').change(function() { if
                        ($(this).is(':checked')) { $('#banner_image').prop('required', true);
                        $('#bannerPreview').hide(); $('#banner_image').val('');
                        $('#banner_image').next('.custom-file-label').html('Choose banner...'); } else {
                        @empty($course)
                    $('#banner_image').prop('required', true);
                @else
                    $('#banner_image').prop('required', false);
                @endempty
                        } }); }); </script>
