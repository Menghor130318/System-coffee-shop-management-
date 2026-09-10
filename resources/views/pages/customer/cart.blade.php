@extends('layouts.customer')

@section('title', 'Shopping Cart')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="section-title mb-4">Shopping Cart</h2>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            @if (empty($cart))
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart" style="font-size: 80px; color: #C8A96A;"></i>
                    <h4 class="mt-3 text-muted">Your cart is empty</h4>
                    <a href="{{ route('menu') }}" class="btn btn-hero mt-3">Browse Menu</a>
                </div>
            @else
                <div class="row">
                    <!-- Cart Items List -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                @foreach ($cart as $id => $item)
                                    @php
                                        $itemPrice = $item['price'] ?? $item['price_min'] ?? 0;
                                        $itemTotal = $itemPrice * $item['quantity'];
                                        $img = $item['image'] ?? null;
                                    @endphp
                                    <div class="d-flex align-items-center border-bottom py-3">
                                        <!-- Item Image (កែសម្រួល Path ត្រង់នេះ) -->
                                        <div class="mr-3">
                                            @if ($img && file_exists(public_path('products/' . $img)))
                                                <img src="{{ asset('products/' . $img) }}" alt="{{ $item['name'] }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                                            @elseif ($img && file_exists(public_path('storage/products/' . $img)))
                                                <img src="{{ asset('storage/products/' . $img) }}" alt="{{ $item['name'] }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center bg-light border rounded" style="width: 70px; height: 70px;">
                                                    <i class="fas fa-coffee" style="font-size: 32px; color: #C8A96A;"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Item Info -->
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 fw-bold">{{ $item['product_name_kh'] ?? $item['name'] }}</h6>
                                            <span class="text-muted">${{ number_format($itemPrice, 2) }}</span>
                                        </div>

                                        <!-- Quantity Form -->
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center mr-3">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm text-center" style="width: 70px;" onchange="this.form.submit()">
                                        </form>

                                        <!-- Item Total -->
                                        <div class="font-weight-bold text-primary mr-3">${{ number_format($itemTotal, 2) }}</div>

                                        <!-- Delete Button -->
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="font-weight-bold">Order Summary</h5>
                                <hr>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span class="font-weight-bold">${{ number_format($total, 2) }} <small class="text-muted">(≈ {{ number_format($total * 4100) }}៛)</small></span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping</span>
                                    <span>$0.00</span>
                                </div>
                                
                                <hr>
                                
                                <div class="d-flex justify-content-between font-weight-bold mb-3 fs-5">
                                    <span>Total</span>
                                    <span class="text-primary">${{ number_format($total, 2) }} <small class="text-muted font-weight-normal">(≈ {{ number_format($total * 4100) }}៛)</small></span>
                                </div>

                                <a href="{{ route('checkout') }}" class="btn btn-hero btn-block fw-bold py-2">Proceed to Checkout</a>
                                <a href="{{ route('menu') }}" class="btn btn-outline-dark btn-block mt-2 py-2">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection