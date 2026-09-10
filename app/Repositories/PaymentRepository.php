<?php

namespace App\Repositories;

use App\Models\Order;
use App\Services\Payment\VNPayService;

class PaymentRepository
{
    protected VNPayService $vnPayService;

    public function __construct(
        VNPayService $vnPayService
    ) {
        $this->vnPayService = $vnPayService;
    }
    public function paymentSuccess(
        string $orderCode,
        string $transactionNo
    ) {
        $order = Order::where(
            'order_code',
            $orderCode
        )->firstOrFail();

        $order->update([
            'payment_status' => 'paid',
            'status' => 'pending_confirmation',
            'paid_at' => now(),
            'transaction_no' => $transactionNo,
        ]);

        return $order;
    }
    public function paymentFailed(
        string $orderCode
    ) {
        $order = Order::where(
            'order_code',
            $orderCode
        )->firstOrFail();

        $order->update([
            'payment_status' => 'failed',
            'status' => 'waiting_payment',
        ]);

        return $order;
    }
    public function retry(string $orderCode)
    {
        $order = Order::where(
            'order_code',
            $orderCode
        )->firstOrFail();

        if (
            $order->payment_status === 'paid'
        ) {

            abort(
                400,
                'Đơn hàng đã thanh toán.'
            );
        }

        $order->update([

            'payment_status' => 'pending',

            'status' => 'waiting_payment'

        ]);

        return $this->vnPayService
            ->createPaymentUrl([

                'order_code' => $order->order_code,

                'amount' => $order->total

            ]);
    }
}
