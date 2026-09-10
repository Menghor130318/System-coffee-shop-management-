<?php

namespace App\Interfaces;

interface CartRepositoryInterface
{
    public function add(array $data);

    public function items($cartId);

    public function remove($itemId);

    public function update($itemId, array $data);

    public function clear($cartId);
    public function list();

}
