<?php

namespace App\Services;

use App\Interfaces\DashboardRepositoryInterface;


class DashboardService
{

    protected DashboardRepositoryInterface $dashboardRepository;

    public function __construct(
        DashboardRepositoryInterface $dashboardRepository
    ) {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function overview()
    {
        return $this->dashboardRepository->overview();
    }

}
