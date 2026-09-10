<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function checkout(array $data);

    public function history();

    public function detail($id);

    public function cancel($id);

    public function adminList();

    public function updateStatus($id, array $data);

    public function received($id);
}
