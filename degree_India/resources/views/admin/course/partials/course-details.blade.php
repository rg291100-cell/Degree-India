{{-- admin/course/partials/course-details.blade.php --}}
<div class="row">
    <div class="col-12">
        <div class="form-group mb-4">
            <label for="description" class="form-label">
                <i class="fas fa-align-justify me-1"></i>Course Description *
            </label>
            <textarea class="form-control summernote @error('description') is-invalid @enderror" id="description" name="description"
                required>{{ old('description', $course->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-4">
            <label for="course_mode" class="form-label">
                <i class="fas fa-laptop-house me-1"></i>Course Mode *
            </label>
            <select class="form-control @error('course_mode') is-invalid @enderror" id="course_mode" name="course_mode"
                required>
                <option value="">Select Mode</option>
                <option value="online"
                    {{ old('course_mode', $course->course_mode ?? '') == 'online' ? 'selected' : '' }}>Online</option>
                <option value="offline"
                    {{ old('course_mode', $course->course_mode ?? '') == 'offline' ? 'selected' : '' }}>Offline</option>
                <option value="both" {{ old('course_mode', $course->course_mode ?? '') == 'both' ? 'selected' : '' }}>
                    Both (Hybrid)</option>
            </select>
            @error('course_mode')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="duration" class="form-label">
                        <i class="fas fa-hourglass-half me-1"></i>Duration *
                    </label>
                    <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration"
                        name="duration" value="{{ old('duration', $course->duration ?? '') }}" min="1"
                        placeholder="e.g., 120" required>
                    @error('duration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="duration_unit" class="form-label">
                        <i class="fas fa-calendar-alt me-1"></i>Unit *
                    </label>
                    <select class="form-control @error('duration_unit') is-invalid @enderror" id="duration_unit"
                        name="duration_unit" required>
                        <option value="hours"
                            {{ old('duration_unit', $course->duration_unit ?? '') == 'hours' ? 'selected' : '' }}>Hours
                        </option>
                        <option value="days"
                            {{ old('duration_unit', $course->duration_unit ?? '') == 'days' ? 'selected' : '' }}>Days
                        </option>
                        <option value="weeks"
                            {{ old('duration_unit', $course->duration_unit ?? '') == 'weeks' ? 'selected' : '' }}>Weeks
                        </option>
                        <option value="months"
                            {{ old('duration_unit', $course->duration_unit ?? '') == 'months' ? 'selected' : '' }}>
                            Months</option>
                        <option value="year"
                            {{ old('duration_unit', $course->duration_unit ?? '') == 'year' ? 'selected' : '' }}>
                            Year</option>
                    </select>
                    @error('duration_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group mb-4">
            <label for="learning_format" class="form-label">
                <i class="fas fa-chalkboard-teacher me-1"></i>Learning Format
            </label>
            <select class="form-control @error('learning_format') is-invalid @enderror" id="learning_format"
                name="learning_format">
                <option value="">Select Format</option>
                <option value="full-time"
                    {{ old('learning_format', $course->learning_format ?? '') == 'full-time' ? 'selected' : '' }}>
                    Full-time</option>
                <option value="part-time"
                    {{ old('learning_format', $course->learning_format ?? '') == 'part-time' ? 'selected' : '' }}>
                    Part-time</option>
                <option value="weekend"
                    {{ old('learning_format', $course->learning_format ?? '') == 'weekend' ? 'selected' : '' }}>Weekend
                </option>
                <option value="evening"
                    {{ old('learning_format', $course->learning_format ?? '') == 'evening' ? 'selected' : '' }}>Evening
                    Classes</option>
            </select>
            @error('learning_format')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-4">
            <label for="total_sessions" class="form-label">
                <i class="fas fa-calendar-check me-1"></i> Sessions
            </label>
            <input type="text" class="form-control @error('total_sessions') is-invalid @enderror" id="total_sessions"
                name="total_sessions" value="{{ old('total_sessions', $course->total_sessions ?? '') }}"
                placeholder="e.g., 2026-2027">
            @error('total_sessions')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group mb-4">
            <label for="course_affiliation" class="form-label">
                <i class="fas fa-university me-1"></i>Course Affiliation
            </label>
            <input type="text" class="form-control @error('course_affiliation') is-invalid @enderror"
                id="course_affiliation" name="course_affiliation"
                value="{{ old('course_affiliation', $course->course_affiliation ?? '') }}"
                placeholder="e.g., University of Delhi, AICTE Approved">
            @error('course_affiliation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="syllabus" class="form-label">
                <i class="fas fa-book me-1"></i>Syllabus
            </label>
            <textarea class="form-control summernote @error('syllabus') is-invalid @enderror" id="syllabus" name="syllabus">{{ old('syllabus', $course->syllabus ?? '') }}</textarea>
            @error('syllabus')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<!-- Course Highlights -->
<div class="form-group mb-4">
    <label class="form-label">
        <i class="fas fa-star me-1"></i>Course Highlights
    </label>
    <div id="highlightsContainer">
        <!-- For edit mode - load existing highlights -->
        @isset($course)
            @if ($course->course_highlights)
                @php
                    // First check if it's already decoded
                    if (is_string($course->course_highlights)) {
                        $highlights = json_decode($course->course_highlights, true) ?? [];
                    } else {
                        $highlights = $course->course_highlights;
                    }
                @endphp

                @if (is_array($highlights) && count($highlights) > 0)
                    @foreach ($highlights as $index => $highlightItem)
                        @php
                            // Check if it's an object with icon and text properties
$text = '';
$icon = '';

if (is_array($highlightItem)) {
    $text = $highlightItem['text'] ?? ($highlightItem['text'] ?? '');
    $icon = $highlightItem['icon'] ?? ($highlightItem['icon'] ?? '');
} elseif (is_object($highlightItem)) {
    $text = $highlightItem->text ?? '';
    $icon = $highlightItem->icon ?? '';
                            } else {
                                $text = $highlightItem;
                            }
                        @endphp

                        <div class="highlight-item">
                            <div class="d-flex align-items-center mb-2">
                                <input type="text"
                                    class="form-control me-2 @error('course_highlights.' . $index) is-invalid @enderror"
                                    name="course_highlights[]" value="{{ old('course_highlights.' . $index, $text) }}"
                                    placeholder="Enter highlight" required>
                                <input type="text" class="form-control me-2" name="highlight_icons[]"
                                    value="{{ old('highlight_icons.' . $index, $icon) }}" placeholder="fas fa-check">
                                <button type="button" class="btn btn-danger btn-sm remove-highlight">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @error('course_highlights.' . $index)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                @endif
            @endif
        @endisset

        <!-- For create mode or when old data exists -->
        @if (old('course_highlights'))
            @foreach (old('course_highlights') as $index => $highlight)
                @if (empty($course) || !isset($course->course_highlights))
                    <div class="highlight-item">
                        <div class="d-flex align-items-center mb-2">
                            <input type="text"
                                class="form-control me-2 @error('course_highlights.' . $index) is-invalid @enderror"
                                name="course_highlights[]" value="{{ $highlight }}" required>
                            <input type="text" class="form-control me-2" name="highlight_icons[]"
                                value="{{ old('highlight_icons.' . $index, '') }}" placeholder="fas fa-check">
                            <button type="button" class="btn btn-danger btn-sm remove-highlight">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        @error('course_highlights.' . $index)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
            @endforeach
        @endif

        <!-- If no highlights exist, show one empty field -->
        @if (empty($course) && !old('course_highlights'))
            <div class="highlight-item">
                <div class="d-flex align-items-center mb-2">
                    <input type="text" class="form-control me-2" name="course_highlights[]"
                        placeholder="Enter highlight" required>
                    <input type="text" class="form-control me-2" name="highlight_icons[]"
                        placeholder="fas fa-check">
                    <button type="button" class="btn btn-danger btn-sm remove-highlight">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addHighlight">
        <i class="fas fa-plus me-1"></i> Add Highlight
    </button>
    <small class="form-text text-muted d-block mt-1">
        These will be displayed as icons in the course banner
    </small>
    @error('course_highlights')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<!-- Skills Covered -->
<div class="form-group mb-4">
    <label for="skills_covered" class="form-label">
        <i class="fas fa-tools me-1"></i>Skills Covered
    </label>
    @php
        $skillsValue = '';
        if (isset($course) && $course->skills_covered) {
            if (is_array($course->skills_covered)) {
                // If it's already an array, convert to comma-separated string
        $skillsValue = implode(',', $course->skills_covered);
    } elseif (is_string($course->skills_covered)) {
        // Check if it's a JSON string
                $decoded = json_decode($course->skills_covered, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $skillsValue = implode(',', $decoded);
                } else {
                    $skillsValue = $course->skills_covered;
                }
            }
        }
        // Use old data if available, otherwise use course data
        $skillsValue = old('skills_covered', $skillsValue);
    @endphp

    <input type="text" class="form-control @error('skills_covered') is-invalid @enderror" id="skills_covered"
        name="skills_covered" value="{{ $skillsValue }}" data-role="tagsinput"
        placeholder="Add skill and press Enter">
    @error('skills_covered')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Key Features -->
<div class="form-group mb-4">
    <label for="key_features" class="form-label">
        <i class="fas fa-key me-1"></i>Key Features
    </label>
    <textarea class="form-control summernote @error('key_features') is-invalid @enderror" id="key_features"
        name="key_features">{{ old('key_features', $course->key_features ?? '') }}</textarea>
    @error('key_features')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Course Advantage -->
<div class="form-group">
    <label for="course_advantage" class="form-label">
        <i class="fas fa-trophy me-1"></i>Course Advantage
    </label>
    <textarea class="form-control summernote @error('course_advantage') is-invalid @enderror" id="course_advantage"
        name="course_advantage">{{ old('course_advantage', $course->course_advantage ?? '') }}</textarea>
    @error('course_advantage')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- ... आपका मौजूदा HTML code ... --}}

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Highlights functionality
            const highlightsContainer = document.getElementById('highlightsContainer');
            const addHighlightBtn = document.getElementById('addHighlight');

            if (addHighlightBtn) {
                // Add new highlight field
                addHighlightBtn.addEventListener('click', function() {
                    const highlightItem = document.createElement('div');
                    highlightItem.className = 'highlight-item';

                    highlightItem.innerHTML = `
                <div class="d-flex align-items-center mb-2">
                    <input type="text" 
                           class="form-control me-2" 
                           name="course_highlights[]" 
                           placeholder="Enter highlight" 
                           required>
                    <input type="text" 
                           class="form-control me-2" 
                           name="highlight_icons[]" 
                           placeholder="fas fa-check">
                    <button type="button" class="btn btn-danger btn-sm remove-highlight">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

                    highlightsContainer.appendChild(highlightItem);

                    // Add event listener to the remove button
                    const removeBtn = highlightItem.querySelector('.remove-highlight');
                    removeBtn.addEventListener('click', function() {
                        highlightItem.remove();
                    });
                });
            }

            // Remove highlight functionality for existing items
            document.querySelectorAll('.remove-highlight').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.highlight-item').remove();
                });
            });

            // Initialize Summernote for textareas
            if (typeof $ !== 'undefined' && $.fn.summernote) {
                $('.summernote').summernote({
                    height: 200,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            }

            // Initialize Tags Input for skills
            if ($('#skills_covered').length && $.fn.tagsinput) {
                $('#skills_covered').tagsinput({
                    trimValue: true,
                    confirmKeys: [13, 44, 32], // Enter, Comma, Space
                    maxTags: 20
                });
            }
        });
    </script>
@endpush
