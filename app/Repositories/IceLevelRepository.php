<?php

namespace App\Repositories;

use App\Interfaces\IceLevelRepositoryInterface;
use App\Models\IceLevel;

class IceLevelRepository implements IceLevelRepositoryInterface
{
    protected IceLevel $iceLevel;

    public function __construct(IceLevel $iceLevel)
    {
        $this->iceLevel = $iceLevel;
    }

    public function index()
    {
        return $this->iceLevel
            ->where('status', true)
            ->orderBy('id')
            ->get();
    }
    public function all()
    {
        return $this->iceLevel
            ->orderBy('id')
            ->get();
    }

    public function show(int $id)
    {
        return $this->iceLevel->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->iceLevel->create($data);
    }

    public function update(int $id, array $data)
    {
        $item = $this->iceLevel->findOrFail($id);

        $item->update($data);

        return $item;
    }

    public function delete(int $id)
    {
         $item = $this->iceLevel->findOrFail($id);

        return $item->delete();
    }
}