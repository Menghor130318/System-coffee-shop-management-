<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function index();

    public function show($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function options($id);

    public function calculate(int $productId, array $data);

    public function sizes($id);

    public function updateSizes(int $id, array $sizes);
    public function sweetnessLevels($id);

    public function updateSweetnessLevels($id, array $sweetnessLevels);
    public function iceLevels($id);

    public function updateIceLevels($id, array $iceLevels);
    public function toppings($id);

    public function updateToppings(int $id, array $sizes);
}
