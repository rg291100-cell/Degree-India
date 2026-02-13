@extends('admin.layouts.master')
@section('title')
    Dashboard
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
    }

    .dashboard-content {
        padding: 25px;
        background: #f8fafc;
        min-height: calc(100vh - 70px);
    }

    .dashboard-header {
        margin-bottom: 30px;
    }

    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .dashboard-header p {
        color: var(--text-light);
        font-size: 1rem;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: var(--white);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid var(--border-color);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(37, 99, 235, 0.12);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-blue), var(--accent-blue));
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: var(--white);
    }

    .stat-icon.courses {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    .stat-icon.colleges {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .stat-icon.students {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .stat-icon.sessions {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .stat-content h3 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 8px;
        line-height: 1;
    }

    .stat-content p {
        color: var(--text-light);
        font-size: 0.95rem;
        margin-bottom: 0;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .trend-up {
        color: #10b981;
    }

    .trend-down {
        color: #ef4444;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .content-card {
        background: var(--white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        padding: 20px;
    }

    .card-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        background: var(--light-blue);
    }

    .card-header h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .card-header h3 i {
        color: var(--primary-blue);
    }

    .card-body {
        padding: 24px;
    }

    /* Popular Categories */
    .category-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .category-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        border-radius: 10px;
        background: var(--light-blue);
        transition: background 0.2s ease;
    }

    .category-item:hover {
        background: #e0f2fe;
    }

    .category-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .category-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--white);
        color: var(--primary-blue);
        font-size: 18px;
    }

    .category-name {
        font-weight: 600;
        color: var(--text-dark);
    }

    .category-stats {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .category-count {
        font-weight: 700;
        color: var(--primary-blue);
        font-size: 1.1rem;
    }

    .category-trend {
        font-size: 0.8rem;
        padding: 2px 8px;
        border-radius: 12px;
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        font-weight: 600;
    }

    /* Latest Admissions */
    .admissions-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .admission-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: border-color 0.2s ease;
    }

    .admission-item:hover {
        border-color: var(--primary-blue);
    }

    .admission-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .admission-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .admission-details h4 {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .admission-details p {
        color: var(--text-light);
        font-size: 0.9rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .admission-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-approved {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .status-rejected {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    /* View All Link */
    .view-all {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
        margin-top: 20px;
    }

    .view-all a {
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s ease;
    }

    .view-all a:hover {
        color: var(--secondary-blue);
        text-decoration: underline;
    }

    /* Quick Stats */
    .quick-stats {
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        border-radius: 16px;
        padding: 30px;
        color: white;
        margin-bottom: 40px;
    }

    .quick-stats h2 {
        font-size: 1.5rem;
        margin-bottom: 25px;
        font-weight: 600;
        color: white !important;
    }

    .quick-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .quick-stat-item {
        padding: 20px;
        background: rgb(255 255 255 / 18%);
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .quick-stat-item h4 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 8px;
        color: white !important;
    }

    .quick-stat-item p {
        font-size: 0.95rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-content {
            padding: 20px 15px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .content-grid {
            grid-template-columns: 1fr;
        }

        .quick-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .stat-card {
            padding: 20px;
        }

        .stat-content h3 {
            font-size: 2rem;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .quick-stats-grid {
            grid-template-columns: 1fr;
        }

        .admission-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .admission-status {
            margin-top: 8px;
        }
    }
</style>

@section('content')
    <div class="dashboard-content">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h1>Welcome Back, <?= $currentRole ?> !</h1>
            <p>Here's what's happening with Degree India today.</p>
        </div>

        <!-- Quick Stats Banner -->
        {{-- <div class="quick-stats">
            <h2><i class="fas fa-chart-line me-2"></i> Today's Overview</h2>
            <div class="quick-stats-grid">
                <div class="quick-stat-item">
                    <h4>{{ $newStudentsToday }}</h4>
                    <p>New Students</p>
                </div>
                <div class="quick-stat-item">
                    <h4>{{ $newSessionsToday }}</h4>
                    <p>New Sessions</p>
                </div>
                <div class="quick-stat-item">
                    <h4>{{ $admissionsToday }}</h4>
                    <p>Admissions</p>
                </div>
                <div class="quick-stat-item">
                    <h4>{{ $successRate }}%</h4>
                    <p>Success Rate</p>
                </div>
            </div>
        </div> --}}

        <!-- Main Stats Cards -->
        <div class="stats-grid">
            <!-- Total Courses -->
            <div class="stat-card">
                <div class="stat-icon courses">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalCourses }}</h3>
                    <p>Total Courses</p>
                    <div class="stat-trend {{ $coursesGrowth >= 0 ? 'trend-up' : 'trend-down' }}">
                        <i class="fas fa-arrow-{{ $coursesGrowth >= 0 ? 'up' : 'down' }}"></i>
                        <span>{{ abs($coursesGrowth) }}% from last month</span>
                    </div>
                </div>
            </div>

            <!-- Total Colleges -->
            <div class="stat-card">
                <div class="stat-icon colleges">
                    <i class="fas fa-university"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalColleges }}</h3>
                    <p>Total Colleges</p>
                    <div class="stat-trend {{ $collegesGrowth >= 0 ? 'trend-up' : 'trend-down' }}">
                        <i class="fas fa-arrow-{{ $collegesGrowth >= 0 ? 'up' : 'down' }}"></i>
                        <span>{{ abs($collegesGrowth) }}% from last month</span>
                    </div>
                </div>
            </div>

            <!-- Total Students -->
            <div class="stat-card">
                <div class="stat-icon students">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalStudents }}</h3>
                    <p>Total Students</p>
                    <div class="stat-trend {{ $studentsGrowth >= 0 ? 'trend-up' : 'trend-down' }}">
                        <i class="fas fa-arrow-{{ $studentsGrowth >= 0 ? 'up' : 'down' }}"></i>
                        <span>{{ abs($studentsGrowth) }}% from last month</span>
                    </div>
                </div>
            </div>

            <!-- Booked Counselling Sessions -->
            <div class="stat-card">
                <div class="stat-icon sessions">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalSessions }}</h3>
                    <p>Booked Sessions</p>
                    <div class="stat-trend {{ $sessionsGrowth >= 0 ? 'trend-up' : 'trend-down' }}">
                        <i class="fas fa-arrow-{{ $sessionsGrowth >= 0 ? 'up' : 'down' }}"></i>
                        <span>{{ abs($sessionsGrowth) }}% from last week</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Popular Categories -->
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-chart-pie"></i> Popular Categories</h3>
                </div>
                <div class="card-body">
                    <div class="category-list">
                        @foreach ($popularCategories as $category)
                            <div class="category-item">
                                <div class="category-info">
                                    <div class="category-icon">
                                        @php
                                            // Category icon mapping
                                            $icons = [
                                                'Animation & 3D' => 'fas fa-film',
                                                'Engineering' => 'fas fa-cogs',
                                                'Medical' => 'fas fa-heartbeat',
                                                'IT & Computer' => 'fas fa-laptop-code',
                                                'Commerce' => 'fas fa-chart-line',
                                                'default' => 'fas fa-folder',
                                            ];
                                            $icon = $icons[$category->name] ?? $icons['default'];
                                        @endphp
                                        <i class="{{ $icon }}"></i>
                                    </div>
                                    <div class="category-name">{{ $category->name }}</div>
                                </div>
                                <div class="category-stats">
                                    <span class="category-count">{{ $category->courses_count }}</span>
                                    <span class="category-trend">+{{ rand(5, 25) }}%</span>
                                </div>
                            </div>
                        @endforeach

                        @if ($popularCategories->isEmpty())
                            <div class="category-item">
                                <div class="category-info">
                                    <div class="category-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div class="category-name">No categories found</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="view-all">
                        <a href="{{ route('admin.categories.index') }}">
                            View All Categories
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Latest Admissions -->
            {{-- <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-graduation-cap"></i> Latest Admissions</h3>
                </div>
                <div class="card-body">
                    <div class="admissions-list">
                        @foreach ($latestAdmissions as $admission)
                            <div class="admission-item">
                                <div class="admission-info">
                                    <div class="admission-avatar">
                                        {{ substr($admission->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="admission-details">
                                        <h4>{{ $admission->user->name ?? 'Unknown User' }}</h4>
                                        @if ($admission->course)
                                            <p>
                                                <i class="fas fa-book"></i> {{ $admission->course->name }}
                                            </p>
                                        @endif
                                        @if ($admission->college)
                                            <p>
                                                <i class="fas fa-university"></i> {{ $admission->college->name }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="admission-status status-{{ $admission->status ?? 'pending' }}">
                                    {{ ucfirst($admission->status ?? 'Pending') }}
                                </div>
                            </div>
                        @endforeach

                        @if ($latestAdmissions->isEmpty())
                            <div class="admission-item">
                                <div class="admission-info">
                                    <div class="admission-avatar">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div class="admission-details">
                                        <h4>No admissions found</h4>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="view-all">
                        <a href="{{ route('admin.booking-slot.index') }}">
                            View All Admissions
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div> --}}

            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-graduation-cap"></i> Latest Admissions</h3>
                </div>
                <div class="card-body">
                    <div class="admissions-list">
                        <!-- Admission 1 -->
                        <div class="admission-item">
                            <div class="admission-info">
                                <div class="admission-avatar">RP</div>
                                <div class="admission-details">
                                    <h4>Raj Patel</h4>
                                    <p>
                                        <i class="fas fa-book"></i> B.Tech Computer Science
                                    </p>
                                    <p>
                                        <i class="fas fa-university"></i> IIT Delhi
                                    </p>
                                </div>
                            </div>
                            <div class="admission-status status-approved">
                                Approved
                            </div>
                        </div>



                        <!-- Admission 3 -->
                        <div class="admission-item">
                            <div class="admission-info">
                                <div class="admission-avatar">AS</div>
                                <div class="admission-details">
                                    <h4>Aarav Singh</h4>
                                    <p>
                                        <i class="fas fa-film"></i> B.Sc Animation
                                    </p>
                                    <p>
                                        <i class="fas fa-university"></i> NID Ahmedabad
                                    </p>
                                </div>
                            </div>
                            <div class="admission-status status-approved">
                                Approved
                            </div>
                        </div>


                        <!-- Admission 5 -->
                        <div class="admission-item">
                            <div class="admission-info">
                                <div class="admission-avatar">VV</div>
                                <div class="admission-details">
                                    <h4>Vikram Verma</h4>
                                    <p>
                                        <i class="fas fa-cogs"></i> Mechanical Engineering
                                    </p>
                                    <p>
                                        <i class="fas fa-university"></i> BITS Pilani
                                    </p>
                                </div>
                            </div>
                            <div class="admission-status status-pending">
                                Pending
                            </div>
                        </div>
                    </div>
                    <div class="view-all">
                        <a href="{{ route('admin.booking-slot.index') }}">
                            View All Admissions
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const statCards = document.querySelectorAll('.stat-card');

            statCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Update CSS classes for status
            document.querySelectorAll('.admission-status').forEach(status => {
                const text = status.textContent.trim().toLowerCase();
                if (text === 'approved') {
                    status.className = 'admission-status status-approved';
                } else if (text === 'rejected') {
                    status.className = 'admission-status status-rejected';
                } else {
                    status.className = 'admission-status status-pending';
                }
            });
        });
    </script>
@endsection
