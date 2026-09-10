<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    protected CategoryService  $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
{
    return CategoryResource::collection(
        $this->categoryService->getAll()
    );
}

    public function show($id)
{
    $category = $this->categoryService->findById($id);

    return new CategoryResource($category);
}

    public function store(StoreCategoryRequest $request)
{
    $category = $this->categoryService->create(
        $request->validated()
    );

   return (new CategoryResource($category))
    ->response()
    ->setStatusCode(201);
}

   public function update(UpdateCategoryRequest $request, $id)
{
    $category = $this->categoryService->update(
        $id,
        $request->validated()
    );

    return new CategoryResource($category);
}

    public function destroy($id)
    {
        $this->categoryService->delete($id);

        return response()->json([
            'message'=>'Deleted successfully'
        ]);
    }
}