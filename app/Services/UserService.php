<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;

class UserService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function getCustomers()
    {
        return $this->userRepository->getCustomers();
    }
    public function findCustomer(int $id)
    {
        return $this->userRepository->findCustomer($id);
    }
    public function orders($id)
    {
        return $this->userRepository->orders($id);
    }
}
