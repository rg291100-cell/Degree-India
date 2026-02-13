<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">

            <!-- LOGO - Academic Badge Design (Logo 2) -->
            <div class="navbar-brand-box">
                <!-- Small Screen Logo -->
                <a href="#" target="_blank" class="logo logo-dark">
                    <span class="logo-sm">
                        <div class="logo-2-sm" style="display: flex; align-items: center; gap: 8px;">
                            <div class="logo-2-badge-sm"
                                style="width: 25px; height: 25px; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; position: relative; transform: rotate(45deg);margin-left: 4px;">
                                <div style="width: 22px; height: 22px; border: 2px solid #2563eb; border-radius: 5px;">
                                </div>
                                <span style="font-size: 14px; transform: rotate(-45deg); position: absolute;">🎓</span>
                            </div>
                            <span style="color: white; font-weight: 600; font-size: 14px; line-height: 1;">
                                <div>DEGREE</div>
                                <div style="font-size: 11px; opacity: 0.9;">INDIA</div>
                            </span>
                        </div>
                    </span>

                    <!-- Large Screen Logo -->
                    <span class="logo-lg">
                        <div class="logo-2-lg" style="display: flex; align-items: center; gap: 15px;">
                            <div class="logo-2-badge-lg"
                                style="width: 50px; height: 50px; background: white; border-radius: 15px; display: flex; align-items: center; justify-content: center; position: relative; transform: rotate(45deg);margin-left: 38px;">
                                <div style="width: 45px; height: 45px; border: 3px solid #2563eb; border-radius: 10px;">
                                </div>
                                <span style="font-size: 24px; transform: rotate(-45deg); position: absolute;">🎓</span>
                            </div>
                            <div style="color: white; text-align: left;">
                                <div style="font-size: 28px; font-weight: 800; line-height: 1; letter-spacing: -0.5px;">
                                    DEGREE</div>
                                <div
                                    style="font-size: 16px; font-weight: 600; margin-top: 2px; letter-spacing: 1.5px; opacity: 0.9;">
                                    INDIA</div>
                            </div>
                        </div>
                    </span>
                </a>

                <!-- Alternative Logo for Light Theme -->
                <a href="#" target="_blank" class="logo logo-light">
                    <span class="logo-sm">
                        <div style="color: white; text-align: center; padding: 5px 0;">
                            <div style="display: inline-flex; align-items: center; gap: 6px;">
                                <div
                                    style="width: 26px; height: 26px; background: white; border-radius: 6px; display: flex; align-items: center; justify-content: center; transform: rotate(45deg);">
                                    <span style="font-size: 12px; transform: rotate(-45deg);">🎓</span>
                                </div>
                                <div style="font-size: 14px; font-weight: 700;">DI</div>
                            </div>
                        </div>
                    </span>
                    <span class="logo-lg">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div
                                style="width: 50px; height: 50px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; transform: rotate(45deg);">
                                <div style="width: 35px; height: 35px; border: 2px solid #2563eb; border-radius: 8px;">
                                </div>
                                <span style="font-size: 20px; transform: rotate(-45deg); position: absolute;">🎓</span>
                            </div>
                            <div style="color: white; text-align: left;">
                                <div style="font-size: 24px; font-weight: 800; line-height: 1;">DEGREE</div>
                                <div style="font-size: 14px; font-weight: 600; margin-top: 2px;">INDIA</div>
                            </div>
                        </div>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>

        </div>

        <!-- Search input -->
        <div class="search-wrap" id="search-wrap">
            <div class="search-bar">
                <input class="search-input form-control" placeholder="Search" />
                <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                    <i class="mdi mdi-close-circle"></i>
                </a>
            </div>
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item toggle-search noti-icon waves-effect"
                    data-target="#search-wrap">
                    <i class="mdi mdi-magnify"></i>
                </button>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80' }}"
                        alt="Header Avatar" class="rounded-circle header-profile-user">

                    <span class="d-none d-xl-inline-block ms-1">
                        {{ Auth::user()->name }}
                    </span>

                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="mdi mdi-account-circle-outline font-size-16 align-middle me-1"></i>
                        Profile
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('admin.logout') }}" method="GET" style="display: none;">
                        @csrf
                    </form>

                </div>
            </div>

        </div>
    </div>
</header>

<style>
    /* Logo Styling */
    .navbar-brand-box {
        padding: 10px 0;
    }

    .logo-2-sm,
    .logo-2-lg {
        display: flex;
        align-items: center;
    }

    .logo-2-badge-sm,
    .logo-2-badge-lg {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    /* Academic Badge Design - Graduation Cap in Diamond Shape */
    .logo-2-badge-sm {
        width: 32px;
        height: 32px;
        background: white;
        border-radius: 8px;
        transform: rotate(45deg);
    }

    .logo-2-badge-lg {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 15px;
        transform: rotate(45deg);
    }

    /* Inner square border */
    .logo-2-badge-sm>div,
    .logo-2-badge-lg>div {
        border: 2px solid #2563eb;
        transform: rotate(0deg);
    }

    /* Graduation cap emoji */
    .logo-2-badge-sm span,
    .logo-2-badge-lg span {
        position: absolute;
        font-size: 14px;
        transform: rotate(-45deg);
    }

    .logo-2-badge-lg span {
        font-size: 24px;
    }

    /* Text Styling */
    .logo-2-sm>span,
    .logo-2-lg>div {
        color: white;
        text-align: left;
    }

    /* Large screen text */
    .logo-lg .logo-2-lg>div>div:first-child {
        font-size: 28px;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -0.5px;
    }

    .logo-lg .logo-2-lg>div>div:last-child {
        font-size: 16px;
        font-weight: 600;
        margin-top: 2px;
        letter-spacing: 1.5px;
        opacity: 0.9;
    }

    /* Small screen text */
    .logo-sm .logo-2-sm>span>div:first-child {
        font-size: 8px;
        font-weight: 500;
        line-height: 1;
    }

    .logo-sm .logo-2-sm>span>div:last-child {
        font-size: 11px;
        opacity: 0.9;
        margin-top: 1px;
    }



    .btn.header-item:hover {
        background: rgba(255, 255, 255, 0.15) !important;
    }

    /* Search Bar */
    .search-wrap {
        background: rgba(255, 255, 255, 0.95) !important;
        border-radius: 8px;
        padding: 5px;
    }

    .search-input {
        border: 2px solid #2563eb !important;
        border-radius: 6px !important;
    }

    .search-input:focus {
        border-color: #1d4ed8 !important;
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25) !important;
    }

    /* User Dropdown */
    .header-profile-user {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .dropdown-menu {
        border: 1px solid rgba(37, 99, 235, 0.15) !important;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px !important;
    }

    .dropdown-item {
        padding: 8px 16px;
        font-size: 14px;
    }

    .dropdown-item:hover {
        background-color: #eff6ff;
        color: #2563eb;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .logo-2-lg {
            gap: 10px;
        }

        .logo-2-badge-lg {
            width: 50px;
            height: 50px;
        }

        .logo-lg .logo-2-lg>div>div:first-child {
            font-size: 22px;
        }

        .logo-lg .logo-2-lg>div>div:last-child {
            font-size: 14px;
        }
    }

    @media (max-width: 576px) {
        .logo-2-lg {
            gap: 8px;
        }

        .logo-2-badge-lg {
            width: 40px;
            height: 40px;
        }

        .logo-2-badge-lg span {
            font-size: 18px;
        }

        .logo-lg .logo-2-lg>div>div:first-child {
            font-size: 18px;
        }

        .logo-lg .logo-2-lg>div>div:last-child {
            font-size: 12px;
            letter-spacing: 1px;
        }
    }
</style>
