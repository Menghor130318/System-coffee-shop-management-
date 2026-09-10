<?php

namespace App\Interfaces;

interface ToppingRepositoryInterface
{
    public function index();
    public function all();

    public function show(int $id);

    public function create(array $data);

    public function update(int $id,array $data);

    public function delete(int $id);
}