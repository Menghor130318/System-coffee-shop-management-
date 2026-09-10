<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Services\OrderService;
use App\Http\Requests\UpdateOrderStatusRequest;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(
        OrderService $service
    ) {
        $this->orderService = $service;
    }

    public function checkout(
        CheckoutRequest $request
    ) {
        return response()->json(

            $this->orderService
                ->checkout(
                    $request->validated()
                )

        );
    }

    public function history()
    {
        return response()->json(
            $this->orderService->history()
        );
    }

    public function detail($id)
    {
        return response()->json(
            $this->orderService->detail($id)
        );
    }
    public function cancel($id)
    {
        return response()->json(
            $this->orderService->cancel($id)
        );
    }
    public function received($id)
    {
        return response()->json(
            $this->orderService->received($id)
        );
    }
    public function checkoutVnpay(CheckoutRequest $request)
    {
        return response()->json(
            $this->orderService->checkoutVnpay(
                $request->validated()
            )
        );
    }
}
