<?php

namespace App\Repositories;

use App\Interfaces\SweetnessLevelRepositoryInterface;
use App\Models\SweetnessLevel;

class SweetnessLevelRepository implements SweetnessLevelRepositoryInterface
{
    protected SweetnessLevel $sweetnessLevel;

    public function __construct(SweetnessLevel $sweetnessLevel)
    {
        $this->sweetnessLevel = $sweetnessLevel;
    }

    public function index()
    {
        return $this->sweetnessLevel
            ->where('status', true)
            ->orderBy('id')
            ->get();
    }

    public function all()
    {
        return $this->sweetnessLevel
            ->orderBy('id')
            ->get();
    }

    public function create(array $data)
    {
        return $this->sweetnessLevel->create($data);
    }

    public function update($id, array $data)
    {
        $item = $this->sweetnessLevel->findOrFail($id);

        $item->update($data);

        return $item;
    }

    public function delete($id)
    {
        $item = $this->sweetnessLevel->findOrFail($id);

        return $item->delete();
    }
}
