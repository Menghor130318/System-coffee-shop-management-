<?php

namespace App\Services;

use App\Interfaces\ReviewRepositoryInterface;

class ReviewService
{
    protected ReviewRepositoryInterface $repository;

    public function __construct(
        ReviewRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function store(array $data)
    {
        return $this->repository->store($data);
    }

    public function list($productId)
    {
        return $this->repository->list($productId);
    }
}
