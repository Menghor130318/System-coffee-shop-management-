<?php

namespace App\Services;

use App\Interfaces\SweetnessLevelRepositoryInterface;
use Illuminate\Support\Str;

class SweetnessLevelService
{
    protected SweetnessLevelRepositoryInterface $repository;

    public function __construct(
        SweetnessLevelRepositoryInterface $repository
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

    public function create(array $data)
    {
        $percent = (int) preg_replace('/\D/', '', $data['name']);
        $data['percent'] = $percent;
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        $percent = (int) preg_replace('/\D/', '', $data['name']);
        $data['percent'] = $percent;
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
