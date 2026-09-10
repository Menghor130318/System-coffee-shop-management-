<?php

namespace App\Services\Payment;

class VNPayService
{
    protected string $tmnCode;

    protected string $hashSecret;

    protected string $url;

    protected string $returnUrl;
    public function __construct()
    {
        $this->tmnCode = config('vnpay.tmn_code');

        $this->hashSecret = config('vnpay.hash_secret');

        $this->url = config('vnpay.url');

        $this->returnUrl = config('vnpay.return_url');
    }
    public function createPaymentUrl(array $data)
    {
        $txnRef = $data['order_code'];

        $amount = $data['amount'];

        $orderInfo = "Thanh toan don hang " . $txnRef;

        $createDate = date('YmdHis');

        $expireDate = date('YmdHis', strtotime('+15 minutes'));
        $inputData = [

            "vnp_Version" => "2.1.0",

            "vnp_Command" => "pay",

            "vnp_TmnCode" => $this->tmnCode,

            "vnp_Amount" => $amount * 100,

            "vnp_CreateDate" => $createDate,

            "vnp_CurrCode" => "VND",

            "vnp_IpAddr" => request()->ip() ?? "127.0.0.1",

            "vnp_Locale" => "vn",

            "vnp_OrderInfo" => $orderInfo,

            "vnp_OrderType" => "other",

            "vnp_ReturnUrl" => $this->returnUrl,

            "vnp_TxnRef" => $txnRef,

            "vnp_ExpireDate" => $expireDate

        ];
        ksort($inputData);

        $query = "";

        $hashData = "";

        $i = 0;

        foreach ($inputData as $key => $value) {

            if ($i == 1) {

                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {

                $hashData .= urlencode($key) . "=" . urlencode($value);

                $i = 1;
            }

            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $secureHash = hash_hmac(
            'sha512',
            $hashData,
            $this->hashSecret
        );
        $query .= 'vnp_SecureHash=' . $secureHash;
        $paymentUrl = $this->url . "?" . $query;
        return [

            'payment_url' => $paymentUrl

        ];
    }

    public function verifyReturn(array $data)
    {
        $vnpSecureHash = $data['vnp_SecureHash'] ?? '';

        unset($data['vnp_SecureHash']);
        unset($data['vnp_SecureHashType']);

        ksort($data);

        $hashData = "";

        $i = 0;

        foreach ($data as $key => $value) {

            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac(
            'sha512',
            $hashData,
            $this->hashSecret
        );

        return [

            'is_valid' => hash_equals($secureHash, $vnpSecureHash),

            'my_hash' => $secureHash,

            'vnp_hash' => $vnpSecureHash,

            'response_code' => $data['vnp_ResponseCode'] ?? null,

            'txn_ref' => $data['vnp_TxnRef'] ?? null,

            'transaction_no' => $data['vnp_TransactionNo'] ?? null,

            'amount' => isset($data['vnp_Amount'])
                ? $data['vnp_Amount'] / 100
                : 0,

            'bank_code' => $data['vnp_BankCode'] ?? null,

            'pay_date' => $data['vnp_PayDate'] ?? null,

            'raw' => $data
        ];
    }
}
