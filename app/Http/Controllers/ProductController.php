<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')->orderBy('id', 'asc')->paginate(10);
        return view('pages.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'name_en'     => 'nullable|string|max:255',
            'price'       => 'required|numeric',
            'category_id' => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            // រក្សាទុកផ្ទាល់ក្នុង folder public/products
            $request->image->move(public_path('products'), $filename);
        }

        $product = new Product();
        $product->category_id     = $request->category_id;
        $product->product_name_kh = $request->name;
        $product->product_name_en = $request->name_en;
        $product->price_min       = (float) $request->price;
        $product->price_max       = (float) $request->price;
        $product->image           = $filename;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit(string $id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.product.edit', compact('categories', 'product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'name_en'     => 'nullable|string|max:255',
            'price'       => 'required|numeric',
            'category_id' => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            // រក្សាទុកផ្ទាល់ក្នុង folder public/products
            $request->image->move(public_path('products'), $filename);

            // លុបរូបភាពចាស់ចេញពី public/products បើមាន
            if ($product->image && File::exists(public_path('products/' . $product->image))) {
                File::delete(public_path('products/' . $product->image));
            }
            $product->image = $filename;
        }

        $product->category_id     = $request->category_id;
        $product->product_name_kh = $request->name;
        $product->product_name_en = $request->name_en;
        $product->price_min       = (float) $request->price;
        $product->price_max       = (float) $request->price;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && File::exists(public_path('products/' . $product->image))) {
            File::delete(public_path('products/' . $product->image));
        }

        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}