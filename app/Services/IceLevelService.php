<?php

namespace App\Services;

use App\Interfaces\IceLevelRepositoryInterface;
use Illuminate\Support\Str;

class IceLevelService
{
    protected IceLevelRepositoryInterface $repository;

    public function __construct(
        IceLevelRepositoryInterface $repository
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
        $percent = (int) preg_replace('/\D/', '', $data['name']);
        $data['percent'] = $percent;
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        $percent = (int) preg_replace('/\D/', '', $data['name']);
        $data['percent'] = $percent;
        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
