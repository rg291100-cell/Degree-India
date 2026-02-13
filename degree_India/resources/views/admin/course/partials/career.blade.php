{{-- admin/course/partials/career.blade.php --}}
<div class="row">
    <div class="col-12">
        <div class="form-group mb-4">
            <label for="career_scope" class="form-label">
                <i class="fas fa-briefcase mr-1"></i> Career Scope *
            </label>
            <textarea class="form-control summernote @error('career_scope') is-invalid @enderror" id="career_scope" name="career_scope"
                required>
                {{ old('career_scope', $course->career_scope ?? '') }}
            </textarea>
            @error('career_scope')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Describe the career opportunities and growth prospects
            </small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-4">
            <label for="industry_trend" class="form-label">
                <i class="fas fa-chart-line mr-1"></i> Industry Trend
            </label>
            <textarea class="form-control @error('industry_trend') is-invalid @enderror" id="industry_trend" name="industry_trend"
                rows="4">{{ old('industry_trend', $course->industry_trend ?? '') }}</textarea>
            @error('industry_trend')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Current and future trends in the industry
            </small>
        </div>

        <div class="form-group mb-4">
            <label for="employment_areas" class="form-label">
                <i class="fas fa-building mr-1"></i> Employment Areas
            </label>
            @php
                $employmentAreas = old(
                    'employment_areas',
                    is_array($course->employment_areas ?? null)
                        ? implode(',', $course->employment_areas)
                        : $course->employment_areas ?? '',
                );
            @endphp

            <input type="text" class="form-control @error('employment_areas') is-invalid @enderror"
                id="employment_areas" name="employment_areas" value="{{ $employmentAreas }}" data-role="tagsinput"
                placeholder="Add employment area">

            @error('employment_areas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Industries/areas where graduates can find employment (comma separated)
            </small>
        </div>

        <!-- Top Recruiters -->

    </div>

    <div class="col-md-6">


        <div class="form-group mb-4">
            <label for="expected_market_size" class="form-label">
                <i class="fas fa-chart-pie mr-1"></i> Expected Market Size
            </label>
            <input type="text" class="form-control @error('expected_market_size') is-invalid @enderror"
                id="expected_market_size" name="expected_market_size"
                value="{{ old('expected_market_size', $course->expected_market_size ?? '') }}"
                placeholder="e.g., $50 Billion by 2025">
            @error('expected_market_size')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Industry market size projection
            </small>
        </div>

        <div class="form-group mb-4">
            <label for="salary_range" class="form-label">
                <i class="fas fa-money-check-alt mr-1"></i> Salary Range
            </label>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">₹</span>
                        </div>
                        <input type="number" class="form-control @error('salary_range') is-invalid @enderror"
                            id="salary_range" name="salary_range"
                            value="{{ old('salary_range', $course->salary_range ?? '') }}" min="0" step="0.01"
                            placeholder="Min Salary">
                    </div>
                    @error('salary_range')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">₹</span>
                        </div>
                        <input type="number" class="form-control @error('salary_range') is-invalid @enderror"
                            id="salary_range" name="salary_range"
                            value="{{ old('salary_range', $course->salary_range ?? '') }}" min="0"
                            step="0.01" placeholder="Max Salary">
                    </div>
                    @error('salary_range')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <small class="form-text text-muted mt-2">
                Fresher salary range (per annum)
            </small>

            <!-- Display formatted salary range -->
            <div id="salaryPreview" class="mt-2" style="display: none;">
                <div class="alert alert-info p-2 mb-0">
                    <strong>Salary Range:</strong>
                    <span id="salaryRangeText"></span>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- Academic Partners -->
<div class="form-group mb-4">
    <label class="form-label">
        <i class="fas fa-handshake mr-1"></i> Academic Partners
    </label>
    <div id="partnersContainer">
        <!-- For Edit Mode: Load existing partners -->
        @isset($course)
            @if ($course->partner_names)
                @php
                    $partnerNames = json_decode($course->partner_names, true) ?? [];
                    $partnerWebsites = json_decode($course->partner_websites, true) ?? [];
                    $partnerLogos = json_decode($course->partner_logos, true) ?? [];
                @endphp
                @foreach ($partnerNames as $index => $partnerName)
                    <div class="partner-card mb-3 p-3 border rounded">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <input type="text"
                                    class="form-control @error('partner_names.' . $index) is-invalid @enderror"
                                    name="partner_names[]" value="{{ old('partner_names.' . $index, $partnerName) }}"
                                    placeholder="Partner Name" required>
                                @error('partner_names.' . $index)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="url"
                                    class="form-control @error('partner_websites.' . $index) is-invalid @enderror"
                                    name="partner_websites[]"
                                    value="{{ old('partner_websites.' . $index, $partnerWebsites[$index] ?? '') }}"
                                    placeholder="https://example.com">
                                @error('partner_websites.' . $index)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control @error('partner_logos.' . $index) is-invalid @enderror"
                                        name="partner_logos[]"
                                        value="{{ old('partner_logos.' . $index, $partnerLogos[$index] ?? '') }}"
                                        placeholder="Logo URL or upload later">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="uploadLogo(this)">
                                            <i class="fas fa-upload"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('partner_logos.' . $index)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger btn-sm remove-partner">
                                    <i class="fas fa-times mr-1"></i> Remove Partner
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endisset

        <!-- For Create Mode or when old data exists -->
        @if (old('partner_names'))
            @foreach (old('partner_names') as $index => $partner)
                @if (empty($course) || !isset($course->partner_names))
                    <div class="partner-card mb-3 p-3 border rounded">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <input type="text"
                                    class="form-control @error('partner_names.' . $index) is-invalid @enderror"
                                    name="partner_names[]" value="{{ $partner }}" placeholder="Partner Name"
                                    required>
                                @error('partner_names.' . $index)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="url"
                                    class="form-control @error('partner_websites.' . $index) is-invalid @enderror"
                                    name="partner_websites[]" value="{{ old('partner_websites.' . $index, '') }}"
                                    placeholder="https://example.com">
                                @error('partner_websites.' . $index)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <input type="text"
                                    class="form-control @error('partner_logos.' . $index) is-invalid @enderror"
                                    name="partner_logos[]" value="{{ old('partner_logos.' . $index, '') }}"
                                    placeholder="Logo URL or upload later">
                                @error('partner_logos.' . $index)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger btn-sm remove-partner">
                                    <i class="fas fa-times mr-1"></i> Remove Partner
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        <!-- If no partners exist, show one empty field -->
        @if (empty($course) && !old('partner_names'))
            <div class="partner-card mb-3 p-3 border rounded">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="text" class="form-control" name="partner_names[]" placeholder="Partner Name"
                            required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="url" class="form-control" name="partner_websites[]"
                            placeholder="https://example.com">
                    </div>
                    <div class="col-md-12 mb-2">
                        <input type="text" class="form-control" name="partner_logos[]"
                            placeholder="Logo URL or upload later">
                    </div>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-danger btn-sm remove-partner">
                            <i class="fas fa-times mr-1"></i> Remove Partner
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addPartner">
        <i class="fas fa-plus mr-1"></i> Add Academic Partner
    </button>
    @error('partner_names')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">
        Universities, colleges, or institutions partnered with for this course
    </small>
</div>

<script>
    $(document).ready(function() {
        // Add academic partner
        $('#addPartner').click(function() {
            const count = $('#partnersContainer .partner-card').length + 1;
            const html = `
                <div class="partner-card mb-3 p-3 border rounded">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control" name="partner_names[]" 
                                   placeholder="Partner Name ${count}" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="url" class="form-control" name="partner_websites[]" 
                                   placeholder="https://example.com">
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="partner_logos[]" 
                                       placeholder="Logo URL or upload later">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" onclick="uploadLogo(this)">
                                        <i class="fas fa-upload"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-danger btn-sm remove-partner">
                                <i class="fas fa-times mr-1"></i> Remove Partner
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $('#partnersContainer').append(html);

            // Initialize tagsinput for new partner fields if any
            $('[data-role="tagsinput"]').tagsinput('refresh');
        });

        // Remove partner
        $(document).on('click', '.remove-partner', function() {
            $(this).closest('.partner-card').fadeOut(300, function() {
                $(this).remove();
            });
        });

        // Salary range preview
        $('#min_salary, #max_salary').on('input', function() {
            const minSalary = parseFloat($('#min_salary').val()) || 0;
            const maxSalary = parseFloat($('#max_salary').val()) || 0;

            if (minSalary > 0 && maxSalary > 0) {
                if (minSalary > maxSalary) {
                    $('#salaryPreview').hide();
                    alert('Minimum salary cannot be greater than maximum salary');
                    $('#min_salary').val('');
                } else {
                    const formattedMin = formatSalary(minSalary);
                    const formattedMax = formatSalary(maxSalary);
                    $('#salaryRangeText').text(`${formattedMin} - ${formattedMax} per annum`);
                    $('#salaryPreview').show();
                }
            } else if (minSalary > 0 || maxSalary > 0) {
                $('#salaryPreview').hide();
            }
        });

        // Format salary with commas
        function formatSalary(amount) {
            if (amount >= 10000000) {
                return '₹' + (amount / 10000000).toFixed(1) + ' Crore';
            } else if (amount >= 100000) {
                return '₹' + (amount / 100000).toFixed(1) + ' Lakh';
            } else if (amount >= 1000) {
                return '₹' + (amount / 1000).toFixed(1) + ' Thousand';
            } else {
                return '₹' + amount.toFixed(0);
            }
        }

        // Initialize tagsinput with existing data for edit mode
        @isset($course)
            @if (!empty($course->employment_areas))
                $('#employment_areas').tagsinput('add', {!! json_encode($course->employment_areas) !!});
            @endif

            @if (!empty($course->job_roles))
                $('#job_roles').tagsinput('add', {!! json_encode($course->job_roles) !!});
            @endif

            @if (!empty($course->top_recruiters))
                $('#top_recruiters').tagsinput('add', {!! json_encode($course->top_recruiters) !!});
            @endif
        @else
            $('#employment_areas, #job_roles, #top_recruiters').tagsinput();
        @endisset


        // Initialize Summernote for career scope
        $('#career_scope').summernote({
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen']]
            ]
        });

        // Show salary preview if values exist
        @if (isset($course) && ($course->min_salary || $course->max_salary))
            const minSalary = parseFloat({{ $course->min_salary ?? 0 }});
            const maxSalary = parseFloat({{ $course->max_salary ?? 0 }});
            if (minSalary > 0 && maxSalary > 0 && minSalary <= maxSalary) {
                const formattedMin = formatSalary(minSalary);
                const formattedMax = formatSalary(maxSalary);
                $('#salaryRangeText').text(`${formattedMin} - ${formattedMax} per annum`);
                $('#salaryPreview').show();
            }
        @endif
    });

    // Logo upload function
    function uploadLogo(button) {
        const input = $(button).closest('.input-group').find('input[type="text"]');

        // In a real application, you would trigger a file upload modal here
        // For now, we'll simulate with a prompt
        const logoUrl = prompt('Enter logo URL or leave empty to skip:');
        if (logoUrl !== null) {
            input.val(logoUrl);
        }
    }
</script>
