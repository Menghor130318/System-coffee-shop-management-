<?php

namespace App\Services;

use App\Interfaces\AuthRepositoryInterface;

class AuthService
{
    protected AuthRepositoryInterface $repository;
    public function __construct(
        AuthRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function register(array $data)
    {
        return $this->repository->register($data);
    }

    public function login(array $data)
    {
        return $this->repository->login($data);
    }

    public function logout()
    {
        return $this->repository->logout();
    }
}
