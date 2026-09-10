<?php

namespace App\Services;

use App\Interfaces\ToppingRepositoryInterface;

class ToppingService
{
    protected ToppingRepositoryInterface $repository;

    public function __construct(
        ToppingRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->index();
    }
    public function all()
    {
        return $this->repository->all();
    }
    public function show(int $id)
    {
        return $this->repository->show($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
