@extends('admin.layouts.master')

@section('title', 'Edit User')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="row align-items-center card-header">
                        <div class="col-md-8 col-12">
                            <h3 class="card-title">Edit User: {{ $user->name }}</h3>
                        </div>

                        <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                ← Back to List
                            </a>
                        </div>
                    </div>
                    {{-- <div class="card-header">
                        <h3 class="card-title">Edit User: {{ $user->name }}</h3>
                    </div> --}}
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="name">Full Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="email">Email Address *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="gender">Gender</label>
                                        <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                            name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male"
                                                {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female"
                                                {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="Other"
                                                {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" class="form-control @error('dob') is-invalid @enderror"
                                            id="dob" name="dob"
                                            value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}">
                                        @error('dob')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="role_id">Role *</label>
                                        <select class="form-control @error('role_id') is-invalid @enderror" id="role_id"
                                            name="role_id" required>
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                                            id="city" name="city" value="{{ old('city', $user->city) }}">
                                        @error('city')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control @error('state') is-invalid @enderror"
                                            id="state" name="state" value="{{ old('state', $user->state) }}">
                                        @error('state')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="education_level">Education Level</label>
                                        <select class="form-control @error('education_level') is-invalid @enderror"
                                            id="education_level" name="education_level">
                                            <option value="">Select Education Level</option>
                                            <option value="10th"
                                                {{ old('education_level', $user->education_level) == '10th' ? 'selected' : '' }}>
                                                10th</option>
                                            <option value="12th"
                                                {{ old('education_level', $user->education_level) == '12th' ? 'selected' : '' }}>
                                                12th</option>
                                            <option value="Diploma"
                                                {{ old('education_level', $user->education_level) == 'Diploma' ? 'selected' : '' }}>
                                                Diploma</option>
                                            <option value="Graduate"
                                                {{ old('education_level', $user->education_level) == 'Graduate' ? 'selected' : '' }}>
                                                Graduate</option>
                                            <option value="Post Graduate"
                                                {{ old('education_level', $user->education_level) == 'Post Graduate' ? 'selected' : '' }}>
                                                Post Graduate</option>
                                        </select>
                                        @error('education_level')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="career_interest">Career Interest</label>
                                        <input type="text"
                                            class="form-control @error('career_interest') is-invalid @enderror"
                                            id="career_interest" name="career_interest"
                                            value="{{ old('career_interest', $user->career_interest) }}">
                                        @error('career_interest')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="profile_picture">Profile Picture</label>
                                        @if ($user->profile_picture)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                                    alt="Current Profile" class="img-thumbnail"
                                                    style="max-height: 150px;">
                                                <p class="text-muted">Current Profile Picture</p>
                                            </div>
                                        @endif
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('profile_picture') is-invalid @enderror form-control"
                                                id="profile_picture" name="profile_picture" accept="image/*">

                                            @error('profile_picture')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Leave empty to keep current image</small>
                                        <div id="imagePreview" class="mt-2" style="display: none;">
                                            <img id="preview" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="status1"
                                                name="status" value="1"
                                                {{ old('status', $user->status) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status">Active User</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel</a>
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
    <script>
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {
            // File input preview
            $('#profile_picture').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview').attr('src', e.target.result);
                        $('#imagePreview').show();
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Update file input label
            $('.custom-file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
@endsection
