{{-- admin/course/partials/basic-info.blade.php --}}
<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-4">
            <label for="title" class="form-label">
                <i class="fas fa-heading me-1"></i>Course Title *
            </label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                value="{{ old('title', $course->title ?? '') }}" placeholder="Enter course title" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="slug" class="form-label">
                <i class="fas fa-link me-1"></i>Slug
            </label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                value="{{ old('slug', $course->slug ?? '') }}" placeholder="auto-generates-from-title">
            <small class="form-text text-muted mt-1">
                Leave empty to auto-generate from title
            </small>
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="short_description" class="form-label">
                <i class="fas fa-align-left me-1"></i>Short Description
            </label>
            <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                name="short_description" rows="3" maxlength="500"
                placeholder="Brief description of the course (max 500 characters)">{{ old('short_description', $course->short_description ?? '') }}</textarea>
            <small class="form-text text-muted mt-1">
                This will be displayed in course listings
            </small>
            @error('short_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-4">
            <label for="category_id" class="form-label">
                <i class="fas fa-folder me-1"></i>Category *
            </label>
            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id"
                required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $course->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="course_type" class="form-label">
                <i class="fas fa-certificate me-1"></i>Course Type *
            </label>
            <select class="form-control @error('course_type') is-invalid @enderror" id="course_type" name="course_type"
                required>
                <option value="">Select Type</option>
                <option value="Certificate"
                    {{ old('course_type', $course->course_type ?? '') == 'Certificate' ? 'selected' : '' }}>Certificate
                    Course</option>
                <option value="Diploma"
                    {{ old('course_type', $course->course_type ?? '') == 'Diploma' ? 'selected' : '' }}>Diploma
                </option>
                <option value="Graduate"
                    {{ old('course_type', $course->course_type ?? '') == 'Graduate' ? 'selected' : '' }}>Graduate
                </option>
                <option value="Post Graduate"
                    {{ old('course_type', $course->course_type ?? '') == 'Post Graduate' ? 'selected' : '' }}>Post
                    Graduate</option>
                <option value="10th After"
                    {{ old('course_type', $course->course_type ?? '') == '10th After' ? 'selected' : '' }}>Courses
                    After 10th</option>
                <option value="12th Science"
                    {{ old('course_type', $course->course_type ?? '') == '12th Science' ? 'selected' : '' }}>12th
                    Science</option>
                <option value="12th Commerce"
                    {{ old('course_type', $course->course_type ?? '') == '12th Commerce' ? 'selected' : '' }}>12th
                    Commerce</option>
                <option value="12th Arts"
                    {{ old('course_type', $course->course_type ?? '') == '12th Arts' ? 'selected' : '' }}>12th Arts
                </option>
                <option value="Online"
                    {{ old('course_type', $course->course_type ?? '') == 'Online' ? 'selected' : '' }}>Online Courses
                </option>
                <option value="Job Oriented"
                    {{ old('course_type', $course->course_type ?? '') == 'Job Oriented' ? 'selected' : '' }}>Job
                    Oriented Courses</option>
                <option value="Skill Based"
                    {{ old('course_type', $course->course_type ?? '') == 'Skill Based' ? 'selected' : '' }}>Skill
                    Courses</option>
            </select>
            @error('course_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="level" class="form-label">
                <i class="fas fa-signal me-1"></i>Course Level *
            </label>
            <select class="form-control @error('level') is-invalid @enderror" id="level" name="level" required>
                <option value="">Select Level</option>
                <option value="beginner" {{ old('level', $course->level ?? '') == 'beginner' ? 'selected' : '' }}>
                    Beginner</option>
                <option value="intermediate"
                    {{ old('level', $course->level ?? '') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                <option value="advanced"
                    {{ old('level', $course->course_level ?? '') == 'advanced' ? 'selected' : '' }}>Advanced</option>
            </select>
            @error('level')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
