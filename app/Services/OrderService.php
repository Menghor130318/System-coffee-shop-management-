<?php

namespace App\Services;

use App\Interfaces\OrderRepositoryInterface;
use App\Services\Payment\VNPayService;


class OrderService
{
    protected OrderRepositoryInterface $orderRepository;
    protected VNPayService $vnPayService;

    public function __construct(
        OrderRepositoryInterface $repository,
        VNPayService $vnPayService
    ) {
        $this->orderRepository = $repository;
        $this->vnPayService = $vnPayService;
    }

    public function checkout(array $data)
    {
        return $this->orderRepository
            ->checkout($data);
    }
    public function checkoutVnpay(array $data)
    {
        $order = $this->orderRepository->checkout($data);

        $payment = $this->vnPayService->createPaymentUrl([
            'order_code' => $order->order_code,
            'amount' => $order->total
        ]);

        return [
            'order' => $order,
            'payment_url' => $payment['payment_url']
        ];
    }

    public function history()
    {
        return $this->orderRepository->history();
    }

    public function detail($id)
    {
        return $this->orderRepository->detail($id);
    }

    public function cancel($id)
    {
        return $this->orderRepository->cancel($id);
    }
    public function received($id)
    {
        return $this->orderRepository->received($id);
    }
    public function adminList()
    {
        return $this->orderRepository->adminList();
    }
    public function updateStatus($id, array $data)
    {
        return $this->orderRepository
            ->updateStatus($id, $data);
    }
    public function show($id)
    {
        return $this->orderRepository->show($id);
    }
    public function pendingConfirmationOrders()
    {
        return $this->orderRepository->pendingConfirmationOrders();
    }
}
