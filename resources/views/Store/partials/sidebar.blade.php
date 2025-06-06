<!-- resources/views/partials/sidebar.blade.php -->
<style>
    .sidebar .nav .nav-item.active > .nav-link {
        background: #8f8f8f !important;
    }
    .sidebar .nav:not(.sub-menu) > .nav-item:hover:not(.nav-category):not(.account-dropdown) > .nav-link {
        background: #8f8f8f !important;
        color: #0F172A !important;
    }
</style>
<nav class="sidebar sidebar-offcanvas" id="sidebar" style="background: #0B1120">

    <ul class="sidebar-brand-wrapper d-lg-flex align-items-center justify-content-center fixed-top  "
        style="background: #0F172A">

        <li class="nav-item dropdown me-5" style=" list-style-type: none;">
            <a class="nav-link " id="profileDropdown" href="#" data-bs-toggle="dropdown">
                <div class="navbar-profile d-flex gap-2" style="color: white">

                    <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ Auth::guard('store')->user()->name }}</p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                    <img class="img-xs rounded-circle" 
                            src="{{ Auth::guard('store')->user()->image ? asset(Auth::guard('store')->user()->image) : asset('assets/images/dashboard/avatar.png') }}" 
                            alt="">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="profileDropdown"
                style="background: white">
                <a class="dropdown-item preview-item d-flex align-items-center justify-content-center"
                    href="{{ route('store.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="preview-thumbnail">
                        <div class="preview-icon bg-dark rounded-circle">
                            <i class="mdi mdi-logout text-danger"></i>
                        </div>
                    </div>
                    <div class="preview-item-content">
                        <p class="preview-subject mb-1 " style="color: black">Log out</p>
                    </div>
                </a>
                <form id="logout-form" action="{{ route('store.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic d-flex align-items-center justify-content-end gap-2 w-100">

                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{ Auth::guard('store')->user()->name }}</h5>
                        <span>online</span>
                    </div>
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle" 
                            src="{{ Auth::guard('store')->user()->image ? asset(Auth::guard('store')->user()->image) : asset('assets/images/dashboard/avatar.png') }}" 
                            alt="">
                        <span class="count bg-success"></span>
                    </div>
                </div>
            </div>
        </li>

        <li class="nav-item menu-items my-1">
            <a class="nav-link d-flex gap-2" href="{{ route('store.dashboard') }}">

                <span class="menu-title ms-5">الصفحة الرئيسية</span>
                <span class="menu-icon">
                    <i class="mdi mdi-speedometer"></i>
                </span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link d-flex d-block w-100 justify-content-end" href="{{ route('store.orders.index') }}">

                <span class="menu-title me-2">الطلبات</span>
                <span class="menu-icon">
                    <i class="fa fa-shopping-cart"></i>
                </span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link d-flex d-block w-100 justify-content-end" href="{{ route('store.categories.index') }}">

                <span class="menu-title me-2">الفئات</span>
                <span class="menu-icon">
                    <i class="fa fa-tags"></i>
                </span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link d-flex d-block w-100 justify-content-end" href="{{ route('store.products.index') }}">

                <span class="menu-title me-2">المنتجات</span>
                <span class="menu-icon">
                    <i class="fa fa-cubes"></i>
                </span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link d-flex d-block w-100 justify-content-end" href="{{ route('store.profile.index') }}">

                <span class="menu-title me-2">البيانات الشخصية</span>
                <span class="menu-icon">
                    <i class="fa fa-user"></i>
                </span>
            </a>
        </li>

    </ul>
</nav>