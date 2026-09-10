<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Order;

class UserRepository implements UserRepositoryInterface
{
    public function getCustomers()
    {
        return User::where('role_id', 2)
            ->withCount('orders')
            ->withCount([
                'orders as completed_orders_count' => function ($q) {
                    $q->where('status', 'completed');
                },
                'orders as cancelled_orders_count' => function ($q) {
                    $q->where('status', 'cancelled');
                }
            ])
            ->withSum([
                'orders as total_spent' => function ($q) {
                    $q->where('status', 'completed');
                }
            ], 'total')
            ->latest()
            ->get();
    }
    public function findCustomer(int $id)
    {
        return User::where('role_id', 2)
            ->withCount('orders')
            ->withCount([
                'orders as completed_orders_count' => function ($q) {
                    $q->where('status', 'completed');
                },
                'orders as cancelled_orders_count' => function ($q) {
                    $q->where('status', 'cancelled');
                }
            ])
            ->withSum([
                'orders as total_spent' => function ($q) {
                    $q->where('status', 'completed');
                }
            ], 'total')
            ->findOrFail($id);
    }
    public function orders($id)
    {
        $user = User::findOrFail($id);

        return $user->orders()
            ->with('items.product')
            ->whereIn('status', [
                'completed',
                'cancelled'
            ])
            ->latest()
            ->get();
    }
}
