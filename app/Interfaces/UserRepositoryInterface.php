<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getCustomers();
    public function findCustomer(int $id);
    public function orders($id);
}