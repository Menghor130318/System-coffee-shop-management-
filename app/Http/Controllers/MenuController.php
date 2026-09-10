<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // 1. ទាញយក Product ទាំងអស់ ដោយភ្ជាប់ជាមួយ Category
        $query = Product::with('category');

        // 2. Filter តាម Category (ប្រសិនបើ Customer ជ្រើសរើស Category)
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 3. Search តាមឈ្មោះ Product (Khmer, English, ស្វែងរកបានទាំងអស់)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('name_en', 'like', '%' . $search . '%')
                  ->orWhere('name_zh', 'like', '%' . $search . '%');
            });
        }

        // 4. ទាញយកទិន្នន័យ (បង្ហាញ ៩ Product ក្នុងមួយទំព័រ)
        $products = $query->paginate(9);
        $categories = Category::all();

        return view('pages.customer.menu', compact('products', 'categories'));
    }
}