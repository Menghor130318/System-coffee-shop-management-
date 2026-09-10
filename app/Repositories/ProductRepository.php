<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function index()
    {
        return $this->product
            ->with([
                'category',
                'sizes',
                'sweetnessLevels',
                'iceLevels',
                'toppings'
            ])
            ->orderBy('id')
            ->get();
    }


    public function show($id)
    {
        $product = $this->product
            ->with([
                'category',
                'sizes',
                'sweetnessLevels',
                'iceLevels',
                'toppings',
            ])
            ->findOrFail($id);

        // Nếu dùng tất cả topping
        if ($product->use_all_toppings) {

            $product->setRelation(
                'toppings',
                \App\Models\Topping::where('status', 1)->get()
            );
        }

        return $product;
    }
    public function create(array $data)
    {
        return $this->product->create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->show($id);

        $product->update($data);

        return $product;
    }
    public function delete($id)
    {
        $product = $this->show($id);

        return $product->delete();
    }
    public function options($id)
    {
        return $this->product
            ->with([
                'sizes',
                'sweetnessLevels',
                'iceLevels',
                'toppings'
            ])
            ->findOrFail($id);
    }
    public function calculate(int $productId, array $data)
    {
        $product = Product::with([
            'sizes',
            'toppings'
        ])->findOrFail($productId);

        $basePrice = (float) $product->price;

        // Giá cộng thêm của size
        $size = $product->sizes()
            ->where('sizes.id', $data['size_id'])
            ->first();

        $sizeExtra = $size
            ? (float) $size->pivot->price
            : 0;

        // Tổng tiền topping
        $toppingTotal = $product->toppings()
            ->whereIn('toppings.id', $data['topping_ids'] ?? [])
            ->sum('toppings.price');
        // Giá 1 ly
        $unitPrice = $basePrice + $sizeExtra + $toppingTotal;

        // Thành tiền
        $quantity = $data['quantity'] ?? 1;

        $total = $unitPrice * $quantity;

        return [
            'product' => $product->name,

            'base_price' => $basePrice,

            'size_extra' => $sizeExtra,

            'topping_total' => $toppingTotal,

            'unit_price' => $unitPrice,

            'quantity' => $quantity,

            'total' => $total,

            'selected' => [
                'size_id' => $data['size_id'],
                'sweetness_level_id' => $data['sweetness_level_id'],
                'ice_level_id' => $data['ice_level_id'],
                'topping_ids' => $data['topping_ids'] ?? [],
            ]
        ];
    }
    public function sizes($id)
    {
        $product = Product::with('sizes')->findOrFail($id);

        $allSizes = \App\Models\Size::all();

        return [
            'product' => $product,
            'sizes' => $allSizes,
            'selected' => $product->sizes->pluck('id')
        ];
    }
    public function updateSizes($id, array $sizes)
    {
        $product = $this->show($id);

        $syncData = [];

        foreach ($sizes as $size) {

            $syncData[$size['id']] = [
                'price' => $size['price']
            ];
        }

        $product->sizes()->sync($syncData);

        return $product->load('sizes');
    }
    public function sweetnessLevels($id)
    {
        $product = Product::with('sweetnessLevels')->findOrFail($id);

        $allSweetnessLevels = \App\Models\SweetnessLevel::all();

        return [
            'product' => $product,
            'sweetnessLevels' => $allSweetnessLevels,
            'selected' => $product->sweetnessLevels->pluck('id')
        ];
    }
    public function updateSweetnessLevels($id, array $sweetnessLevels)
    {
        $product = $this->show($id);

        $product->sweetnessLevels()->sync($sweetnessLevels);

        return $product->load('sweetnessLevels');
    }
    public function iceLevels($id)
    {
        $product = Product::with('iceLevels')->findOrFail($id);

        $allIceLevels = \App\Models\IceLevel::all();

        return [
            'product' => $product,
            'iceLevels' => $allIceLevels,
            'selected' => $product->iceLevels->pluck('id')
        ];
    }
    public function updateIceLevels($id, array $iceLevels)
    {
        $product = $this->show($id);

        $product->iceLevels()->sync($iceLevels);

        return $product->load('iceLevels');
    }
    public function toppings($id)
    {
        $product = Product::with('toppings')->findOrFail($id);

        $allToppings = \App\Models\Topping::all();

        return [
            'product' => $product,
            'toppings' => $allToppings,
            'selected' => $product->toppings->pluck('id'),
        ];
    }
    public function updateToppings($id, array $toppings)
    {
        $product = $this->show($id);

        $product->toppings()->sync($toppings);

        return $product->load('toppings');
    }
}
