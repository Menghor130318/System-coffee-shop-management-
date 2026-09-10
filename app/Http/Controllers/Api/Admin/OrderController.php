<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Services\OrderService;
use App\Services\UserService;
use App\Http\Requests\UpdateOrderStatusRequest;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(
        OrderService $service,
    ) {
        $this->orderService = $service;
    }

    public function index()
    {
        return response()->json(
            $this->orderService->adminList()
        );
    }
    public function updateStatus(
        UpdateOrderStatusRequest $request,
        $id
    ) {
        return response()->json(
            $this->orderService->updateStatus(
                $id,
                $request->validated()
            )
        );
    }
    public function show($id)
    {
        return response()->json(
            $this->orderService->show($id)
        );
    }
}
