@extends('admin.layouts.master')
@section('title')
    Admin Profile - Degree India
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<link href="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet"
    type="text/css" />
<style>
    :root {
        --primary-blue: #2563eb;
        --secondary-blue: #1d4ed8;
        --light-blue: #eff6ff;
        --accent-blue: #3b82f6;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --border-color: #cbd5e1;
        --error-red: #ef4444;
        --success-green: #10b981;
        --white: #ffffff;
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
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

    .profile-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .page-header {
        margin-bottom: 40px;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        background-clip: text;
        display: inline-block;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-blue), var(--accent-blue));
        border-radius: 2px;
    }

    .page-subtitle {
        color: var(--text-light);
        font-size: 1.1rem;
        max-width: 600px;
    }

    .profile-card {
        background: var(--white);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(37, 99, 235, 0.12);
        overflow: hidden;
        border: 1px solid rgba(37, 99, 235, 0.1);
        backdrop-filter: blur(10px);
    }

    /* Profile Header - Glassmorphism Effect */
    .profile-header {
        background: linear-gradient(145deg, var(--primary-blue), #7c99eb);
        padding: 18px 11px;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        top: -150px;
        right: -150px;
    }

    .profile-header::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        bottom: -100px;
        left: -100px;
    }

    .profile-intro {
        display: flex;
        align-items: center;
        gap: 30px;
        position: relative;
        z-index: 2;
    }

    .avatar-wrapper {
        position: relative;
    }

    .profile-avatar {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.3);
        background: var(--white);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
    }

    .avatar-badge {
        position: absolute;
        bottom: 15px;
        right: 15px;
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        border: 3px solid white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .avatar-badge:hover {
        transform: scale(1.1) rotate(15deg);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .profile-meta {
        flex: 1;
        color: white;
    }

    .profile-name {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
        color: white;
    }

    .profile-role {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 8px 20px;
        border-radius: 20px;
    }

    .profile-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .detail-item i {
        font-size: 1.2rem;
        opacity: 0.8;
    }

    /* Profile Content */
    .profile-content {
        padding: 25px;
    }

    /* Navigation Pills */
    .profile-nav {
        display: flex;
        gap: 10px;
        padding-bottom: 20px;
    }

    .nav-pill {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 13px;
        background: var(--light-blue);
        border: none;
        border-radius: 12px;
        color: var(--text-light);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .nav-pill::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.6s ease;
    }

    .nav-pill:hover::before {
        left: 100%;
    }

    .nav-pill:hover {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
    }

    .nav-pill.active {
        background: linear-gradient(90deg, var(--primary-blue), var(--accent-blue));
        color: white;
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
    }

    /* Form Cards */
    .form-card {
        background: var(--white);
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }

    .form-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--light-blue);
    }

    .card-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--light-blue), var(--accent-blue));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-blue);
        font-size: 1.5rem;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .card-subtitle {
        color: var(--text-light);
        font-size: 0.95rem;
        margin-top: 5px;
    }

    /* Form Styling */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
    }

    .form-group {
        position: relative;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 10px;
        display: block;
        font-size: 0.95rem;
    }

    .form-control,
    .form-select {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--white);
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        background: var(--white);
        transform: translateY(-2px);
    }

    .input-with-icon {
        position: relative;
    }

    .input-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .input-icon:hover {
        color: var(--primary-blue);
    }

    /* Button Styling */
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 40px;
        padding-top: 30px;
        border-top: 2px solid var(--light-blue);
    }

    .btn {
        padding: 15px 35px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(90deg, var(--primary-blue), var(--secondary-blue));
        color: white;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(90deg, var(--secondary-blue), #1e40af);
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(37, 99, 235, 0.3);
    }

    .btn-outline {
        background: transparent;
        border: 2px solid var(--border-color);
        color: var(--text-light);
    }

    .btn-outline:hover {
        border-color: var(--text-light);
        background: var(--light-blue);
        transform: translateY(-3px);
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(90deg, var(--primary-blue), var(--secondary-blue));
        color: white;
        padding: 25px 30px;
        border: none;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.5rem;
    }

    .btn-close-white {
        filter: invert(1) brightness(100%);
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 40px;
    }

    .stat-card {
        background: var(--white);
        border-radius: 16px;
        padding: 25px;
        border: 1px solid var(--border-color);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: var(--light-blue);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-blue);
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1;
    }

    .stat-label {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-top: 5px;
    }

    /* Validation */
    .is-invalid {
        border-color: var(--error-red) !important;
    }

    .invalid-feedback {
        color: var(--error-red);
        font-size: 0.875rem;
        margin-top: 8px;
        font-weight: 500;
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease forwards;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .profile-intro {
            flex-direction: column;
            text-align: center;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
        }

        .profile-name {
            font-size: 1.8rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .profile-container {
            padding: 20px 15px;
        }

        .page-title {
            font-size: 2rem;
        }

        .profile-header {
            padding: 40px 25px;
        }

        .profile-content {
            padding: 30px 20px;
        }

        .profile-nav {
            flex-wrap: wrap;
        }

        .nav-pill {
            padding: 12px 20px;
            font-size: 0.9rem;
        }

        .form-card {
            padding: 30px 20px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.6rem;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
        }

        .profile-name {
            font-size: 1.5rem;
        }

        .detail-item {
            padding: 10px 15px;
            font-size: 0.9rem;
        }
    }
</style>


@section('content')
    <div class="container-fluid profile-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title"><?= $currentRole ?> Profile</h1>
            <p class="page-subtitle">Manage your personal information, security settings, and account preferences</p>
        </div>

        <!-- Success/Error Messages -->
        <div id="messageContainer"></div>

        <div class="profile-card animate-fadeInUp">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-intro">
                    <div class="avatar-wrapper">
                        <img src="{{ $user->profile_picture ? asset($user->profile_picture) : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80' }}"
                            alt="Profile Avatar" class="profile-avatar" id="avatarPreview">
                        <div class="avatar-badge" data-bs-toggle="modal" data-bs-target="#avatarModal">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>

                    <div class="profile-meta">
                        <h2 class="profile-name">{{ $user->name }}</h2>
                        <div class="profile-role">
                            <i class="fas fa-shield-alt"></i>
                            <?= $currentRole ?>
                        </div>

                        <div class="profile-details">
                            <div class="detail-item">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $user->email }}</span>
                            </div>

                            @if ($user->phone)
                                <div class="detail-item">
                                    <i class="fas fa-phone"></i>
                                    <span>{{ $user->phone }}</span>
                                </div>
                            @endif

                            @if ($user->gender)
                                <div class="detail-item">
                                    <i class="fas fa-venus-mars"></i>
                                    <span>{{ ucfirst($user->gender) }}</span>
                                </div>
                            @endif

                            <div class="detail-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Member since {{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Navigation Pills -->
                <div class="profile-nav">
                    <button class="nav-pill active" data-tab="profile">
                        <i class="fas fa-user-circle"></i>
                        Personal Information
                    </button>
                    <button class="nav-pill" data-tab="password">
                        <i class="fas fa-lock"></i>
                        Security Settings
                    </button>
                    <button class="nav-pill" data-tab="stats">
                        <i class="fas fa-chart-line"></i>
                        Account Statistics
                    </button>
                </div>

                <!-- Profile Information Tab -->
                <div class="tab-content" id="profileTab">
                    <form id="profileForm">
                        @csrf
                        <div class="form-card">


                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $user->name }}" required>
                                    <div class="invalid-feedback" id="nameError"></div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" readonly name="email"
                                        value="{{ $user->email }}">
                                    <div class="invalid-feedback" id="emailError"></div>
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        value="{{ $user->phone }}" placeholder="+91 9876543210">
                                    <div class="invalid-feedback" id="phoneError"></div>
                                </div>

                                <div class="form-group">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    <div class="invalid-feedback" id="genderError"></div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-outline" id="cancelBtn"
                                    style="background-color: #E0E0E0;">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    <i class="fas fa-save"></i> Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Password Tab -->
                <div class="tab-content" id="passwordTab" style="display: none;">
                    <form id="passwordForm">
                        @csrf
                        <div class="form-card">


                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <div class="input-with-icon">
                                        <input type="password" class="form-control" id="current_password"
                                            name="current_password" required>
                                        <span class="input-icon password-toggle">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback" id="currentPasswordError"></div>
                                </div>

                                <div class="form-group">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <div class="input-with-icon">
                                        <input type="password" class="form-control" id="new_password"
                                            name="new_password" required>
                                        <span class="input-icon password-toggle">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback" id="newPasswordError"></div>
                                </div>

                                <div class="form-group">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                    <div class="input-with-icon">
                                        <input type="password" class="form-control" id="new_password_confirmation"
                                            name="new_password_confirmation" required>
                                        <span class="input-icon password-toggle">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback" id="confirmPasswordError"></div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-outline" id="passwordCancelBtn"
                                    style="background-color: #E0E0E0;">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary" id="passwordSubmitBtn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    <i class="fas fa-key"></i> Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Statistics Tab -->
                <div class="tab-content" id="statsTab" style="display: none;">
                    <div class="form-card">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <div>
                                <h3 class="card-title">Account Overview</h3>
                                <p class="card-subtitle">Your profile statistics and activity summary</p>
                            </div>
                        </div>

                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="stat-value">24</div>
                                <div class="stat-label">Days Active</div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div class="stat-value">{{ $user->is_admin ? 'Admin' : 'User' }}</div>
                                <div class="stat-label">Account Type</div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="stat-value">100%</div>
                                <div class="stat-label">Account Security</div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-history"></i>
                                </div>
                                <div class="stat-value">{{ $user->updated_at->diffForHumans() }}</div>
                                <div class="stat-label">Last Updated</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Avatar Modal -->
    <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="avatarModalLabel">Update Profile Picture</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="avatar" class="form-label">Upload New Image</label>
                            <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*">
                            <div class="invalid-feedback" id="avatarError"></div>
                            <div class="mt-3">
                                <p class="text-muted small">Recommended: Square image, max 2MB, JPG/PNG format</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Preview</label>
                            <div class="border rounded-3 p-3 text-center">
                                <img src="{{ $user->profile_picture ? asset($user->profile_picture) : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80' }}"
                                    alt="Avatar Preview" class="img-fluid rounded" id="modalAvatarPreview"
                                    style="max-height: 250px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal"
                        style="background-color: #E0E0E0;">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveAvatarBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        Update Profile Picture
                    </button>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Tab Switching
            const navPills = document.querySelectorAll('.nav-pill');
            const tabContents = {
                profile: document.getElementById('profileTab'),
                password: document.getElementById('passwordTab'),
                stats: document.getElementById('statsTab')
            };

            navPills.forEach(pill => {
                pill.addEventListener('click', function() {
                    const tabId = this.dataset.tab;

                    // Remove active class from all pills
                    navPills.forEach(p => p.classList.remove('active'));
                    // Add active class to clicked pill
                    this.classList.add('active');

                    // Hide all tabs
                    Object.values(tabContents).forEach(tab => {
                        tab.style.display = 'none';
                    });

                    // Show selected tab
                    if (tabContents[tabId]) {
                        tabContents[tabId].style.display = 'block';
                        tabContents[tabId].classList.add('animate-fadeInUp');
                    }
                });
            });

            // Password visibility toggle
            document.querySelectorAll('.password-toggle').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    const input = this.parentElement.querySelector('input');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            });

            // Avatar preview
            const avatarUpload = document.getElementById('avatar');
            const modalAvatarPreview = document.getElementById('modalAvatarPreview');
            const mainAvatarPreview = document.getElementById('avatarPreview');

            avatarUpload.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        modalAvatarPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Save avatar
            const saveAvatarBtn = document.getElementById('saveAvatarBtn');
            saveAvatarBtn.addEventListener('click', function() {
                const file = avatarUpload.files[0];
                if (!file) {
                    showToast('Please select an image first.', 'error');
                    return;
                }

                const formData = new FormData();
                formData.append('avatar', file);
                formData.append('_token', '{{ csrf_token() }}');

                saveAvatarBtn.disabled = true;
                saveAvatarBtn.querySelector('.spinner-border').classList.remove('d-none');

                fetch('{{ route('admin.profile.update-avatar') }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            mainAvatarPreview.src = data.avatar_url;
                            modalAvatarPreview.src = data.avatar_url;
                            showToast('Profile picture updated successfully!', 'success');

                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'avatarModal'));
                            modal.hide();

                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showToast(data.message || 'Error updating picture.', 'error');
                        }
                    })
                    .catch(error => {
                        showToast('An error occurred. Please try again.', 'error');
                    })
                    .finally(() => {
                        saveAvatarBtn.disabled = false;
                        saveAvatarBtn.querySelector('.spinner-border').classList.add('d-none');
                    });
            });

            // Profile form submission
            const profileForm = document.getElementById('profileForm');
            const submitBtn = document.getElementById('submitBtn');

            profileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                clearErrors();

                submitBtn.disabled = true;
                submitBtn.querySelector('.spinner-border').classList.remove('d-none');

                const formData = new FormData(this);

                fetch('{{ route('admin.profile.update') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Profile updated successfully!', 'success');
                            setTimeout(() => window.location.reload(), 1500);
                        } else if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                const errorElement = document.getElementById(field + 'Error');
                                const input = document.getElementById(field);
                                if (errorElement && input) {
                                    input.classList.add('is-invalid');
                                    errorElement.textContent = data.errors[field][0];
                                }
                            });
                            showToast('Please correct the errors in the form.', 'error');
                        } else {
                            showToast(data.message || 'Error updating profile.', 'error');
                        }
                    })
                    .catch(error => {
                        showToast('An error occurred. Please try again.', 'error');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.querySelector('.spinner-border').classList.add('d-none');
                    });
            });

            // Password form submission
            const passwordForm = document.getElementById('passwordForm');
            const passwordSubmitBtn = document.getElementById('passwordSubmitBtn');

            passwordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                clearErrors();

                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('new_password_confirmation').value;

                if (newPassword !== confirmPassword) {
                    document.getElementById('new_password').classList.add('is-invalid');
                    document.getElementById('new_password_confirmation').classList.add('is-invalid');
                    document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
                    showToast('Passwords do not match.', 'error');
                    return;
                }

                passwordSubmitBtn.disabled = true;
                passwordSubmitBtn.querySelector('.spinner-border').classList.remove('d-none');

                const formData = new FormData(this);

                fetch('{{ route('admin.profile.change-password') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Password updated successfully!', 'success');
                            passwordForm.reset();
                            clearErrors();
                        } else if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                const errorElement = document.getElementById(field + 'Error');
                                const input = document.getElementById(field);
                                if (errorElement && input) {
                                    input.classList.add('is-invalid');
                                    errorElement.textContent = data.errors[field][0];
                                }
                            });
                            showToast('Please correct the errors in the form.', 'error');
                        } else {
                            showToast(data.message || 'Error changing password.', 'error');
                        }
                    })
                    .catch(error => {
                        showToast('An error occurred. Please try again.', 'error');
                    })
                    .finally(() => {
                        passwordSubmitBtn.disabled = false;
                        passwordSubmitBtn.querySelector('.spinner-border').classList.add('d-none');
                    });
            });

            // Cancel buttons
            document.getElementById('cancelBtn').addEventListener('click', () => window.location.reload());
            document.getElementById('passwordCancelBtn').addEventListener('click', () => {
                passwordForm.reset();
                clearErrors();
            });

            // Helper functions
            function showToast(message, type) {
                Swal.fire({
                    toast: true,
                    icon: type,
                    title: message,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: type === 'success' ? '#10b981' : '#ef4444',
                    color: 'white',
                    customClass: {
                        popup: 'border-0'
                    }
                });
            }

            function clearErrors() {
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            }
        });
    </script>
@endsection
