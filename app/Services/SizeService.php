<?php

namespace App\Services;

use App\Interfaces\SizeRepositoryInterface;
use Illuminate\Support\Str;

class SizeService
{
    protected SizeRepositoryInterface $sizeRepository;

    public function __construct(SizeRepositoryInterface $sizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
    }

    public function index()
    {
        return $this->sizeRepository->index();
    }

    public function all()
    {
        return $this->sizeRepository->all();
    }
    public function create(array $data)
    {
        $data['code'] = Str::slug($data['name']);

        return $this->sizeRepository->create($data);
    }

    public function update($id, array $data)
    {
        $data['code'] = Str::slug($data['name']);

        return $this->sizeRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->sizeRepository->delete($id);
    }
}
