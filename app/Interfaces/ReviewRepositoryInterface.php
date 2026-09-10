<?php

namespace App\Interfaces;

interface ReviewRepositoryInterface
{
    public function store(array $data);

    public function list($productId);
}
