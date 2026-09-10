<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->success(
            $this->userService->getCustomers()
        );
    }
    public function show($id)
    {
        return $this->success(
            $this->userService->findCustomer($id)
        );
    }
    public function orders($id)
    {
        return $this->success(
            $this->userService->orders($id)
        );
    }
}
