<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Payment\VNPayService;
use Illuminate\Http\Request;
use App\Repositories\PaymentRepository;


class PaymentController extends Controller
{
    protected VNPayService $vnPayService;
    protected PaymentRepository $paymentRepository;

    public function __construct(
        VNPayService $vnPayService,
        PaymentRepository $paymentRepository
    ) {
        $this->vnPayService = $vnPayService;
        $this->paymentRepository = $paymentRepository;
    }
    public function create(Request $request)
    {
        $request->validate([
            'order_code' => 'required',
            'amount' => 'required|numeric|min:1000'
        ]);

        return response()->json(
            $this->vnPayService->createPaymentUrl(
                $request->all()
            )
        );
    }
    public function callback(Request $request)
    {
        $result = $this->vnPayService->verifyReturn(
            $request->all()
        );

        // Sai chữ ký
        if (!$result['is_valid']) {

            return redirect(
                config('app.frontend_url')
                    . '/payment/failed'
            );
        }

        // Thanh toán thành công
        if ($result['response_code'] === '00') {

            $order = $this->paymentRepository
                ->paymentSuccess(
                    $result['txn_ref'],
                    $result['transaction_no']
                );

            return redirect(
                config('app.frontend_url')
                    . '/payment/success?order='
                    . $order->order_code
            );
        }

        // Thanh toán thất bại
        $this->paymentRepository
            ->paymentFailed(
                $result['txn_ref']
            );

        return redirect(
            config('app.frontend_url')
                . '/payment/failed?order='
                . $result['txn_ref']
        );
    }
    public function retry(string $orderCode)
    {
        return response()->json(
            $this->paymentRepository
                ->retry($orderCode)
        );
    }
}
