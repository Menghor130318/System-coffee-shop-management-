@extends('layouts.customer')

@section('title', 'Coffee Shop Dashboard')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1>Welcome to Coffee Shop <br>Cambodia Dashboard</h1>
                    <p class="lead mt-3">Browse our full Cambodian menu — from hot coffee and fresh juices to noodle soup, grilled duck, and traditional Khmer dishes.</p>
                    <div class="mt-4">
                        <a href="#daytime" class="btn btn-hero btn-lg mr-2"><i class="fas fa-utensils mr-2"></i>Daytime Menu</a>
                        <a href="#additional" class="btn btn-outline-light btn-lg">Additional Menu</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-center">
                    <i class="fas fa-mug-hot" style="font-size: 180px; color: rgba(200,169,106,0.4);"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick category navigation -->
    <section class="py-4">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center">
                <a href="{{ route('menu') }}" class="btn btn-outline-dark mx-1 mb-2"><i class="fas fa-th mr-1"></i>All Menu</a>
                @foreach ($daytimeCategories as $cat)
                    <a href="{{ route('menu', ['category' => $cat->id]) }}" class="btn btn-outline-dark mx-1 mb-2"><i class="fas fa-{{ $cat->icon ?? 'circle' }} mr-1"></i>{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============ DAYTIME MENU ============ -->
    <section class="py-4" id="daytime">
        <div class="container">
            <h2 class="section-title"><i class="fas fa-sun mr-2"></i>Daytime Menu (ម្ហូបកម្ម៉ងអាហារពេលថ្ងៃ)</h2>

            @foreach ($daytimeCategories as $category)
                @if ($category->products->count())
                    <div class="d-flex align-items-center mt-4 mb-3">
                        <i class="fas fa-{{ $category->icon ?? 'circle' }} mr-2 text-category"></i>
                        <h4 class="mb-0 category-heading">{{ $category->name }}</h4>
                        <span class="badge badge-pill badge-cat ml-3">{{ $category->products->count() }} items</span>
                    </div>
                    <div class="row">
                        @foreach ($category->products as $product)
                            <div class="col-lg-4 col-md-6 col-12 mb-4">
                                <div class="product-card">
                                    <div class="product-img">
                                        @if ($product->image)
                                            <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <i class="fas fa-{{ $category->icon ?? 'coffee' }}" style="font-size: 60px; color: #C8A96A;"></i>
                                        @endif
                                        @if ($product->sale_price)
                                            <span class="badge badge-sale">SALE</span>
                                        @endif
                                    </div>
                                    <div class="product-body">
                                        <div class="product-category">{{ $category->name }}</div>
                                        <div class="product-name">{{ $product->name }}</div>
                                        <p class="product-desc">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <div>
                                                @if ($product->sale_price)
                                                    <span class="product-price text-danger">${{ number_format($product->sale_price, 2) }}</span>
                                                    <span class="price-old">${{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span class="product-price">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                                <div class="text-muted" style="font-size: 0.75rem;">{{ number_format($product->price, 0) }}៛</div>
                                            </div>
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-add btn-sm"><i class="fas fa-cart-plus mr-1"></i>Add</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    <!-- ============ ADDITIONAL MENU ============ -->
    <section class="py-4 bg-light" id="additional">
        <div class="container">
            <h2 class="section-title"><i class="fas fa-utensils mr-2"></i>Additional Menu (មុខម្ហូបបន្ថែម)</h2>

            @foreach ($additionalCategories as $category)
                @if ($category->products->count())
                    <div class="d-flex align-items-center mt-4 mb-3">
                        <i class="fas fa-{{ $category->icon ?? 'circle' }} mr-2 text-category"></i>
                        <h4 class="mb-0 category-heading">{{ $category->name }}</h4>
                        <span class="badge badge-pill badge-cat ml-3">{{ $category->products->count() }} items</span>
                    </div>
                    <div class="row">
                        @foreach ($category->products as $product)
                            <div class="col-lg-4 col-md-6 col-12 mb-4">
                                <div class="product-card">
                                    <div class="product-img">
                                        @if ($product->image)
                                            <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <i class="fas fa-{{ $category->icon ?? 'coffee' }}" style="font-size: 60px; color: #C8A96A;"></i>
                                        @endif
                                        @if ($product->sale_price)
                                            <span class="badge badge-sale">SALE</span>
                                        @endif
                                    </div>
                                    <div class="product-body">
                                        <div class="product-category">{{ $category->name }}</div>
                                        <div class="product-name">{{ $product->name }}</div>
                                        <p class="product-desc">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <div>
                                                @if ($product->sale_price)
                                                    <span class="product-price text-danger">${{ number_format($product->sale_price, 2) }}</span>
                                                    <span class="price-old">${{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span class="product-price">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                                <div class="text-muted" style="font-size: 0.75rem;">{{ number_format($product->price, 0) }}៛</div>
                                            </div>
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-add btn-sm"><i class="fas fa-cart-plus mr-1"></i>Add</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
