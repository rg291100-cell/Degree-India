<!-- ========== Left Sidebar Start ========== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* .vertical-menu {
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);

        min-height: 100vh;
        padding: 25px 11px;
        position: fixed;
        left: 0;
        top: 67px;
        bottom: 50px;
        overflow-y: auto;
        box-shadow: 5px 0 20px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    } */

    .vertical-menu {
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        position: fixed;
        left: 0;
        top: 67px;
        /* bottom: 50px;  // isko hata do */
        height: calc(100vh - 67px);
        width: 260px;
        padding: 25px 11px;
        overflow-y: auto;
        box-shadow: 5px 0 20px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .vertical-menu::-webkit-scrollbar {
        width: 6px;
    }

    .vertical-menu::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .vertical-menu::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    .vertical-menu::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    .sidebar-logo {
        text-align: center;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }

    .sidebar-logo .logo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        color: white;
        text-decoration: none;
    }

    .logo-badge {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transform: rotate(45deg);
    }

    .logo-badge-inner {
        width: 35px;
        height: 35px;
        border: 3px solid #2563eb;
        border-radius: 8px;
    }

    .logo-badge-cap {
        position: absolute;
        font-size: 22px;
        transform: rotate(-45deg);
    }

    .logo-text {
        text-align: left;
    }

    .logo-text .degree {
        font-size: 22px;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -0.5px;
    }

    .logo-text .india {
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 1.5px;
        opacity: 0.9;
        margin-top: 3px;
    }

    .vertical-menu ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .menu-section {
        margin-bottom: 30px;
    }

    .menu-section-title {
        color: rgb(4 4 4);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
        padding-left: 15px;
    }

    .vertical-menu li {
        margin-bottom: 8px;
    }

    .vertical-menu a {
        display: flex;
        align-items: center;
        gap: 14px;
        color: rgba(255, 255, 255, 0.9);
        background: transparent;
        border: none;
        border-radius: 12px;
        padding: 14px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
        font-weight: 500;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .vertical-menu a i {
        font-size: 20px;
        width: 24px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .vertical-menu a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: white;
        transform: translateX(-10px);
        transition: transform 0.3s ease;
        border-radius: 0 4px 4px 0;
    }

    .vertical-menu a.active-link,
    .vertical-menu li.mm-active>a {
        background: rgba(255, 255, 255, 0.15);
        color: #2563eb !important;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }

    .vertical-menu a.active-link::before,
    .vertical-menu li.mm-active>a::before {
        transform: translateX(0);
    }

    .vertical-menu a.active-link i,
    .vertical-menu li.mm-active>a i {
        color: #2563eb !important;
        transform: scale(1.1);
    }

    .vertical-menu a:hover:not(.active-link) {
        background: rgba(255, 255, 255, 0.08);
        color: white;
        transform: translateX(5px);
    }

    .vertical-menu a:hover:not(.active-link) i {
        transform: translateX(2px);
    }

    .menu-badge {
        margin-left: auto;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 10px;
        min-width: 20px;
        text-align: center;
    }

    .menu-badge.new {
        background: #10b981;
    }

    .menu-badge.pending {
        background: #f59e0b;
    }

    /* Responsive optimization */
    @media (max-width: 768px) {
        .vertical-menu {
            width: 240px;
            padding: 20px 15px;
        }

        .logo-badge {
            width: 40px;
            height: 40px;
        }

        .logo-badge-cap {
            font-size: 18px;
        }

        .logo-text .degree {
            font-size: 18px;
        }

        .logo-text .india {
            font-size: 11px;
        }

        .vertical-menu a {
            padding: 12px 16px;
            font-size: 14px;
        }

        .vertical-menu a i {
            font-size: 18px;
        }
    }

    @media (max-width: 576px) {
        .vertical-menu {
            width: 100%;
            position: relative;
            min-height: auto;
            padding: 15px;
        }

        .sidebar-logo {
            margin-bottom: 20px;
            padding-bottom: 15px;
        }

        .logo {
            justify-content: flex-start;
        }
    }
</style>

<div class="vertical-menu">


    <!-- Menu Items -->
    <ul>
        @php
            $role = auth()->user()->role_id;
        @endphp
        <!-- Main Section -->


        @hasPermission('view-dashboard')
            <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"
                    class="waves-effect {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                    <i class="fas fa-th-large"></i>
                    Dashboard
                </a>
            </li>
        @endhasPermission

        <!-- Course Management (only if permission exists) -->
        @hasPermission('view-courses')
            <li class="{{ request()->routeIs('admin.courses.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.courses.index') }}"
                    class="waves-effect {{ request()->routeIs('admin.courses.*') ? 'active-link' : '' }}">
                    <i class="fas fa-book-open"></i>
                    Course Management
                </a>
            </li>
        @endhasPermission


        @hasPermission('view-colleges')
            <li class="{{ request()->routeIs('admin.colleges.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.colleges.index') }}"
                    class="waves-effect {{ request()->routeIs('admin.colleges.*') ? 'active-link' : '' }}">
                    <i class="fas fa-university"></i>
                    College Management
                </a>
            </li>
        @endhasPermission

        @hasPermission('view-categories')
            <li class="{{ request()->routeIs('admin.categories') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.categories.index') }}"
                    class="waves-effect {{ request()->routeIs('admin.categories') ? 'active-link' : '' }}">
                    <i class="fas fa-tags"></i>
                    Categories / Fields

                </a>
            </li>
        @endhasPermission


        <!-- Admission Section -->


        {{-- <li class="">
            <a href="#" class="">
                <i class="fas fa-graduation-cap"></i>
                My Admission Desk
            </a>
        </li> --}}
        @hasPermission(['view-student', 'view-admission'])
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#studentManagementMenu"
                    role="button" aria-expanded="false" aria-controls="studentManagementMenu">
                    <i class="fas fa-user-graduate me-2"></i>
                    <span>Student Management</span>
                    <i class="fas fa-angle-down ms-auto"></i>
                </a>

                <ul class="collapse list-unstyled ps-3" id="studentManagementMenu" data-bs-parent="#sidebarMenu">
                    <!-- All Students -->
                    <li class="{{ request()->routeIs('admin.students.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.students.index') }}"
                            class="waves-effect {{ request()->routeIs('admin.students.*') ? 'active-link' : '' }}">
                            <i class="fas fa-users me-2"></i>
                            All Students
                        </a>
                    </li>

                    <!-- Admission -->
                    <li class="{{ request()->routeIs('admin.admission.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.admission.index') }}"
                            class="waves-effect {{ request()->routeIs('admin.admission.*') ? 'active-link' : '' }}">
                            <i class="fas fa-user-plus me-2"></i>
                            Admission
                            @php
                                $pendingCount = \App\Models\Admission::where('admission_status', 'pending')->count();
                            @endphp
                            @if ($pendingCount > 0)
                                <span class="badge bg-danger float-end ms-2" id="pendingAdmissionCount">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        </a>
                    </li>


                </ul>
            </li>
        @endhasPermission



        @hasPermission('view-book-session')
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center collapsed" data-bs-toggle="collapse" href="#bookingMenu"
                    role="button"
                    aria-expanded="{{ request()->routeIs('admin.booking-slot.*') || request()->routeIs('admin.slots.*') ? 'true' : 'false' }}"
                    aria-controls="bookingMenu">
                    <i class="fas fa-calendar-check me-2"></i>
                    <span>Booking Management</span>
                    <i class="fas fa-angle-down ms-auto"></i>
                </a>

                <div class="collapse {{ request()->routeIs('admin.booking-slot.*') || request()->routeIs('admin.slots.*') ? 'show' : '' }}"
                    id="bookingMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item {{ request()->routeIs('admin.booking-slot.*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.booking-slot.index') }}"
                                class="nav-link {{ request()->routeIs('admin.booking-slot.*') ? 'active' : '' }}">

                                Booked Sessions
                            </a>
                        </li>
                        @hasPermission('view-slots')
                            <li class="nav-item {{ request()->routeIs('admin.slots.*') ? 'mm-active' : '' }}">
                                <a href="{{ route('admin.slots.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.slots.*') ? 'active' : '' }}">
                                    Slots Manage
                                </a>
                            </li>
                        @endhasPermission
                    </ul>
                </div>
            </li>
        @endhasPermission





        @hasPermission('view-why-join')
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#whyJoinMenu" role="button"
                    aria-expanded="false" aria-controls="whyJoinMenu">
                    <i class="fas fa-list me-2"></i>
                    <span>Home</span>
                    <i class="fas fa-angle-down ms-auto"></i>
                </a>

                <ul class="collapse list-unstyled ps-3" id="whyJoinMenu" data-bs-parent="#sidebarMenu">
                    <li class="{{ request()->routeIs('admin.why-join-features.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.why-join-features.index') }}"
                            class="waves-effect {{ request()->routeIs('admin.why-join-features.*') ? 'active-link' : '' }}">
                            <i class="fas fa-star me-2"></i>
                            <span>Why Join Us</span>
                        </a>
                    </li>

                    <!-- Banner Menu Item -->
                    <li class="{{ request()->routeIs('admin.banners.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.banners.index') }}"
                            class="waves-effect {{ request()->routeIs('admin.banners.*') ? 'active-link' : '' }}">
                            <i class="fas fa-images me-2"></i>
                            <span>Banner</span>
                        </a>
                    </li>

                    <!-- Testimonials Menu Item -->
                    <li class="{{ request()->routeIs('admin.testimonials.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.testimonials.index') }}"
                            class="waves-effect {{ request()->routeIs('admin.testimonials.*') ? 'active-link' : '' }}">
                            <i class="fas fa-quote-right me-2"></i>
                            <span>Testimonials</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.expert-tips.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.expert-tips.index') }}"
                            class="waves-effect {{ request()->routeIs('admin.expert-tips.*') ? 'active-link' : '' }}">
                            <i class="fas fa-lightbulb me-2"></i>
                            <span>Expert Tips</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endhasPermission

        {{-- @hasPermission('view-registration-flow') --}}
        <li class="{{ request()->routeIs('admin.register-contect.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.register-contect.create') }}"
                class="waves-effect {{ request()->routeIs('admin.register-contect.*') ? 'active-link' : '' }}">
                <i class="fas fa-user-plus me-2"></i>
                Registration Flow
            </a>
        </li>
        {{-- @endhasPermission --}}


        {{-- <li class="">
            <a href="#" class="">
                <i class="fas fa-money-bill-wave me-2"></i>
                Application fee
            </a>
        </li> --}}

        <!-- Content Section -->
        @hasPermission('view-blogs')
            <li class="{{ request()->routeIs('admin.blogs.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.blogs.index') }}"
                    class="waves-effect {{ request()->routeIs('admin.blogs.*') ? 'active-link' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    Blogs / Articles
                </a>
            </li>
        @endhasPermission



        <!-- User Management Section -->


        @hasPermission('view-users')
            <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}" class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    User Management
                </a>
            </li>
        @endhasPermission


        <!-- Settings Section -->


        @hasPermission('manage-settings')
            <li class="{{ request()->routeIs('admin.settings.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.settings.index') }}"
                    class="waves-effect {{ request()->routeIs('admin.settings.*') ? 'active-link' : '' }}">
                    <i class="fas fa-cog"></i>
                    App Settings
                </a>
            </li>
        @endhasPermission

        <!-- Add this section to your sidebar -->
        @hasPermission('view-roles')
            <li class="{{ request()->routeIs('admin.roles.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.roles.index') }}"
                    class="waves-effect {{ request()->routeIs('admin.roles.*') ? 'active-link' : '' }}">
                    <i class="fas fa-user-tag"></i>
                    Role & Permission
                </a>
            </li>
        @endhasPermission

        <!-- Logout -->

        <li>
            <a href="{{ route('admin.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="waves-effect logout-btn">
                <i class="fas fa-power-off"></i>
                Logout
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="GET" style="display: none;">
                @csrf
            </form>
        </li>

    </ul>
</div>
<!-- Left Sidebar End -->
