<?php

namespace App\Repositories;

use App\Interfaces\ToppingRepositoryInterface;
use App\Models\Topping;

class ToppingRepository implements ToppingRepositoryInterface
{
    protected Topping $topping;

    public function __construct(Topping $topping)
    {
        $this->topping = $topping;
    }

    public function index()
    {
        return $this->topping
            ->where('status', true)
            ->orderBy('id')
            ->get();
    }
    public function all()
    {
        return $this->topping
            ->orderBy('id')
            ->get();
    }
    public function show(int $id)
    {
        return $this->topping->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->topping->create($data);
    }

    public function update(int $id, array $data)
    {
        $topping = $this->topping->findOrFail($id);

        $topping->update($data);

        return $topping;
    }

    public function delete(int $id)
    {
        $topping = $this->topping->findOrFail($id);

        return $topping->delete();
    }
}
