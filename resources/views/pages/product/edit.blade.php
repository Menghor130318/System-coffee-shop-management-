@extends('layouts.app')

@section('title', 'Edit Product')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        .img-holder img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            border: 1px solid #ebe3d9;
            object-fit: cover;
        }
    </style>
@endpush
    @if ($product->image && file_exists(public_path('products/' . $product->image)))
        <img src="{{ asset('products/' . $product->image) }}" width="50" height="50" class="rounded" style="object-fit: cover;" alt="{{ $product->product_name_kh }}">
    @else
        <span class="badge badge-danger">No Image</span>
    @endif
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Product</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></div>
                    <div class="breadcrumb-item">Edit Product</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Edit Product #{{ $product->id }}</h2>
                <p class="section-lead">Update product details, multi-language names, pricing, and category.</p>

                <div class="card shadow-sm border-0">
                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Product Information</h4>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-auto-translate">
                                <i class="fas fa-magic mr-1"></i> Auto Fill / Translate
                            </button>
                        </div>

                        <div class="card-body">
                            <!-- Name English (Primary for Auto) -->
                            <div class="form-group">
                                <label>Name (English) <small class="text-muted">(វាយឈ្មោះ English វានឹង Auto បំពេញ Khmer & Chinese)</small></label>
                                <input type="text" 
                                    class="form-control @error('name_en') is-invalid @enderror" 
                                    id="name_en"
                                    name="name_en" 
                                    placeholder="e.g. Hot Cappuccino, Iced Latte..."
                                    value="{{ old('name_en', $product->name_en ?? $product->product_name_en ?? '') }}">
                                @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Khmer & Chinese -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Name (Khmer) <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name_kh"
                                        name="name" 
                                        placeholder="ឈ្មោះជាភាសាខ្មែរ"
                                        value="{{ old('name', $product->name ?? $product->name_kh ?? $product->product_name ?? '') }}" 
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Name (Chinese)</label>
                                    <input type="text" 
                                        class="form-control @error('name_zh') is-invalid @enderror" 
                                        id="name_zh"
                                        name="name_zh" 
                                        placeholder="中文名称"
                                        value="{{ old('name_zh', $product->name_zh ?? $product->product_name_zh ?? '') }}">
                                    @error('name_zh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                    name="description" 
                                    rows="3">{{ old('description', $product->description ?? $product->desc ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price & Category -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Price ($) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                        step="0.01" 
                                        class="form-control @error('price') is-invalid @enderror" 
                                        name="price" 
                                        value="{{ old('price', $product->price_min ?? $product->price) }}" 
                                        required>
                                        @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" 
                                        class="form-control selectric @error('category_id') is-invalid @enderror" 
                                        required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name ?? $category->category_name_kh ?? $category->category_name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Photo Product -->
                            <div class="form-group">
                                <label>Photo Product</label>
                                <input type="file" 
                                    class="form-control @error('image') is-invalid @enderror" 
                                    name="image" 
                                    accept="image/*" 
                                    onchange="previewImageUpdate(event)">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="d-block">Current / New Image Preview</label>
                                <div class="img-holder">
                                    <img src="{{ $product->image ? asset('storage/products/' . $product->image) : asset('assets/img/news/img01.jpg') }}" 
                                         alt="Product Image" 
                                         id="preview_image_up">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right bg-whitesmoke">
                            <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script>
       
        const coffeeMenu = {
            'cappuccino': { kh: 'កាហ្វេកាពូឈីណូ', zh: '卡布奇诺' },
            'hot cappuccino': { kh: 'កាហ្វេកាពូឈីណូក្ដៅ', zh: '热卡布奇诺' },
            'iced cappuccino': { kh: 'កាហ្វេកាពូឈីណូទឹកកក', zh: '冰卡布奇诺' },
            'latte': { kh: 'កាហ្វេឡាតេ', zh: '拿铁' },
            'hot latte': { kh: 'កាហ្វេឡាតេក្ដៅ', zh: '热拿铁' },
            'iced latte': { kh: 'កាហ្វេឡាតេទឹកកក', zh: '冰拿铁' },
            'espresso': { kh: 'កាហ្វេអេសប្រេសូ', zh: '意式浓缩' },
            'hot espresso': { kh: 'កាហ្វេអេសប្រេសូក្ដៅ', zh: '热浓缩咖啡' },
            'americano': { kh: 'កាហ្វេអាមេរិកាណូ', zh: '美式咖啡' },
            'hot americano': { kh: 'កាហ្វេអាមេរិកាណូក្ដៅ', zh: '热美式咖啡' },
            'iced americano': { kh: 'កាហ្វេអាមេរិកាណូទឹកកក', zh: '冰美式咖啡' },
            'mocha': { kh: 'កាហ្វេម៉ូកា', zh: '摩卡' },
            'hot mocha': { kh: 'កាហ្វេម៉ូកាក្ដៅ', zh: '热摩卡' },
            'iced mocha': { kh: 'កាហ្វេម៉ូកាទឹកកក', zh: '冰摩卡' },
            'black coffee': { kh: 'កាហ្វេខ្មៅ', zh: '黑咖啡' },
            'hot black coffee': { kh: 'កាហ្វេខ្មៅក្ដៅ', zh: '热黑咖啡' },
            'milk coffee': { kh: 'កាហ្វេទឹកដោះគោ', zh: '牛奶咖啡' },
            'hot milk coffee': { kh: 'កាហ្វេទឹកដោះគោក្ដៅ', zh: '热奶咖啡' },
            'iced milk coffee': { kh: 'កាហ្វេទឹកដោះគោទឹកកក', zh: '冰奶咖啡' },
            'green tea': { kh: 'តែបៃតង', zh: '绿茶' },
            'green tea latte': { kh: 'តែបៃតងឡាតេ', zh: '抹茶拿铁' },
            'lemon tea': { kh: 'តែក្រូចឆ្មា', zh: '柠檬茶' },
            'chocolate': { kh: 'សូកូឡា', zh: '巧克力' },
            'hot chocolate': { kh: 'សូកូឡាក្ដៅ', zh: '热巧克力' }
        };

        const nameEnInput = document.getElementById('name_en');
        const nameKhInput = document.getElementById('name_kh');
        const nameZhInput = document.getElementById('name_zh');
        const autoBtn = document.getElementById('btn-auto-translate');


        async function applyAutoFill() {
            const query = nameEnInput.value.trim().toLowerCase();
            if (!query) return;

            
            if (coffeeMenu[query]) {
                if (!nameKhInput.value) nameKhInput.value = coffeeMenu[query].kh;
                if (!nameZhInput.value) nameZhInput.value = coffeeMenu[query].zh;
                return;
            }

            
            try {
                if (!nameKhInput.value) {
                    const resKh = await fetch(`https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=km&dt=t&q=${encodeURIComponent(query)}`);
                    const dataKh = await resKh.json();
                    if (dataKh && dataKh[0] && dataKh[0][0]) {
                        nameKhInput.value = dataKh[0][0][0];
                    }
                }

                if (!nameZhInput.value) {
                    const resZh = await fetch(`https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=zh-CN&dt=t&q=${encodeURIComponent(query)}`);
                    const dataZh = await resZh.json();
                    if (dataZh && dataZh[0] && dataZh[0][0]) {
                        nameZhInput.value = dataZh[0][0][0];
                    }
                }
            } catch (err) {
                console.error("Auto translate error: ", err);
            }
        }

        
        autoBtn.addEventListener('click', applyAutoFill);

        
        function previewImageUpdate(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview_image_up').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush