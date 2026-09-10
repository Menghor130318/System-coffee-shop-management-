<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Services\CartService;
use App\Http\Requests\CalculatePriceRequest;
use App\Http\Requests\UpdateCartItemRequest;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(AddToCartRequest $request)
    {
        return response()->json(
            $this->cartService->add(
                $request->validated()
            )
        );
    }

    public function show($id)
    {
        return response()->json(
            $this->cartService->items($id)
        );
    }

    public function destroy($itemId)
    {
        return response()->json(
            $this->cartService->remove($itemId)
        );
    }
    public function index()
    {
        return response()->json(
            $this->cartService->list()
        );
    }
    public function update(
        UpdateCartItemRequest $request,
        $itemId
    ) {
        return response()->json(
            $this->cartService->update(
                $itemId,
                $request->validated()
            )
        );
    }
}
