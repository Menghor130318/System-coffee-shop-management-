<?php

namespace App\Services;

use App\Interfaces\CartRepositoryInterface;
use App\Services\PriceCalculatorService;

class CartService
{
    protected CartRepositoryInterface $cartRepository;

    protected PriceCalculatorService $calculator;

    public function __construct(
        CartRepositoryInterface $repository,
        PriceCalculatorService $calculator
    ) {
        $this->cartRepository = $repository;
        $this->calculator = $calculator;
    }

    public function add(array $data)
    {
        return $this->cartRepository->add($data);
    }

    public function items($cartId)
    {
        return $this->cartRepository->items($cartId);
    }

    public function remove($itemId)
    {
        return $this->cartRepository->remove($itemId);
    }

    public function update($itemId, array $data)
    {
        return $this->cartRepository->update($itemId, $data);
    }

    public function clear($cartId)
    {
        return $this->cartRepository->clear($cartId);
    }
    public function list()
    {
        return $this->cartRepository->list();
    }
}
