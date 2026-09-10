@extends('layouts.customer')

@section('title', 'Coffee Menu')

@section('content')
<style>
    /* Google Font & Root Variables */
    :root {
        --coffee-dark: #2b1810;
        --coffee-primary: #8b5e34;
        --coffee-accent: #c89666;
        --coffee-light: #fbf7f4;
        --coffee-card-bg: #ffffff;
        --border-color: #ede3da;
    }

    /* Hero Section */
    .menu-hero {
        background: linear-gradient(135deg, rgba(43, 24, 16, 0.95), rgba(70, 42, 28, 0.88)), 
                    url('https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
        padding: 70px 0 60px;
        color: #ffffff;
        border-bottom-left-radius: 28px;
        border-bottom-right-radius: 28px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }
    .menu-hero h1 {
        font-weight: 800;
        font-size: 2.5rem;
        line-height: 1.25;
        letter-spacing: -0.5px;
    }
    .btn-hero-primary {
        background-color: var(--coffee-accent);
        color: #fff;
        border-radius: 50px;
        padding: 10px 24px;
        font-weight: 600;
        border: none;
        transition: 0.3s;
    }
    .btn-hero-primary:hover {
        background-color: #b37e4e;
        color: #fff;
        transform: translateY(-2px);
    }

    /* Category Filter Tabs (Pills) */
    .category-scroll-wrapper {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 6px 2px 16px;
        scrollbar-width: none; /* Hide scrollbar Firefox */
    }
    .category-scroll-wrapper::-webkit-scrollbar {
        display: none; /* Hide scrollbar Chrome */
    }
    .cat-pill {
        white-space: nowrap;
        padding: 9px 20px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.92rem;
        color: #634832;
        background: #ffffff;
        border: 1px solid var(--border-color);
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    }
    .cat-pill:hover, .cat-pill.active {
        background: var(--coffee-dark);
        color: #ffffff !important;
        border-color: var(--coffee-dark);
        box-shadow: 0 4px 12px rgba(43, 24, 16, 0.25);
    }

    /* Search Bar */
    .search-input-group {
        border-radius: 50px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        background: #ffffff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.04);
    }
    .search-input-group input {
        border: none;
        padding-left: 20px;
        box-shadow: none !important;
    }
    .search-input-group button {
        background-color: var(--coffee-dark);
        color: white;
        border: none;
        padding: 0 22px;
        transition: 0.3s;
    }
    .search-input-group button:hover {
        background-color: var(--coffee-primary);
    }

    /* Product Card */
    .coffee-card {
        background: var(--coffee-card-bg);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .coffee-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(67, 40, 24, 0.12);
        border-color: var(--coffee-accent);
    }
    .card-img-wrap {
        position: relative;
        width: 100%;
        height: 210px;
        background-color: #f7f3ed;
        overflow: hidden;
    }
    .card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.45s ease;
    }
    .coffee-card:hover .card-img-wrap img {
        transform: scale(1.08);
    }
    .card-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d6c2af;
    }
    .cat-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(4px);
        color: var(--coffee-dark);
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 30px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    /* Card Content */
    .card-content {
        padding: 16px 18px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .product-title-kh {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--coffee-dark);
        margin-bottom: 2px;
        line-height: 1.4;
    }
    .product-title-en {
        font-size: 0.85rem;
        color: #8c786a;
        margin-bottom: 12px;
    }
    .price-tag {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--coffee-primary);
    }
    .btn-add-cart {
        background-color: var(--coffee-dark);
        color: #ffffff;
        border-radius: 50px;
        padding: 7px 16px;
        font-size: 0.88rem;
        font-weight: 600;
        border: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-add-cart:hover {
        background-color: var(--coffee-accent);
        color: #ffffff;
        transform: scale(1.04);
    }
</style>

<!-- Hero Section -->
<div class="menu-hero mb-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge px-3 py-2 mb-3" style="background: rgba(200, 150, 102, 0.25); color: #deb887; border-radius: 30px;">
                    <i class="fas fa-coffee mr-1"></i> Freshly Brewed Everyday
                </span>
                <h1>Fresh Coffee,<br>Made with Love</h1>
                <p class="mt-2 text-light opacity-80" style="max-width: 500px;">
                    Discover authentic taste and artisanal blends. Handcrafted espresso and soothing teas tailored for your perfect moment.
                </p>
                <div class="mt-3">
                    <a href="#menu-catalog" class="btn btn-hero-primary mr-2">
                        <i class="fas fa-utensils mr-1"></i> Order Now
                    </a>
                    <a href="{{ route('reservation.public') }}" class="btn btn-outline-light" style="border-radius: 50px; padding: 10px 22px;">
                        Book a Table
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <i class="fas fa-mug-hot" style="font-size: 140px; color: rgba(200, 150, 102, 0.25);"></i>
            </div>
        </div>
    </div>
</div>

<div class="container py-3" id="menu-catalog">
    <!-- Notifications -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-pill px-4" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- Category Pills & Search -->
    <div class="row align-items-center mb-4">
        <!-- Search Bar -->
        <div class="col-lg-4 col-md-5 mb-3 mb-md-0">
            <form method="GET" action="{{ route('menu') }}">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="input-group search-input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search coffee, drinks..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Horizontal Scroll Category Pills -->
        <div class="col-lg-8 col-md-7">
            <div class="category-scroll-wrapper">
                <a href="{{ route('menu', array_merge(request()->except('category', 'page'))) }}" 
                   class="cat-pill {{ !request('category') ? 'active' : '' }}">
                    All Items
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('menu', array_merge(request()->except('page'), ['category' => $cat->id])) }}" 
                       class="cat-pill {{ request('category') == $cat->id ? 'active' : '' }}">
                        {{ $cat->category_name_kh ?? $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="row">
        @forelse ($products as $product)
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-4">
                <div class="coffee-card">
                    <div class="card-img-wrap">
                        @if ($product->image && file_exists(public_path('products/' . $product->image)))
                            <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->product_name_kh }}">
                        @elseif ($product->image && file_exists(public_path('storage/products/' . $product->image)))
                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->product_name_kh }}">
                        @else
                            <div class="card-img-placeholder">
                                <i class="fas fa-coffee fa-3x"></i>
                            </div>
                        @endif

                        <span class="cat-badge">
                            {{ $product->category->category_name_kh ?? ($product->category->name ?? 'Coffee') }}
                        </span>
                    </div>

                    <div class="card-content">
                        <div class="product-title-kh">
                            {{ $product->product_name_kh ?? $product->name }}
                        </div>
                        <div class="product-title-en">
                            {{ $product->product_name_en ?? ($product->name_en ?? '') }}
                        </div>

                        <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="price-tag">
                                ${{ number_format($product->price_min ?? $product->price, 2) }}
                            </span>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-add-cart">
                                    <i class="fas fa-plus"></i>
                                    <span>Add</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-mug-hot fa-4x text-muted mb-3" style="opacity: 0.4;"></i>
                <h5 class="text-muted">No coffee or drinks found matching your search.</h5>
                <a href="{{ route('menu') }}" class="btn btn-sm btn-outline-dark mt-2" style="border-radius: 20px;">View Full Menu</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection