<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
   
    $categories = Category::query()
        ->when($request->input('name'), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })
        ->orderBy('id', 'asc') 
        ->paginate(10); 

    return view('pages.category.index', compact('categories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_zh' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = new Category;
        $category->name = $request->input('name');
        $category->name_en = $request->input('name_en');
        $category->name_zh = $request->input('name_zh');
        $category->slug = Str::slug($request->input('name_en') ?: $request->input('name')) . '-' . Str::random(5);
        $category->description = $request->input('description');
        $category->status = true;

        $category->save();

        return redirect()->route('category.index')->with('success', 'Category successfully created');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);

        return view('pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_zh' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::find($id);

        $category->update([
            'name' => $request->input('name'),
            'name_en' => $request->input('name_en'),
            'name_zh' => $request->input('name_zh'),
            'slug' => Str::slug($request->input('name_en') ?: $request->input('name')) . '-' . Str::random(5),
            'description' => $request->input('description'),

        ]);
        return redirect()->route('category.index')->with('success', 'Data Berhasil Di Ubah');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Category::find($id);

        if (!$data) {
            return redirect()->route('category.index')->with('error', 'Data Tidak Ditemukan');
        }

        $data->delete();
        return redirect()->route('category.index')->with('success', 'Data Berhasil Di Hapus');
    }

    public function migrateProducts(Request $request)
    {
        $options = [];

        if ($request->boolean('dry_run')) {
            $options['--dry-run'] = true;
        }

        $exitCode = Artisan::call('categories:migrate-products', $options);
        $message = trim(Artisan::output()) ?: 'Product category migration completed.';

        if ($exitCode !== 0) {
            return redirect()->back()->with('error', $message);
        }

        return redirect()->back()->with('success', $message);
    }
}
