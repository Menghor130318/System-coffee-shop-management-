<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Topping;

class ProductService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index()
    {
        return $this->productRepository->index();
    }
    public function show($id)
    {
        return $this->productRepository->show($id);
    }
    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['name']);

        if (isset($data['image'])) {

            $data['image'] = $data['image']->store(
                'products',
                'public'
            );
        }

        return $this->productRepository->create($data);
    }
    public function update($id, array $data)
    {
        $product = $this->productRepository->show($id);

        $data['slug'] = Str::slug($data['name']);

        if (isset($data['image'])) {

            if ($product->image) {

                Storage::disk('public')->delete(
                    $product->image
                );
            }

            $data['image'] = $data['image']->store(
                'products',
                'public'
            );
        }

        return $this->productRepository->update(
            $id,
            $data
        );
    }
    public function delete($id)
    {
        return $this->productRepository->delete($id);
    }
    public function options($id)
    {
        return $this->productRepository->options($id);
    }
    public function calculate($productId, array $data)
    {
        return $this->productRepository->calculate(
            $productId,
            $data
        );
    }
    public function sizes($id)
    {
        return $this->productRepository->sizes($id);
    }
    public function updateSizes($id, $sizes)
    {
        return $this->productRepository->updateSizes($id, $sizes);
    }
    public function sweetnessLevels($id)
    {
        return $this->productRepository->sweetnessLevels($id);
    }
    public function updateSweetnessLevels($id, $sweetnessLevels)
    {
        return $this->productRepository
            ->updateSweetnessLevels($id, $sweetnessLevels);
    }
    public function iceLevels($id)
    {
        return $this->productRepository->iceLevels($id);
    }
    public function updateIceLevels($id, $iceLevels)
    {
        return $this->productRepository
            ->updateIceLevels($id, $iceLevels);
    }
    public function toppings($id)
    {
        return $this->productRepository->toppings($id);
    }

    public function updateToppings($id, array $data)
    {
        $product = Product::findOrFail($id);

        // cập nhật trạng thái
        $product->update([
            'use_all_toppings' => $data['use_all_toppings']
        ]);

        if ($data['use_all_toppings']) {

            // lấy toàn bộ topping
            $sync = [];

            foreach (Topping::all() as $topping) {

                $sync[$topping->id] = [
                    'price' => 0
                ];
            }

            return $this->productRepository
                ->updateToppings($id, $sync);
        }

        // chỉ lưu topping được chọn
        $sync = [];

        foreach ($data['toppings'] ?? [] as $idTopping) {

            $sync[$idTopping] = [
                'price' => 0
            ];
        }

        return $this->productRepository
            ->updateToppings($id, $sync);
    }
}
