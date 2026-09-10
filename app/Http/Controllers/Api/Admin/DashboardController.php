<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Services\OrderService;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;
    protected OrderService $orderService;

    public function __construct(
        DashboardService $dashboardService,
        OrderService $orderService
    ) {
        $this->dashboardService = $dashboardService;
        $this->orderService = $orderService;
    }

    public function overview()
    {
        return $this->success(

            $this->dashboardService->overview()

        );
    }
    public function pendingOrders()
    {
        return $this->success(
            $this->orderService->pendingConfirmationOrders()
        );
    }
}
