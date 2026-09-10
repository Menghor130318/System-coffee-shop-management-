<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>

    </form>
<ul class="navbar-nav navbar-right">

        @if (isset($pendingOrdersCount) && $pendingOrdersCount > 0)
            <li class="dropdown">
                <a href="{{ route('order.index') }}" class="nav-link nav-link-lg has-icon position-relative">
                    <i class="fas fa-bell"></i>
                    <span class="badge badge-danger" style="position:absolute; top:5px; right:5px; font-size:0.6rem;">{{ $pendingOrdersCount }}</span>
                </a>
            </li>
        @endif
        <li class="dropdown dropdown-list-toggle">
            <a href="javascript:void(0)" class="nav-link nav-link-lg" id="theme-toggle-btn" title="Switch Theme">
                <i class="fas fa-moon" id="theme-icon"></i>
            </a>
        </li>

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                @if (auth()->user()->avatar && file_exists(public_path(auth()->user()->avatar)))
                    <img alt="image" src="{{ asset(auth()->user()->avatar) }}" class="rounded-circle mr-1" style="width:30px; height:30px; object-fit:cover;">
                @else
                    <img alt="image" src="{{ asset('img/duck-logo.svg') }}" class="rounded-circle mr-1" style="width:30px; height:30px; object-fit:cover;">
                @endif
<div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->full_name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
<div class="dropdown-title">Logged in 5 min ago</div>
                <a href="{{ route('customer.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="{{ route('my.orders') }}" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> My Orders
                </a>
                <a href="{{ route('menu') }}" class="dropdown-item has-icon">
                    <i class="fas fa-mug-hot"></i> Menu
                </a>
                <div class="dropdown-divider"></div>
                <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
