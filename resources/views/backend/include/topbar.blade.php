<nav class="sb-topnav navbar navbar-expand navbar-dark">
    <!-- Logo -->
    <a class="navbar-brand text-center ps-3" target="_blank" href="/">
        <img src="{{ Helper::getSettings('site_logo') ? asset(Helper::getSettings('site_logo')) : 'assets/img/Logo.png' }}"
            width="52px" alt="Logo">
    </a>

    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Profile Dropdown -->
    <ul class="ms-auto me-0 me-md-3 my-2 my-md-0 me-lg-4 gap-3">
        <li class="nav-item dropdown">
            <!-- Profile Trigger with Bootstrap data attributes -->
            <a class="nav-link dropdown-toggle profile-trigger" href="#" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img class="profile-img"
                    src="{{ Auth::user()->profile_image ? asset('uploads/user-images/' . Auth::user()->profile_image) : asset('assets/img/no-img.jpg') }}"
                    alt="{{ Auth::user()->name }}">
                <span class="ms-2 d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>

            <!-- Dropdown Menu -->
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li class="dropdown-header">
                    <div class="d-flex align-items-center">
                        <img class="dropdown-avatar"
                            src="{{ Auth::user()->profile_image ? asset('uploads/user-images/' . Auth::user()->profile_image) : asset('assets/img/no-img.jpg') }}"
                            alt="{{ Auth::user()->name }}">
                        <div class="ms-3">
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="fa fa-user me-2"></i> Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.profile.setting') }}">
                        <i class="fa-solid fa-gear me-2"></i> Change Password
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<style>
    /* Simple working dropdown styles */
    .profile-trigger {
        display: flex;
        align-items: center;
        color: rgba(255, 255, 255, 0.8) !important;
        padding: 5px 10px;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .profile-trigger:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white !important;
    }

    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.3);
        background: #fff;
    }

    .dropdown-menu {
        min-width: 250px;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        border-radius: 8px;
        padding: 10px 0;
    }

    .dropdown-header {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    .dropdown-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #0f3d28;
    }

    .dropdown-item {
        padding: 8px 20px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .dropdown-item:hover {
        background: rgba(15, 61, 40, 0.1);
        padding-left: 25px;
    }

    .dropdown-item i {
        width: 20px;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .profile-trigger span {
            display: none;
        }
    }
</style>