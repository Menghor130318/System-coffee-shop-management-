<?php

namespace App\Interfaces;

interface OrderServiceInterface
{
    public function adminList();

    public function updateStatus($id, array $data);

}
