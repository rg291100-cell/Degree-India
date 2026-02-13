{{-- admin/course/partials/seo.blade.php --}}
<div class="row">
    <div class="col-12">
        <!-- Auto-generate SEO fields from title -->
        <div class="alert alert-info mb-4">
            <i class="fas fa-info-circle mr-1"></i>
            <strong>SEO Tip:</strong> Meta title and description will auto-generate from course title and short
            description. You can customize them below.
        </div>

        <div class="form-group mb-4">
            <label for="meta_title" class="form-label">
                <i class="fas fa-heading mr-1"></i> Meta Title
            </label>
            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title"
                name="meta_title" value="{{ old('meta_title', $course->meta_title ?? '') }}"
                placeholder="SEO title (50-60 characters)" maxlength="60">
            @error('meta_title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Recommended: 50-60 characters |
                <span id="metaTitleCount">0</span>/60 characters
            </small>
        </div>

        <div class="form-group mb-4">
            <label for="meta_description" class="form-label">
                <i class="fas fa-align-left mr-1"></i> Meta Description
            </label>
            <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                name="meta_description" rows="3" maxlength="160">{{ old('meta_description', $course->meta_description ?? '') }}</textarea>
            @error('meta_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Recommended: 150-160 characters |
                <span id="metaDescCount">0</span>/160 characters
            </small>
        </div>

        <div class="form-group mb-4">
            <label for="meta_keywords" class="form-label">
                <i class="fas fa-key mr-1"></i> Meta Keywords
            </label>
            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords"
                name="meta_keywords" value="{{ old('meta_keywords', $course->meta_keywords ?? '') }}"
                placeholder="course, training, education, learning">
            @error('meta_keywords')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Separate with commas |
                <span id="keywordCount">0</span> keywords
            </small>
        </div>


    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="course_status" class="form-label">
                <i class="fas fa-toggle-on mr-1"></i> Course Status *
            </label>
            <select class="form-control @error('course_status') is-invalid @enderror" id="course_status"
                name="course_status" required>
                <option value="draft"
                    {{ old('course_status', $course->course_status ?? 'draft') == 'draft' ? 'selected' : '' }}>
                    Draft
                </option>
                <option value="published"
                    {{ old('course_status', $course->course_status ?? '') == 'published' ? 'selected' : '' }}>
                    Published
                </option>
                <option value="archived"
                    {{ old('course_status', $course->course_status ?? '') == 'archived' ? 'selected' : '' }}>
                    Archived
                </option>
                <option value="coming_soon"
                    {{ old('course_status', $course->course_status ?? '') == 'coming_soon' ? 'selected' : '' }}>
                    Coming Soon
                </option>
            </select>
            @error('course_status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="order" class="form-label">
                <i class="fas fa-sort-numeric-down mr-1"></i> Display Order
            </label>
            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order"
                name="order" value="{{ old('order', $course->order ?? 0) }}" min="0" step="1">
            @error('order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Lower number displays first (default: 0)
            </small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label d-block">
                <i class="fas fa-star mr-1"></i> Course Settings
            </label>

            <!-- Featured Course -->
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" class="custom-control-input" id="featured" name="featured" value="1"
                    {{ old('featured', $course->featured ?? 0) ? 'checked' : '' }}>
                <label class="custom-control-label" for="featured">
                    Mark as Featured Course
                </label>
            </div>
            @error('featured')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            <!-- Allow Reviews -->
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" class="custom-control-input" id="allow_reviews" name="allow_reviews"
                    value="1" {{ old('allow_reviews', $course->allow_reviews ?? 1) ? 'checked' : '' }}>
                <label class="custom-control-label" for="allow_reviews">
                    Allow Ratings & Reviews
                </label>
            </div>
            @error('allow_reviews')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            <!-- Enrollments Open -->
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="enrollments_open" name="enrollments_open"
                    value="1" {{ old('enrollments_open', $course->enrollments_open ?? 1) ? 'checked' : '' }}>
                <label class="custom-control-label" for="enrollments_open">
                    Enrollments Open
                </label>
            </div>
            @error('enrollments_open')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        // Auto-generate meta title from course title
        $('#title').on('blur', function() {
            const metaTitle = $('#meta_title');
            if (!metaTitle.val() || metaTitle.data('user-changed') !== true) {
                const title = $(this).val();
                // Limit to 60 characters
                const metaTitleText = title.substring(0, 60);
                metaTitle.val(metaTitleText);
                updateMetaTitleCount();
            }
        });

        // Auto-generate meta description from short description
        $('#short_description').on('blur', function() {
            const metaDesc = $('#meta_description');
            if (!metaDesc.val() || metaDesc.data('user-changed') !== true) {
                const desc = $(this).val();
                // Limit to 160 characters
                const metaDescText = desc.substring(0, 160);
                metaDesc.val(metaDescText);
                updateMetaDescCount();
            }
        });

        // Mark meta fields as manually edited
        $('#meta_title').on('input', function() {
            $(this).data('user-changed', true);
            updateMetaTitleCount();
        });

        $('#meta_description').on('input', function() {
            $(this).data('user-changed', true);
            updateMetaDescCount();
        });

        $('#meta_keywords').on('input', function() {
            updateKeywordCount();
        });

        // Character counters
        function updateMetaTitleCount() {
            const text = $('#meta_title').val();
            const count = text.length;
            $('#metaTitleCount').text(count);

            // Add warning class if over 60
            if (count > 60) {
                $('#metaTitleCount').addClass('text-danger');
            } else {
                $('#metaTitleCount').removeClass('text-danger');
            }
        }

        function updateMetaDescCount() {
            const text = $('#meta_description').val();
            const count = text.length;
            $('#metaDescCount').text(count);

            // Add warning class if over 160
            if (count > 160) {
                $('#metaDescCount').addClass('text-danger');
            } else {
                $('#metaDescCount').removeClass('text-danger');
            }
        }

        function updateKeywordCount() {
            const text = $('#meta_keywords').val();
            const keywords = text.split(',').filter(k => k.trim() !== '');
            $('#keywordCount').text(keywords.length);
        }

        // Initialize counts
        updateMetaTitleCount();
        updateMetaDescCount();
        updateKeywordCount();

        // Auto-generate OG fields from meta fields
        $('#meta_title, #meta_description').on('blur', function() {
            const ogTitle = $('#og_title');
            const ogDesc = $('#og_description');

            if (!ogTitle.val() || ogTitle.data('user-changed') !== true) {
                ogTitle.val($('#meta_title').val());
            }

            if (!ogDesc.val() || ogDesc.data('user-changed') !== true) {
                ogDesc.val($('#meta_description').val());
            }
        });

        // Mark OG fields as manually edited
        $('#og_title').on('input', function() {
            $(this).data('user-changed', true);
        });

        $('#og_description').on('input', function() {
            $(this).data('user-changed', true);
        });

        // File input label update for OG image
        $('#og_image').change(function(e) {
            var fileName = '';
            if (this.files && this.files[0]) {
                fileName = e.target.files[0].name;
                // Uncheck remove checkbox if user uploads new image
                $('#remove_og_image').prop('checked', false);
            }
            $(this).next('.custom-file-label').html(fileName);
        });

        // Remove OG image checkbox handler
        $('#remove_og_image').change(function() {
            if ($(this).is(':checked')) {
                $('#og_image').val('');
                $('#og_image').next('.custom-file-label').html('Choose OG image...');
            }
        });

        // Course status change alert
        $('#course_status').change(function() {
            const status = $(this).val();

            if (status === 'published') {
                // Check if required fields are filled
                const title = $('#title').val();
                const description = $('#description').summernote('code');
                const category = $('#category_id').val();

                if (!title || !description || !category) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Course',
                        text: 'Please fill all required fields before publishing the course.',
                        confirmButtonColor: '#667eea'
                    });

                    // Switch to first tab
                    $('.step[data-step="1"]').click();
                    $(this).val('draft');
                }
            }
        });

        // Coming Soon status additional options
        const comingSoonFields = `
            <div class="form-group mt-3" id="comingSoonFields" style="display: none;">
                <label for="coming_soon_date" class="form-label">
                    <i class="fas fa-calendar-day mr-1"></i> Expected Launch Date
                </label>
                <input type="date" class="form-control" id="coming_soon_date" name="coming_soon_date" 
                    value="{{ old('coming_soon_date', isset($course->coming_soon_date) ? $course->coming_soon_date->format('Y-m-d') : '') }}">
                <small class="form-text text-muted">
                    When will this course be available?
                </small>
            </div>
        `;

        // Add coming soon fields after status dropdown
        $('#course_status').closest('.form-group').after(comingSoonFields);

        // Show/hide coming soon date based on status
        function toggleComingSoonFields() {
            if ($('#course_status').val() === 'coming_soon') {
                $('#comingSoonFields').slideDown();
            } else {
                $('#comingSoonFields').slideUp();
            }
        }

        $('#course_status').change(toggleComingSoonFields);
        toggleComingSoonFields(); // Initialize on page load
    });
</script>
