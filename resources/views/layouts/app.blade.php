<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
        name="viewport">
<title>@yield('title') &mdash; Coffee Shop in Cambodia</title>

    <!-- General CSS Files -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    @stack('style')

    <!-- Template CSS -->
    <link rel="stylesheet"
        href="{{ asset('css/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/components.css') }}">

    <!-- Start GA -->
    <script async
        src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- END GA -->
</head>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Header -->
            @include('components.header')

            <!-- Sidebar -->
            @include('components.sidebar')

            <!-- Content -->
            @yield('main')

            <!-- Footer -->
            @include('components.footer')
        </div>
    </div>
    <!-- Coffee Shop Theme Override -->
<style>
    /* 1. Body & Page Background */
    body, .main-content, .main-wrapper {
        background-color: #f7f3ee !important;
        font-family: 'Nunito', 'Segoe UI', sans-serif;
    }

    /* 2. Top Navbar (កែពីពណ៌ស្វាយ មកជាពណ៌ Cream) */
    .navbar-bg {
        background-color: transparent !important;
        height: 70px;
    }
    .main-navbar {
        background-color: #f7f3ee !important;
        box-shadow: none !important;
    }
    .main-navbar .nav-link, 
    .main-navbar .nav-link i,
    .main-navbar .dropdown-toggle,
    .main-navbar .nav-link-user {
        color: #2b1e17 !important;
    }

    /* 3. Sidebar Styling (កែជាពណ៌ត្នោតចាស់ Espresso) */
    .main-sidebar {
        background-color: #231610 !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    }
    .main-sidebar .sidebar-brand a, 
    .main-sidebar .sidebar-brand-sm a {
        color: #ffffff !important;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .main-sidebar .sidebar-menu li.menu-header {
        color: #8c7a6b !important;
    }
    .main-sidebar .sidebar-menu li a {
        color: #c7b8aa !important;
        border-radius: 8px;
        margin: 2px 10px;
    }
    .main-sidebar .sidebar-menu li a:hover {
        background-color: #38271e !important;
        color: #ffffff !important;
    }
    .main-sidebar .sidebar-menu li.active > a,
    .main-sidebar .sidebar-menu li.active a i {
        background-color: #4a3328 !important;
        color: #ffffff !important;
        font-weight: 600;
    }
    .main-sidebar .sidebar-menu li a i {
        color: #c7b8aa !important;
    }

    /* Sub-menu (Dropdown Sidebar) */
    .main-sidebar .sidebar-menu li.active ul.dropdown-menu li a {
        color: #c7b8aa !important;
        background-color: transparent !important;
    }
    .main-sidebar .sidebar-menu li.active ul.dropdown-menu li.active a {
        color: #ffffff !important;
        font-weight: bold;
    }

    /* 4. Section Header & Breadcrumb */
    .section-header {
        background-color: #ffffff !important;
        border-radius: 12px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02) !important;
        border: 1px solid #ebe3d9;
    }
    .section-header h1 {
        color: #2b1e17 !important;
    }
    .breadcrumb-item a {
        color: #8c7a6b !important;
    }

    /* 5. Cards & Tables Setup */
    .card {
        border-radius: 12px !important;
        border: 1px solid #ebe3d9 !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02) !important;
        background-color: #ffffff !important;
    }
    .card .card-header h4 {
        color: #2b1e17 !important;
    }

    /* 6. Primary Buttons (កែពីពណ៌ស្វាយ មកជាពណ៌ Coffee Brown) */
    .btn-primary, 
    .btn-primary:disabled {
        background-color: #4a3328 !important;
        border-color: #4a3328 !important;
        box-shadow: 0 2px 6px rgba(74, 51, 40, 0.2) !important;
    }
    .btn-primary:hover, 
    .btn-primary:focus, 
    .btn-primary:active {
        background-color: #2b1e17 !important;
        border-color: #2b1e17 !important;
    }
        /* Dashboard Footer Styling */
    footer.main-footer {
        background-color: transparent !important;
        border-top: 1px solid #ebe3d9;
        color: #8c7a6b !important;
        padding: 20px 30px;
    }
    footer.main-footer a {
        color: #4a3328 !important;
        font-weight: 600;
    }
    /* 7. Footer */
    footer.main-footer {
        background-color: #f7f3ee !important;
        border-top: 1px solid #ebe3d9;
        color: #8c7a6b;
    }
            /* Center Footer Content Across All Pages */
        footer.main-footer {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 10px !important;
            text-align: center !important;
            padding-left: 0 !important;
        }

        footer.main-footer .footer-left,
        footer.main-footer .footer-right {
            float: none !important;
            margin: 0 !important;
        }
        .hero-section {
    /* ប្រើ Dark Overlay លើរូបភាព Background ដើម្បីឱ្យអក្សរព័ណ៌សលេចច្បាស់ */
    background: linear-gradient(rgba(35, 22, 16, 0.75), rgba(35, 22, 16, 0.75)), 
                url('{{ asset("images/hero-bg.jpg") }}') no-repeat center center;
    background-size: cover;
    padding: 100px 0;
    color: #ffffff;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.2;
    }

    .hero-subtitle {
        color: #e6ded8;
        font-size: 1.1rem;
        max-width: 500px;
    }

    .btn-coffee {
        background-color: #d4a373;
        color: #2b1e17;
        font-weight: 700;
        border: none;
        padding: 12px 28px;
        border-radius: 8px;
    }

    .btn-coffee:hover {
        background-color: #bc8a5f;
        color: #ffffff;
    }
        
</style>



    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    @stack('scripts')

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
