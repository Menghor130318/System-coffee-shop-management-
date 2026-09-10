<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        return $this->success(
            $this->authService->register(
                $request->validated()
            ),
            'Register successfully.',
            201
        );
    }

    public function login(LoginRequest $request)
    {
        return $this->success(
            $this->authService->login(
                $request->validated()
            ),
            'Login successfully.'
        );
    }

    public function logout()
    {
        return $this->success(
            $this->authService->logout(),
            'Logout successfully.'
        );
    }

    public function me()
    {
        return $this->success(
            auth()->user(),
            'User retrieved successfully.'
        );
    }
}
