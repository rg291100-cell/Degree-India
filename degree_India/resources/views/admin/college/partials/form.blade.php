{{-- Is file me $college variable create page me nahi hai --}}
{{-- Isliye sab jagah old() function use karo --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
<style>
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        min-height: 38px;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #0d6efd;
        border: 1px solid #0d6efd;
        color: white;
        border-radius: 0.25rem;
        margin-top: 6px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 5px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #ffdddd;
    }
</style>
<div class="row">
    <!-- Basic Information -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">College Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', isset($college) ? $college->name : '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                            name="short_description" rows="2">{{ old('short_description', isset($college) ? $college->short_description : '') }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Full Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="5" required>{{ old('description', isset($college) ? $college->description : '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Location Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="address" class="form-label">Address *</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2"
                            required>{{ old('address', isset($college) ? $college->address : '') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="city" class="form-label">City *</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                            name="city" value="{{ old('city', isset($college) ? $college->city : '') }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="state" class="form-label">State *</label>
                        <input type="text" class="form-control @error('state') is-invalid @enderror" id="state"
                            name="state" value="{{ old('state', isset($college) ? $college->state : '') }}" required>
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="country" class="form-label">Country *</label>
                        <input type="text" class="form-control @error('country') is-invalid @enderror" id="country"
                            name="country" value="{{ old('country', isset($college) ? $college->country : '') }}"
                            required>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="text" class="form-control @error('pincode') is-invalid @enderror" id="pincode"
                            name="pincode" value="{{ old('pincode', isset($college) ? $college->pincode : '') }}">
                        @error('pincode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="number" step="any"
                            class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude"
                            value="{{ old('latitude', isset($college) ? $college->latitude : '') }}">
                        @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="number" step="any"
                            class="form-control @error('longitude') is-invalid @enderror" id="longitude"
                            name="longitude"
                            value="{{ old('longitude', isset($college) ? $college->longitude : '') }}">
                        @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Courses Offered -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Courses Offered</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <select id="course-select" class="form-control">
                            <option value="">Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="button" id="add-course" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Course
                        </button>
                    </div>
                </div>

                <div id="selected-courses">
                    @if (isset($college) && $college->courses->count() > 0)
                        @foreach ($college->courses as $course)
                            <div class="card mb-3 course-item">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>{{ $course->title }}</strong>
                                            <input type="hidden" name="courses[]" value="{{ $course->id }}">
                                            <button type="button"
                                                class="btn btn-sm btn-danger remove-course float-end">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="course_fees[{{ $course->id }}]"
                                                class="form-control form-control-sm"
                                                value="{{ $course->pivot->fees ?? old('course_fees.' . $course->id) }}"
                                                placeholder="Fees" step="0.01">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="course_duration[{{ $course->id }}]"
                                                class="form-control form-control-sm"
                                                value="{{ $course->pivot->duration ?? old('course_duration.' . $course->id) }}"
                                                placeholder="Duration">
                                        </div>
                                        <div class="col-md-2">
                                            <select name="course_intake[{{ $course->id }}]"
                                                class="form-control form-control-sm">
                                                <option value="yearly"
                                                    {{ (isset($college) && $course->pivot->intake == 'yearly') || old('course_intake.' . $course->id) == 'yearly' ? 'selected' : '' }}>
                                                    Yearly</option>
                                                <option value="january"
                                                    {{ (isset($college) && $course->pivot->intake == 'january') || old('course_intake.' . $course->id) == 'january' ? 'selected' : '' }}>
                                                    January</option>
                                                <option value="july"
                                                    {{ (isset($college) && $course->pivot->intake == 'july') || old('course_intake.' . $course->id) == 'july' ? 'selected' : '' }}>
                                                    July</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="course_seats[{{ $course->id }}]"
                                                class="form-control form-control-sm"
                                                value="{{ $course->pivot->seats ?? old('course_seats.' . $course->id) }}"
                                                placeholder="Seats">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Images -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Images</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="logo" class="form-label">College Logo</label>
                    <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo"
                        name="logo" accept="image/*">
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if (isset($college) && $college->logo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $college->logo) }}" alt="Logo" class="img-thumbnail"
                                width="100">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="cover_image" class="form-label">Cover Image</label>
                    <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                        id="cover_image" name="cover_image" accept="image/*">
                    @error('cover_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if (isset($college) && $college->cover_image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $college->cover_image) }}" alt="Cover"
                                class="img-thumbnail" width="100">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Gallery Images</label>
                    <div id="gallery-images-container">
                        <div class="input-group mb-2">
                            <input type="file" name="gallery_images[]" class="form-control" accept="image/*">
                            <button type="button" class="btn btn-danger remove-gallery-image">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" id="add-gallery-image" class="btn btn-sm btn-secondary">
                        <i class="fas fa-plus"></i> Add More
                    </button>

                    @if (isset($college) && $college->gallery_images && count($college->gallery_images) > 0)
                        <div class="mt-3">
                            @foreach ($college->gallery_images as $index => $image)
                                <div class="d-inline-block me-2 mb-2 position-relative">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery" class="img-thumbnail"
                                        width="80">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                        onclick="removeGalleryImage({{ $index }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="type" class="form-label">College Type *</label>
                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type"
                        required>
                        <option value="private"
                            {{ old('type', isset($college) ? $college->type : '') == 'private' ? 'selected' : '' }}>
                            Private</option>
                        <option value="government"
                            {{ old('type', isset($college) ? $college->type : '') == 'government' ? 'selected' : '' }}>
                            Government</option>
                        <option value="deemed"
                            {{ old('type', isset($college) ? $college->type : '') == 'deemed' ? 'selected' : '' }}>
                            Deemed University</option>
                        <option value="autonomous"
                            {{ old('type', isset($college) ? $college->type : '') == 'autonomous' ? 'selected' : '' }}>
                            Autonomous</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                        required>
                        <option value="draft"
                            {{ old('status', isset($college) ? $college->status : 'draft') == 'draft' ? 'selected' : '' }}>
                            Draft</option>
                        <option value="published"
                            {{ old('status', isset($college) ? $college->status : '') == 'published' ? 'selected' : '' }}>
                            Published</option>
                        <option value="archived"
                            {{ old('status', isset($college) ? $college->status : '') == 'archived' ? 'selected' : '' }}>
                            Archived</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                        value="1"
                        {{ old('is_featured', isset($college) ? $college->is_featured : 0) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">
                        Featured College
                    </label>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Contact Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ old('phone', isset($college) ? $college->phone : '') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email', isset($college) ? $college->email : '') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" class="form-control @error('website') is-invalid @enderror" id="website"
                        name="website" value="{{ old('website', isset($college) ? $college->website : '') }}">
                    @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>



            </div>
        </div>
    </div>
</div>

<!-- Additional Information -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Additional Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="established_year" class="form-label">Established Year</label>
                        <input type="number" class="form-control @error('established_year') is-invalid @enderror"
                            id="established_year" name="established_year"
                            value="{{ old('established_year', isset($college) ? $college->established_year : '') }}"
                            min="1800" max="{{ date('Y') }}">
                        @error('established_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="accreditation" class="form-label">Accreditation</label>
                        <input type="text" class="form-control @error('accreditation') is-invalid @enderror"
                            id="accreditation" name="accreditation"
                            value="{{ old('accreditation', isset($college) ? $college->accreditation : '') }}">
                        @error('accreditation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="affiliation" class="form-label">Affiliation</label>
                        <input type="text" class="form-control @error('affiliation') is-invalid @enderror"
                            id="affiliation" name="affiliation"
                            value="{{ old('affiliation', isset($college) ? $college->affiliation : '') }}">
                        @error('affiliation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="campus_size" class="form-label">Campus Size</label>
                        <input type="text" class="form-control @error('campus_size') is-invalid @enderror"
                            id="campus_size" name="campus_size"
                            value="{{ old('campus_size', isset($college) ? $college->campus_size : '') }}"
                            placeholder="e.g., 10 acres">
                        @error('campus_size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="total_students" class="form-label">Total Students</label>
                        <input type="number" class="form-control @error('total_students') is-invalid @enderror"
                            id="total_students" name="total_students"
                            value="{{ old('total_students', isset($college) ? $college->total_students : '') }}"
                            min="0">
                        @error('total_students')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="total_faculty" class="form-label">Total Faculty</label>
                        <input type="number" class="form-control @error('total_faculty') is-invalid @enderror"
                            id="total_faculty" name="total_faculty"
                            value="{{ old('total_faculty', isset($college) ? $college->total_faculty : '') }}"
                            min="0">
                        @error('total_faculty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="facilities" class="form-label">Facilities</label>
                        @php
                            $allFacilities = [
                                'Digital Libraries',
                                'Fitness Centre',
                                'Recreation Centers',
                                'Sports Complex',
                                'Research Lab',
                                'Maker Spaces and Innovative Hubs',
                                'Smart Class Room',
                                'Health Clinic',
                                'Girls Hostel',
                                'Boys Hostel',
                                'Transportation',
                                'Campus WiFi',
                                'CCTV Surveillance',
                                'Auditorium',
                                'Incubation Centre',
                                'Gym Facilities',
                                'Cafe, Dinning & Retail',
                                'Career Center',
                                'Internship Assistance',
                                'Placement Assistance',
                            ];

                            $selectedFacilities = is_array($college->facilities) ? $college->facilities : [];

                            // custom facilities nikal lo jo static list mein nahi hain
                            $customFacilities = array_diff($selectedFacilities, $allFacilities);
                        @endphp

                        <select class="form-select select2" id="facilities" name="facilities[]" multiple
                            data-placeholder="Select facilities">
                            {{-- Static options --}}
                            @foreach ($allFacilities as $facility)
                                <option value="{{ $facility }}"
                                    {{ in_array($facility, $selectedFacilities) ? 'selected' : '' }}>
                                    {{ $facility }}
                                </option>
                            @endforeach

                            {{-- Custom options from DB --}}
                            @foreach ($customFacilities as $facility)
                                <option value="{{ $facility }}" selected>{{ $facility }}</option>
                            @endforeach
                        </select>
                        @error('facilities')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>






                    <!-- Include Select2 CSS and JS if not already included -->





                </div>
            </div>
        </div>

        <!-- Admission & Fees -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Admission & Fees</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="admission_process" class="form-label">Admission Process</label>
                    <textarea class="form-control @error('admission_process') is-invalid @enderror" id="admission_process"
                        name="admission_process" rows="3">{{ old('admission_process', isset($college) ? $college->admission_process : '') }}</textarea>
                    @error('admission_process')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <div class="mb-3">
                    <label for="eligibility_criteria" class="form-label">Eligibility Criteria (JSON)</label>
                    <textarea class="form-control @error('eligibility_criteria') is-invalid @enderror" id="eligibility_criteria"
                        name="eligibility_criteria" rows="3"
                        placeholder='[{"criteria": "Minimum 50% in 12th", "description": "For undergraduate courses"}]'>{{ old('eligibility_criteria', isset($college) && $college->eligibility_criteria ? json_encode($college->eligibility_criteria, JSON_PRETTY_PRINT) : '') }}</textarea>
                    @error('eligibility_criteria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}

                <!-- Eligibility Criteria ke liye -->
                <div class="mb-4">
                    <label class="form-label">Eligibility Criteria</label>
                    <div id="eligibility-criteria-container">
                        @php
                            $criteria = old(
                                'eligibility_criteria',
                                isset($college) ? $college->eligibility_criteria : [],
                            );
                            $criteria = is_array($criteria) ? $criteria : [];
                            if (empty($criteria)) {
                                $criteria = [['criteria' => '', 'description' => '']];
                            }
                        @endphp

                        @foreach ($criteria as $index => $item)
                            <div class="criteria-item row mb-2" data-index="{{ $index }}">
                                <div class="col-md-5">
                                    <input type="text" name="eligibility_criteria[{{ $index }}][criteria]"
                                        class="form-control" placeholder="Minimum 50% in 12th"
                                        value="{{ $item['criteria'] ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text"
                                        name="eligibility_criteria[{{ $index }}][description]"
                                        class="form-control" placeholder="For undergraduate courses"
                                        value="{{ $item['description'] ?? '' }}">
                                </div>
                                <div class="col-md-1">
                                    @if ($loop->first)
                                        <button type="button" class="btn btn-success btn-sm add-criteria">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm remove-criteria">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('eligibility_criteria')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="application_deadline" class="form-label">Application Deadline</label>
                        <input type="date"
                            class="form-control @error('application_deadline') is-invalid @enderror"
                            id="application_deadline" name="application_deadline"
                            value="{{ old('application_deadline', isset($college) ? $college->application_deadline : '') }}">
                        @error('application_deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="academic_year_start" class="form-label">Academic Year Start</label>
                        <input type="date" class="form-control @error('academic_year_start') is-invalid @enderror"
                            id="academic_year_start" name="academic_year_start"
                            value="{{ old('academic_year_start', isset($college) ? $college->academic_year_start : '') }}">
                        @error('academic_year_start')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="nirf_ranking" class="form-label">NIRF Ranking</label>
                        <input type="number" class="form-control @error('nirf_ranking') is-invalid @enderror"
                            id="nirf_ranking" name="nirf_ranking"
                            value="{{ old('nirf_ranking', isset($college) ? $college->nirf_ranking : '') }}"
                            min="1">
                        @error('nirf_ranking')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Placement Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Placement Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="average_package" class="form-label">Average Package (₹)</label>
                        <input type="number" step="0.01"
                            class="form-control @error('average_package') is-invalid @enderror" id="average_package"
                            name="average_package"
                            value="{{ old('average_package', isset($college) ? $college->average_package : '') }}">
                        @error('average_package')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="highest_package" class="form-label">Highest Package (₹)</label>
                        <input type="number" step="0.01"
                            class="form-control @error('highest_package') is-invalid @enderror" id="highest_package"
                            name="highest_package"
                            value="{{ old('highest_package', isset($college) ? $college->highest_package : '') }}">
                        @error('highest_package')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="placement_percentage" class="form-label">Placement Percentage</label>
                        <input type="number"
                            class="form-control @error('placement_percentage') is-invalid @enderror"
                            id="placement_percentage" name="placement_percentage"
                            value="{{ old('placement_percentage', isset($college) ? $college->placement_percentage : '') }}"
                            min="0" max="100">
                        @error('placement_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Top Recruiters ke liye -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label">Top Recruiters</label>
                        <div id="recruiters-container">
                            @php
                                $recruiters = old('top_recruiters', isset($college) ? $college->top_recruiters : []);
                                $recruiters = is_array($recruiters) ? $recruiters : [];
                                if (empty($recruiters)) {
                                    $recruiters = [''];
                                }
                            @endphp

                            @foreach ($recruiters as $index => $recruiter)
                                <div class="recruiter-item row mb-2" data-index="{{ $index }}">
                                    <div class="col-md-11">
                                        <input type="text" name="top_recruiters[]" class="form-control"
                                            placeholder="Google" value="{{ $recruiter }}">
                                    </div>
                                    <div class="col-md-1">
                                        @if ($loop->first)
                                            <button type="button" class="btn btn-success btn-sm add-recruiter">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-sm remove-recruiter">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('top_recruiters')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>


        <div class="border-top pt-3 mt-3">
            <div class="card-header">
                <h5 class="mb-0">Social Media Links</h5>
            </div>
            <div class="row" style="padding: 16px;">
                <div class="col-md-6 mb-3">
                    <label for="facebook_url" class="form-label">Facebook</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                        <input type="url" class="form-control @error('facebook_url') is-invalid @enderror"
                            id="facebook_url" name="facebook_url"
                            value="{{ old('facebook_url', isset($college) ? $college->facebook_url : '') }}"
                            placeholder="https://facebook.com/yourcollege">
                        @error('facebook_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="instagram_url" class="form-label">Instagram</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                        <input type="url" class="form-control @error('instagram_url') is-invalid @enderror"
                            id="instagram_url" name="instagram_url"
                            value="{{ old('instagram_url', isset($college) ? $college->instagram_url : '') }}"
                            placeholder="https://instagram.com/yourcollege">
                        @error('instagram_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="youtube_url" class="form-label">YouTube</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror"
                            id="youtube_url" name="youtube_url"
                            value="{{ old('youtube_url', isset($college) ? $college->youtube_url : '') }}"
                            placeholder="https://youtube.com/c/yourcollege">
                        @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>



                <div class="col-md-6 mb-3">
                    <label for="linkedin_url" class="form-label">LinkedIn</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                        <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror"
                            id="linkedin_url" name="linkedin_url"
                            value="{{ old('linkedin_url', isset($college) ? $college->linkedin_url : '') }}"
                            placeholder="https://linkedin.com/school/yourcollege">
                        @error('linkedin_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


            </div>
        </div>


        <!-- SEO Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">SEO Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                        id="meta_title" name="meta_title"
                        value="{{ old('meta_title', isset($college) ? $college->meta_title : '') }}">
                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                        name="meta_description" rows="3">{{ old('meta_description', isset($college) ? $college->meta_description : '') }}</textarea>
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                        id="meta_keywords" name="meta_keywords"
                        value="{{ old('meta_keywords', isset($college) ? $college->meta_keywords : '') }}"
                        placeholder="keyword1, keyword2, keyword3">
                    @error('meta_keywords')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                tags: true,
                placeholder: "Select facilities or type to add new",
                allowClear: true,
                width: '100%',
                tokenSeparators: [',', ';', '\n'] // यूजर , या ; या Enter दबाकर नया टैग add कर सकता है
            });

            // If you want to preserve selected values from old input
            @if (old('facilities'))
                var oldFacilities = @json(old('facilities'));
                $('.select2').val(oldFacilities).trigger('change');
            @endif

            // If you're editing and have existing facilities
            @if (isset($course) && $course->facilities)
                var existingFacilities = @json($course->facilities);
                $('.select2').val(existingFacilities).trigger('change');
            @endif

            // Optional: Create new tag on the fly
            $('.select2').on('select2:select', function(e) {
                var data = e.params.data;
                // यदि यूजर नया टैग add कर रहा है
                if (data.id === data.text) {
                    // आप यहाँ AJAX call करके server पर save कर सकते हैं
                    console.log('New facility added:', data.text);
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Eligibility Criteria - Add
            document.addEventListener('click', function(e) {
                if (e.target.closest('.add-criteria')) {
                    const container = document.getElementById('eligibility-criteria-container');
                    const index = container.querySelectorAll('.criteria-item').length;

                    const html = `
                    <div class="criteria-item row mb-2" data-index="${index}">
                        <div class="col-md-5">
                            <input type="text" 
                                   name="eligibility_criteria[${index}][criteria]" 
                                   class="form-control" 
                                   placeholder="Criteria">
                        </div>
                        <div class="col-md-6">
                            <input type="text" 
                                   name="eligibility_criteria[${index}][description]" 
                                   class="form-control" 
                                   placeholder="Description">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-criteria">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>`;

                    container.insertAdjacentHTML('beforeend', html);
                }

                // Eligibility Criteria - Remove
                if (e.target.closest('.remove-criteria')) {
                    const item = e.target.closest('.criteria-item');
                    item.remove();
                    reindexCriteria();
                }

                // Top Recruiters - Add
                if (e.target.closest('.add-recruiter')) {
                    const container = document.getElementById('recruiters-container');
                    const index = container.querySelectorAll('.recruiter-item').length;

                    const html = `
                    <div class="recruiter-item row mb-2" data-index="${index}">
                        <div class="col-md-11">
                            <input type="text" 
                                   name="top_recruiters[]" 
                                   class="form-control" 
                                   placeholder="Company Name">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-recruiter">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>`;

                    container.insertAdjacentHTML('beforeend', html);
                }

                // Top Recruiters - Remove
                if (e.target.closest('.remove-recruiter')) {
                    const item = e.target.closest('.recruiter-item');
                    item.remove();
                }
            });

            function reindexCriteria() {
                const criteriaItems = document.querySelectorAll('#eligibility-criteria-container .criteria-item');
                criteriaItems.forEach((item, index) => {
                    item.setAttribute('data-index', index);
                    const inputs = item.querySelectorAll('[name^="eligibility_criteria"]');

                    inputs.forEach(input => {
                        const name = input.getAttribute('name');
                        const newName = name.replace(/\[\d+\]/, `[${index}]`);
                        input.setAttribute('name', newName);
                    });
                });
            }

            // Courses functionality (agar ye bhi chahiye)
            const addCourseBtn = document.getElementById('add-course');
            if (addCourseBtn) {
                addCourseBtn.addEventListener('click', function() {
                    const courseSelect = document.getElementById('course-select');
                    const courseId = courseSelect.value;
                    const courseName = courseSelect.options[courseSelect.selectedIndex].text;

                    if (!courseId) {
                        alert('Please select a course first');
                        return;
                    }

                    // Check if course already added
                    const existingCourses = document.querySelectorAll('input[name="courses[]"]');
                    for (let course of existingCourses) {
                        if (course.value === courseId) {
                            alert('This course is already added');
                            courseSelect.value = '';
                            return;
                        }
                    }

                    const container = document.getElementById('selected-courses');
                    const index = container.querySelectorAll('.course-item').length;

                    const html = `
                    <div class="card mb-3 course-item">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>${courseName}</strong>
                                    <input type="hidden" name="courses[]" value="${courseId}">
                                    <button type="button" class="btn btn-sm btn-danger remove-course float-end">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="course_fees[${courseId}]" 
                                           class="form-control form-control-sm" 
                                           placeholder="Fees" step="0.01">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="course_duration[${courseId}]" 
                                           class="form-control form-control-sm" 
                                           placeholder="Duration">
                                </div>
                                <div class="col-md-2">
                                    <select name="course_intake[${courseId}]" class="form-control form-control-sm">
                                        <option value="yearly">Yearly</option>
                                        <option value="january">January</option>
                                        <option value="july">July</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="course_seats[${courseId}]" 
                                           class="form-control form-control-sm" 
                                           placeholder="Seats">
                                </div>
                            </div>
                        </div>
                    </div>`;

                    container.insertAdjacentHTML('beforeend', html);
                    courseSelect.value = '';
                });
            }

            // Remove course
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-course')) {
                    e.target.closest('.course-item').remove();
                }

                // Gallery images functionality
                if (e.target.closest('#add-gallery-image')) {
                    const container = document.getElementById('gallery-images-container');
                    const html = `
                    <div class="input-group mb-2">
                        <input type="file" name="gallery_images[]" class="form-control" accept="image/*">
                        <button type="button" class="btn btn-danger remove-gallery-image">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>`;
                    container.insertAdjacentHTML('beforeend', html);
                }

                if (e.target.closest('.remove-gallery-image')) {
                    e.target.closest('.input-group').remove();
                }
            });

            // Gallery image removal for existing images
            window.removeGalleryImage = function(index) {
                if (confirm('Are you sure you want to remove this image?')) {
                    // Create hidden input to mark image for deletion
                    const container = document.getElementById('gallery-images-container');
                    const html = `<input type="hidden" name="remove_gallery_images[]" value="${index}">`;
                    container.insertAdjacentHTML('beforeend', html);

                    // Remove image preview
                    const imgElement = document.querySelector(`img[alt="Gallery"][src*="${index}"]`);
                    if (imgElement) {
                        imgElement.closest('.d-inline-block').remove();
                    }
                }
            };
        });
    </script>
@endpush
