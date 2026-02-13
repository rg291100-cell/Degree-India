{{-- admin/course/partials/admission.blade.php --}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-4">
            <label for="education_qualification" class="form-label">
                <i class="fas fa-graduation-cap mr-1"></i> Education Qualification
            </label>
            <div id="qualificationContainer">
                <!-- For Edit Mode: Load existing qualifications -->
                @isset($course)
                    @if ($course->education_qualification)
                        @php
                            // Check if it's already an array
                            if (is_array($course->education_qualification)) {
                                $qualifications = $course->education_qualification;
                            } elseif (is_string($course->education_qualification)) {
                                $qualifications = json_decode($course->education_qualification, true) ?? [];
                            } else {
                                $qualifications = [];
                            }
                        @endphp

                        @if (is_array($qualifications) && count($qualifications) > 0)
                            @foreach ($qualifications as $index => $qualification)
                                <div class="input-group mb-2">
                                    <input type="text"
                                        class="form-control @error('education_qualification.' . $loop->index) is-invalid @enderror"
                                        name="education_qualification[]"
                                        value="{{ old('education_qualification.' . $loop->index, $qualification) }}">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-danger remove-qualification">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    @error('education_qualification.' . $loop->index)
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        @endif
                    @endif
                @endisset

                <!-- For Create Mode or when old data exists -->
                @if (old('education_qualification'))
                    @foreach (old('education_qualification') as $index => $qualification)
                        @if (empty($course) || !isset($course->education_qualification))
                            <div class="input-group mb-2">
                                <input type="text"
                                    class="form-control @error('education_qualification.' . $index) is-invalid @enderror"
                                    name="education_qualification[]" value="{{ $qualification }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger remove-qualification">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @error('education_qualification.' . $index)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    @endforeach
                @endif

                <!-- If no qualifications exist, show one empty field -->
                @if (empty($course) && !old('education_qualification'))
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="education_qualification[]"
                            placeholder="e.g., 10+2 Pass">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-danger remove-qualification">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" id="addQualification">
                <i class="fas fa-plus mr-1"></i> Add Qualification
            </button>
            @error('education_qualification')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="eligibility_criteria" class="form-label">
                <i class="fas fa-user-check mr-1"></i> Eligibility Criteria
            </label>
            <div id="eligibilityContainer">
                <!-- For Edit Mode: Load existing eligibility criteria -->
                @isset($course)
                    @if ($course->eligibility_criteria)
                        @php
                            $criteria = is_array($course->eligibility_criteria)
                                ? $course->eligibility_criteria
                                : json_decode($course->eligibility_criteria, true);
                        @endphp

                        @foreach ($criteria as $criterion)
                            <div class="input-group mb-2">
                                <input type="text"
                                    class="form-control @error('eligibility_criteria.' . $loop->index) is-invalid @enderror"
                                    name="eligibility_criteria[]"
                                    value="{{ old('eligibility_criteria.' . $loop->index, $criterion) }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger remove-eligibility">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @error('eligibility_criteria.' . $loop->index)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    @endif
                @endisset

                <!-- For Create Mode or when old data exists -->
                @if (old('eligibility_criteria'))
                    @foreach (old('eligibility_criteria') as $index => $criteria)
                        @if (empty($course) || !isset($course->eligibility_criteria))
                            <div class="input-group mb-2">
                                <input type="text"
                                    class="form-control @error('eligibility_criteria.' . $index) is-invalid @enderror"
                                    name="eligibility_criteria[]" value="{{ $criteria }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger remove-eligibility">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @error('eligibility_criteria.' . $index)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    @endforeach
                @endif

                <!-- If no eligibility criteria exist, show one empty field -->
                @if (empty($course) && !old('eligibility_criteria'))
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="eligibility_criteria[]"
                            placeholder="e.g., Minimum 50% marks">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-danger remove-eligibility">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" id="addCriteria">
                <i class="fas fa-plus mr-1"></i> Add Criteria
            </button>
            @error('eligibility_criteria')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Admission Process -->
        {{-- <div class="form-group mb-4">
            <label for="admission_process" class="form-label">
                <i class="fas fa-list-ol mr-1"></i> Admission Process
            </label>
            <textarea class="form-control summernote @error('admission_process') is-invalid @enderror" id="admission_process"
                name="admission_process">{{ old('admission_process', $course->admission_process ?? '') }}</textarea>
            @error('admission_process')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Step-by-step admission process description
            </small>
        </div> --}}
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="min_age" class="form-label">
                        <i class="fas fa-user-clock mr-1"></i> Minimum Age
                    </label>
                    <input type="number" class="form-control @error('min_age') is-invalid @enderror" id="min_age"
                        name="min_age" value="{{ old('min_age', $course->min_age ?? '') }}" min="0"
                        max="100">
                    @error('min_age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="max_age" class="form-label">
                        <i class="fas fa-user-clock mr-1"></i> Maximum Age
                    </label>
                    <input type="number" class="form-control @error('max_age') is-invalid @enderror" id="max_age"
                        name="max_age" value="{{ old('max_age', $course->max_age ?? '') }}" min="0"
                        max="100">
                    @error('max_age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Age Validation Alert -->
        <div id="ageValidation" class="alert alert-warning" style="display: none;">
            <i class="fas fa-exclamation-triangle mr-1"></i>
            <span id="ageValidationMessage"></span>
        </div>

        <div class="form-group mb-4">
            <label for="entrance_exam" class="form-label">
                <i class="fas fa-file-alt mr-1"></i> Entrance Exam (if any)
            </label>
            <input type="text" class="form-control @error('entrance_exam') is-invalid @enderror"
                id="entrance_exam" name="entrance_exam"
                value="{{ old('entrance_exam', $course->entrance_exam ?? '') }}" placeholder="e.g., JEE, NEET, CAT">
            @error('entrance_exam')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Exam Details -->
        <div class="form-group mb-4" id="examDetails"
            style="display: {{ old('entrance_exam', $course->entrance_exam ?? '') ? 'block' : 'none' }};">
            <label for="exam_details" class="form-label">
                <i class="fas fa-info-circle mr-1"></i> Exam Details
            </label>
            <textarea class="form-control summernote @error('exam_details') is-invalid @enderror" id="exam_details"
                name="exam_details">{{ old('exam_details', $course->exam_details ?? '') }}</textarea>
            @error('exam_details')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Exam pattern, syllabus, dates, etc.
            </small>
        </div>





        <div class="form-group">
            <label for="course_outcomes" class="form-label">
                <i class="fas fa-check-circle mr-1"></i> Course Outcomes
            </label>
            <div id="outcomesContainer">
                <!-- For Edit Mode: Load existing course outcomes -->
                @isset($course)
                    @if ($course->course_outcomes)
                        @php
                            // Check if it's already an array
                            if (is_array($course->course_outcomes)) {
                                $outcomes = $course->course_outcomes;
                            } elseif (is_string($course->course_outcomes)) {
                                $outcomes = json_decode($course->course_outcomes, true) ?? [];
                            } else {
                                $outcomes = [];
                            }
                        @endphp

                        @if (is_array($outcomes) && count($outcomes) > 0)
                            @foreach ($outcomes as $index => $outcome)
                                @if (!empty(trim($outcome)))
                                    <div class="input-group mb-2">
                                        <input type="text"
                                            class="form-control @error('course_outcomes.' . $loop->index) is-invalid @enderror"
                                            name="course_outcomes[]"
                                            value="{{ old('course_outcomes.' . $loop->index, $outcome) }}">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-danger remove-outcome">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        @error('course_outcomes.' . $loop->index)
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endif
                @endisset

                <!-- For Create Mode or when old data exists -->
                @if (old('course_outcomes'))
                    @foreach (old('course_outcomes') as $index => $outcome)
                        @if (empty($course) || !isset($course->course_outcomes))
                            <div class="input-group mb-2">
                                <input type="text"
                                    class="form-control @error('course_outcomes.' . $index) is-invalid @enderror"
                                    name="course_outcomes[]" value="{{ $outcome }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger remove-outcome">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @error('course_outcomes.' . $index)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    @endforeach
                @endif

                <!-- If no outcomes exist, show one empty field -->
                @if ((!isset($course) || empty($course->course_outcomes)) && !old('course_outcomes'))
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="course_outcomes[]"
                            placeholder="e.g., Understand basic concepts">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-danger remove-outcome">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif


            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" id="addOutcome">
                <i class="fas fa-plus mr-1"></i> Add Outcome
            </button>
            @error('course_outcomes')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                What students will learn/achieve from this course
            </small>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Add qualification
            $('#addQualification').click(function() {
                const count = $('#qualificationContainer .input-group').length + 1;
                const html = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="education_qualification[]" 
                           placeholder="Qualification ${count}">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-danger remove-qualification">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
                $('#qualificationContainer').append(html);
            });

            // Add eligibility criteria
            $('#addCriteria').click(function() {
                const count = $('#eligibilityContainer .input-group').length + 1;
                const html = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="eligibility_criteria[]" 
                           placeholder="Criteria ${count}">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-danger remove-eligibility">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
                $('#eligibilityContainer').append(html);
            });

            // Add course outcome
            $('#addOutcome').click(function() {
                const count = $('#outcomesContainer .input-group').length + 1;
                const html = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="course_outcomes[]" 
                           placeholder="Outcome ${count}">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-danger remove-outcome">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
                $('#outcomesContainer').append(html);
            });

            // Remove handlers
            $(document).on('click', '.remove-qualification, .remove-eligibility, .remove-outcome', function() {
                $(this).closest('.input-group').fadeOut(300, function() {
                    $(this).remove();
                });
            });

            // Entrance exam toggle
            $('#entrance_exam').on('input', function() {
                if ($(this).val().trim()) {
                    $('#examDetails').slideDown();
                } else {
                    $('#examDetails').slideUp();
                    $('#exam_details').summernote('code', '');
                }
            });

            // Age validation
            $('#min_age, #max_age').on('input', function() {
                const minAge = parseInt($('#min_age').val()) || 0;
                const maxAge = parseInt($('#max_age').val()) || 0;

                if (minAge > 0 && maxAge > 0) {
                    if (minAge > maxAge) {
                        $('#ageValidationMessage').text('Minimum age cannot be greater than maximum age');
                        $('#ageValidation').show();
                    } else if (maxAge < minAge) {
                        $('#ageValidationMessage').text('Maximum age cannot be less than minimum age');
                        $('#ageValidation').show();
                    } else {
                        $('#ageValidation').hide();
                    }
                } else {
                    $('#ageValidation').hide();
                }
            });

            // Date validation
            $('#application_start, #application_end, #course_start_date').change(function() {
                const start = $('#application_start').val();
                const end = $('#application_end').val();
                const courseStart = $('#course_start_date').val();

                if (start && end) {
                    const startDate = new Date(start);
                    const endDate = new Date(end);

                    if (endDate < startDate) {
                        alert('Application end date cannot be before application start date');
                        $('#application_end').val('');
                    }
                }

                if (courseStart && end) {
                    const courseStartDate = new Date(courseStart);
                    const endDate = new Date(end);

                    if (courseStartDate < endDate) {
                        alert('Course start date should be after application end date');
                        $('#course_start_date').val('');
                    }
                }
            });

            // Initialize Summernote for new fields
            function initializeSummernote() {
                $('#admission_process, #exam_details').summernote({
                    height: 150,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline']],
                        ['para', ['ul', 'ol']],
                        ['insert', ['link']],
                        ['view', ['fullscreen']]
                    ]
                });
            }

            // Call initialization
            initializeSummernote();
        });
    </script>
@endpush
