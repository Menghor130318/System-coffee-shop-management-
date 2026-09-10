<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coffee Shop Cambodia') &mdash; Coffee Shop Cambodia</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <style>
        :root {
            --coffee-dark: #3E2723;
            --coffee: #6F4E37;
            --coffee-light: #A1887F;
            --cream: #F5F0E6;
            --accent: #C8A96A;
            --accent-dark: #B08D57;
        }

        body {
            font-family: 'Nunito', 'Segoe UI', sans-serif;
            background-color: var(--cream);
            color: #333;
        }

        /* Navigation */
        .customer-nav {
            background: var(--coffee-dark);
            padding: 14px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .customer-nav .brand {
            color: #fff;
            font-size: 1.4rem;
            font-weight: 800;
            text-decoration: none;
        }
        .customer-nav .brand i {
            color: var(--accent);
        }
        .customer-nav .nav-link {
            color: rgba(255,255,255,0.85);
            font-weight: 600;
            margin: 0 8px;
        }
        .customer-nav .nav-link:hover {
            color: var(--accent);
        }
        .customer-nav .cart-badge {
            background: var(--accent);
            color: #fff;
            border-radius: 50%;
            padding: 2px 7px;
            font-size: 0.7rem;
            margin-left: 4px;
        }

        /* Hero */
        .hero-section {
            background: linear-gradient(135deg, #4E342E, #3E2723 60%);
            color: #fff;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 60%;
            height: 200%;
            background: radial-gradient(circle, rgba(200,169,106,0.2) 0%, transparent 70%);
        }
        .hero-section h1 {
            font-size: 3rem;
            font-weight: 800;
        }
        .hero-section .lead {
            color: rgba(255,255,255,0.85);
            font-size: 1.2rem;
        }
        .hero-section .btn-hero {
            background: var(--accent);
            color: var(--coffee-dark);
            font-weight: 700;
            padding: 12px 30px;
            border-radius: 30px;
            border: none;
        }
        .hero-section .btn-hero:hover {
            background: var(--accent-dark);
            color: #fff;
        }

        /* Section titles */
        .section-title {
            color: var(--coffee-dark);
            font-weight: 800;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 10px;
        }
        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }

        /* Product cards */
        .product-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .product-card .product-img {
            height: 200px;
            background: #f5f0e6;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .product-card .product-img img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
        .product-card .product-body {
            padding: 18px;
        }
        .product-card .product-category {
            color: var(--accent-dark);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .product-card .product-name {
            color: var(--coffee-dark);
            font-weight: 700;
            font-size: 1.1rem;
            margin: 6px 0;
        }
        .product-card .product-price {
            color: var(--coffee);
            font-weight: 800;
            font-size: 1.2rem;
        }
        .product-card .btn-add {
            background: var(--coffee-dark);
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
        }
        .product-card .btn-add:hover {
            background: var(--accent-dark);
            color: #fff;
        }

/* Dashboard specific */
        .category-heading {
            color: var(--coffee-dark);
            font-weight: 800;
        }
        .text-category {
            color: var(--accent-dark);
            font-size: 1.4rem;
        }
        .badge-cat {
            background: var(--accent);
            color: #fff;
            font-weight: 600;
        }
        .badge-sale {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #e74c3c;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
        }
        .price-old {
            color: #999;
            text-decoration: line-through;
            font-size: 0.85rem;
            margin-left: 6px;
        }
        .product-desc {
            color: #777;
            font-size: 0.85rem;
            margin-bottom: 0;
        }
        .product-img {
            position: relative;
        }
.bg-light-section {
            background: #f8f5ef;
        }

/* Coffee pagination */
        .coffee-pagination .page-link {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--coffee-dark);
            background: #fff;
            border: 1px solid #e0d6c8;
            border-radius: 8px;
            margin: 0 3px;
            transition: all 0.25s;
        }
        .coffee-pagination .page-link:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }
        .coffee-pagination .page-item.active .page-link {
            background: var(--coffee-dark);
            border-color: var(--coffee-dark);
            color: #fff;
        }
        .coffee-pagination .page-item.disabled .page-link {
            color: #bbb;
            background: #f5f5f5;
            border-color: #eee;
        }

        /* Footer */
        .customer-footer {
            background: var(--coffee-dark);
            color: rgba(255,255,255,0.8);
            padding: 40px 0 20px;
            margin-top: 60px;
        }
        .customer-footer h5 {
            color: #fff;
            font-weight: 700;
        }
        .customer-footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
        }
        .customer-footer a:hover {
            color: var(--accent);
        }
        .customer-footer .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 15px;
            margin-top: 30px;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg customer-nav">
        <div class="container">
            <a class="brand" href="{{ route('menu') }}"><i class="fas fa-coffee"></i> Coffee Shop Cambodia</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#customerNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="customerNav">
<ul class="navbar-nav ml-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.dashboard') }}"><i class="fas fa-home mr-1"></i>Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('menu') }}">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reservation.public') }}">Reservation</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('my.orders') }}">My Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('customer.profile') }}">
                            @if (auth()->user()->avatar && file_exists(public_path(auth()->user()->avatar)))
                                <img src="{{ asset(auth()->user()->avatar) }}" alt="avatar" class="rounded-circle mr-1" style="width:28px; height:28px; object-fit:cover;">
                            @else
                                <i class="fas fa-user-circle mr-1"></i>
                            @endif
                            Profile
                        </a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="cart-badge">{{ session('cart_count', 0) }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="customer-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-coffee"></i> Coffee Shop Cambodia</h5>
                    <p class="mt-3">The best coffee in Cambodia. Fresh beans, delicious drinks, and a cozy atmosphere.</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('menu') }}">Menu</a></li>
                        <li><a href="{{ route('reservation.public') }}">Book a Table</a></li>
                        @auth
                            <li><a href="{{ route('my.orders') }}">My Orders</a></li>
                            <li><a href="{{ route('customer.profile') }}">My Profile</a></li>
                        @endauth
                    </ul>
                </div>
<div class="col-lg-4 mb-4">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Komboul, Phnom Penh, Cambodia</li>
                        <li><i class="fas fa-phone mr-2"></i> +855 963072500</li>
                        <li><i class="fas fa-envelope mr-2"></i> bromenghor130318@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Coffee Shop Cambodia. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
