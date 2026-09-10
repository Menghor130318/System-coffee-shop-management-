@extends('layouts.app')

@section('title', 'Products')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Products</h1>
                <div class="section-header-button">
                    <a href="{{ route('product.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Products</a></div>
                    <div class="breadcrumb-item">All Products</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Products</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('product.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name" value="{{ request('name') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name (KH / EN)</th>
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($products as $product)
                                                <tr>
                                                    <!-- បង្ហាញរូបភាព (ឆែកគ្រប់ទីតាំង Folder) -->
                                                    <td>
                                                        @if ($product->image && file_exists(public_path('products/' . $product->image)))
                                                            <img src="{{ asset('products/' . $product->image) }}" 
                                                                 alt="{{ $product->product_name_kh }}" 
                                                                 width="50" height="50" 
                                                                 class="rounded" style="object-fit: cover;">
                                                        @elseif ($product->image && file_exists(public_path('storage/products/' . $product->image)))
                                                            <img src="{{ asset('storage/products/' . $product->image) }}" 
                                                                 alt="{{ $product->product_name_kh }}" 
                                                                 width="50" height="50" 
                                                                 class="rounded" style="object-fit: cover;">
                                                        @elseif ($product->image && file_exists(public_path('storage/' . $product->image)))
                                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                                 alt="{{ $product->product_name_kh }}" 
                                                                 width="50" height="50" 
                                                                 class="rounded" style="object-fit: cover;">
                                                        @else
                                                            <span class="badge badge-danger">No Image</span>
                                                        @endif
                                                    </td>

                                                    <!-- បង្ហាញឈ្មោះខ្មែរ និងអង់គ្លេស -->
                                                    <td>
                                                        <strong>{{ $product->product_name_kh }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $product->product_name_en }}</small>
                                                    </td>

                                                    <!-- បង្ហាញឈ្មោះ Category -->
                                                    <td>{{ $product->category->category_name_kh ?? ($product->category->name ?? 'N/A') }}</td>

                                                    <td>{{ $product->description ?? '-' }}</td>

                                                    <!-- តម្លៃទំនិញ -->
                                                    <td>${{ number_format($product->price_min, 2) }}</td>

                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-info btn-icon mr-2">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>

                                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger btn-icon confirm-delete" onclick="return confirm('Are you sure you want to delete this product?')">
                                                                    <i class="fas fa-times"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No products found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right mt-3">
                                    {{ $products->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush