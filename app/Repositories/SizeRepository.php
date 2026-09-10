<?php

namespace App\Repositories;

use App\Interfaces\SizeRepositoryInterface;
use App\Models\Size;

class SizeRepository implements SizeRepositoryInterface
{
    protected Size $size;

    public function __construct(Size $size)
    {
        $this->size = $size;
    }

    public function index()
    {
        return $this->size
            ->where('status', true)
            ->orderBy('id')
            ->get();
    }
    public function all()
    {
        return $this->size
            ->orderBy('id')
            ->get();
    }
    public function create(array $data)
    {
        return $this->size->create($data);
    }

    public function update($id, array $data)
    {
        $size = $this->size->findOrFail($id);

        $size->update($data);

        return $size;
    }

    public function delete($id)
    {
        $size = $this->size->findOrFail($id);

        return $size->delete();
    }
}
