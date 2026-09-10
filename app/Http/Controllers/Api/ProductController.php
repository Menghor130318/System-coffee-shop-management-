<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CalculatePriceRequest;
use App\Http\Resources\ProductCollection;
use App\Traits\ApiResponse;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    use ApiResponse;
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        return $this->success(
            new ProductCollection(
                $this->productService->index()
            ),
            'Products retrieved successfully.'
        );
    }
    public function show($id)
    {
        return $this->success(
            new ProductResource(
                $this->productService->show($id)
            ),
            'Product retrieved successfully.'
        );
    }
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create(
            $request->validated()
        );

        return response()->json($product, 201);
    }
    public function update(UpdateProductRequest $request, Product $product)
    {
        $updated = $this->productService->update(
            $product->id,
            $request->validated()
        );

        return response()->json($updated);
    }

    public function destroy($id)
    {
        $this->productService->delete($id);

        return $this->success(
            null,
            'Product deleted successfully.'
        );
    }
    public function options($id)
    {
        return response()->json(
            $this->productService->options($id)
        );
    }
    public function calculate(
        CalculatePriceRequest $request,
        $product
    ) {
        return response()->json(
            $this->productService->calculate(
                $product,
                $request->validated()
            )
        );
    }
    public function sizes($id)
    {
        return response()->json(
            $this->productService->sizes($id)
        );
    }
    public function updateSizes(Request $request, $id)
    {
        return response()->json(
            $this->productService->updateSizes(
                $id,
                $request->sizes
            )
        );
    }

    public function sweetnessLevels($id)
    {
        return response()->json(
            $this->productService->sweetnessLevels($id)
        );
    }

    public function updateSweetnessLevels(Request $request, $id)
    {
        return response()->json(
            $this->productService->updateSweetnessLevels(
                $id,
                $request->sweetness_levels
            )
        );
    }

    public function iceLevels($id)
    {
        return response()->json(
            $this->productService->iceLevels($id)
        );
    }

    public function updateIceLevels(Request $request, $id)
    {
        return response()->json(
            $this->productService->updateIceLevels(
                $id,
                $request->ice_levels
            )
        );
    }
    public function toppings($id)
    {
        return response()->json(
            $this->productService->toppings($id)
        );
    }

    public function updateToppings(Request $request, $id)
    {
        return response()->json(
            $this->productService->updateToppings(
                $id,
                $request->all()
            )
        );
    }
}
