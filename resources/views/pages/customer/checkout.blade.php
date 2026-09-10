@extends('layouts.customer')

@section('title', 'Checkout')

@section('content')
<style>
    :root {
        --coffee-dark: #2b1810;
        --coffee-accent: #c89666;
    }
    .payment-option-card {
        border: 2px solid #ebe3d9;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
        height: 100%;
    }
    .payment-option-card:hover {
        border-color: var(--coffee-accent);
    }
    .payment-radio:checked + .payment-option-card {
        border-color: var(--coffee-dark);
        background-color: #fdfaf7;
        box-shadow: 0 4px 12px rgba(43, 24, 16, 0.1);
    }
    .payment-radio {
        display: none;
    }
    .checkout-card {
        border-radius: 16px;
        border: 1px solid #ede3da;
        background: #fff;
    }

    /* Styling ABA KHQR Card */
    .aba-card {
        max-width: 330px;
        background: #101c2c;
        border-radius: 22px;
        overflow: hidden;
        color: #ffffff;
        border: 1px solid #23344a;
        margin: 0 auto;
    }
    .aba-header {
        background-color: #e1251b;
        padding: 10px 0;
        text-align: center;
    }
    .khqr-title {
        font-size: 1.35rem;
        font-weight: 900;
        letter-spacing: 2px;
        color: #ffffff;
    }
    .aba-body {
        padding: 20px 18px 16px;
    }
    .merchant-name {
        font-size: 0.95rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #e1e8f0;
        text-transform: uppercase;
    }
    .order-price {
        font-size: 2.2rem;
        font-weight: 800;
        color: #ffffff;
        margin-top: 4px;
        line-height: 1.1;
    }
    .currency-symbol {
        font-size: 1.4rem;
        margin-right: 2px;
        color: #2ecc71;
    }
    .price-khr {
        font-size: 0.85rem;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    /* Timer Style */
    .timer-badge {
        display: inline-block;
        background: rgba(255, 193, 7, 0.15);
        border: 1px solid rgba(255, 193, 7, 0.4);
        color: #ffc107;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .qr-container {
        background: #ffffff;
        padding: 12px;
        border-radius: 16px;
        display: inline-block;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        position: relative;
    }
    .qr-image {
        width: 210px;
        height: 210px;
        object-fit: contain;
        display: block;
        border-radius: 8px;
        transition: opacity 0.3s ease;
    }
    .expired-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.96);
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 5;
    }
    .aba-footer-info {
        font-size: 0.82rem;
        background: rgba(255, 255, 255, 0.08);
        padding: 12px 14px;
        border-radius: 12px;
        margin-top: 14px;
        text-align: left;
    }
</style>

<div class="container py-5">
    <h3 class="font-weight-bold mb-4" style="color: var(--coffee-dark);">Checkout</h3>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @php
        // ១. គណនាតម្លៃសរុបចេញពី Cart
        $subtotal = 0;
        $cart = session()->get('cart', []);
        foreach($cart as $item) {
            $price = $item['price_min'] ?? ($item['price'] ?? 0);
            $subtotal += $price * ($item['quantity'] ?? 1);
        }
        if($subtotal <= 0 && isset($total)) {
            $subtotal = $total;
        }
        if($subtotal <= 0) {
            $subtotal = 1.75; // តម្លៃទាបបំផុតការពារកុំឱ្យចេញ 0
        }

        // ២. Function គណនា CRC16 CCITT (False) តាមស្តង់ដារ KHQR / EMVCo
        if (!function_exists('calcKhqrCrc16')) {
            function calcKhqrCrc16($data) {
                $crc = 0xFFFF;
                $len = strlen($data);
                for ($i = 0; $i < $len; $i++) {
                    $crc ^= (ord($data[$i]) << 8);
                    for ($j = 0; $j < 8; $j++) {
                        if ($crc & 0x8000) {
                            $crc = (($crc << 1) ^ 0x1021) & 0xFFFF;
                        } else {
                            $crc = ($crc << 1) & 0xFFFF;
                        }
                    }
                }
                return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
            }
        }

        // ៣. បង្កើត Dynamic KHQR Payload ដែលមានតម្លៃលុយតាម Menu
        $amountStr = number_format($subtotal, 2, '.', ''); // e.g. "1.75"
        
        $t00 = "000201";
        $t01 = "010212"; // 12 = Dynamic QR (លោតតម្លៃស្វ័យប្រវត្តិពេល Scan)
        $t29 = "29450016abaakhppxxx@abaa01090041174520208ABA Bank"; // USD Account: 004117452
        $t40 = "40600006abaP2P0112E31B5645B360020900459366903090041174520404Dual";
        $t52 = "52040000";
        $t53 = "5303840"; // 840 = USD Currency
        $t54 = "54" . sprintf("%02d", strlen($amountStr)) . $amountStr; // បញ្ចូលតម្លៃទឹកប្រាក់
        $t58 = "5802KH";
        $t59 = "5912MENGHOR CHIB";
        $t60 = "6010Phnom Penh";
        $t63_prefix = "6304";

        $khqrPayload = $t00 . $t01 . $t29 . $t40 . $t52 . $t53 . $t54 . $t58 . $t59 . $t60 . $t63_prefix;
        $crcChecksum = calcKhqrCrc16($khqrPayload);
        $finalKhqrData = $khqrPayload . $crcChecksum;

        // បង្កើតរូបភាព QR Code ភ្លាមៗពី String Dynamic នេះ
        $dynamicQrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=" . urlencode($finalKhqrData);
    @endphp

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- ផ្នែកខាងឆ្វេង៖ Shipping & Payment -->
            <div class="col-lg-8">
                <!-- Shipping Information -->
                <div class="card checkout-card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="font-weight-bold mb-3" style="color: var(--coffee-dark);">Shipping Information</h5>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="096xxxxxxx" required>
                            </div>
                            <div class="col-12 form-group">
                                <label class="font-weight-bold">Delivery Address <span class="text-danger">*</span></label>
                                <textarea name="address" rows="2" class="form-control" placeholder="Street, Khan, Sangkat, Phnom Penh..." required>{{ old('address') }}</textarea>
                            </div>
                            <div class="col-12 form-group mb-0">
                                <label class="font-weight-bold">Order Note (Optional)</label>
                                <input type="text" name="note" class="form-control" placeholder="Less ice, less sugar, etc.">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card checkout-card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="font-weight-bold mb-3" style="color: var(--coffee-dark);">Payment Method</h5>
                        <div class="row">
                            <!-- Cash -->
                            <div class="col-md-4 mb-3">
                                <label class="w-100 mb-0">
                                    <input type="radio" name="payment_method" value="cash" class="payment-radio" checked onchange="togglePaymentBox('cash')">
                                    <div class="payment-option-card">
                                        <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
                                        <div class="font-weight-bold">Cash</div>
                                        <small class="text-muted">Pay on delivery</small>
                                    </div>
                                </label>
                            </div>

                            <!-- Card -->
                            <div class="col-md-4 mb-3">
                                <label class="w-100 mb-0">
                                    <input type="radio" name="payment_method" value="card" class="payment-radio" onchange="togglePaymentBox('card')">
                                    <div class="payment-option-card">
                                        <i class="fas fa-credit-card fa-2x text-primary mb-2"></i>
                                        <div class="font-weight-bold">Card</div>
                                        <small class="text-muted">ABA / Visa / Master</small>
                                    </div>
                                </label>
                            </div>

                            <!-- KHQR -->
                            <div class="col-md-4 mb-3">
                                <label class="w-100 mb-0">
                                    <input type="radio" name="payment_method" value="khqr" class="payment-radio" onchange="togglePaymentBox('khqr')">
                                    <div class="payment-option-card">
                                        <i class="fas fa-qrcode fa-2x text-danger mb-2"></i>
                                        <div class="font-weight-bold">KHQR</div>
                                        <small class="text-muted">Scan QR to pay</small>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Card Input Details -->
                        <div id="card-box" class="p-3 border rounded bg-light mt-3" style="display: none;">
                            <h6 class="font-weight-bold mb-3"><i class="fas fa-lock text-success mr-1"></i> Card Payment Details</h6>
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">Card Number</label>
                                <input type="text" class="form-control" name="card_number" value="4026 4503 0787 0450">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label class="small font-weight-bold">Expiry</label>
                                    <input type="text" class="form-control" value="12/28" placeholder="MM/YY">
                                </div>
                                <div class="col-6">
                                    <label class="small font-weight-bold">CVV</label>
                                    <input type="password" class="form-control" value="888" placeholder="•••">
                                </div>
                            </div>
                        </div>

                        <!-- ABA KHQR Details (Dynamic QR: លោតតម្លៃលុយស្វ័យប្រវត្តិ) -->
                        <div id="khqr-box" class="mt-3 text-center" style="display: none;">
                            <div class="aba-card shadow-lg">
                                <div class="aba-header">
                                    <span class="khqr-title">KHQR</span>
                                </div>

                                <div class="aba-body">
                                    <div class="merchant-name">MENGHOR CHIB</div>
                                    <div class="order-price">
                                        <span class="currency-symbol">$</span>{{ number_format($subtotal, 2) }}
                                    </div>
                                    <div class="price-khr">
                                        ≈ {{ number_format($subtotal * 4100) }} KHR
                                    </div>

                                    <!-- នាឡិការាប់ថយក្រោយ ១ នាទី -->
                                    <div class="timer-badge">
                                        <i class="fas fa-stopwatch mr-1"></i> ផុតកំណត់ក្នុង: <span id="timer-display">01:00</span>
                                    </div>
                                    
                                    <div class="qr-container my-2">
                                        <!-- រូបភាព Dynamic QR កើតឡើងតាមតម្លៃ Cart ជាក់ស្ដែង -->
                                        <div id="qr-active-content">
                                            <img src="{{ $dynamicQrUrl }}" alt="ABA Dynamic KHQR" class="qr-image">
                                        </div>

                                        <!-- ផ្ទាំងពេលផុតកំណត់ ១ នាទី -->
                                        <div id="qr-expired-overlay" class="expired-overlay" style="display: none;">
                                            <i class="fas fa-clock fa-2x text-danger mb-2"></i>
                                            <div class="font-weight-bold text-dark mb-2 small">QR ផុតកំណត់ហើយ!</div>
                                            <button type="button" class="btn btn-sm btn-dark rounded-pill px-3" onclick="resetQrTimer()">
                                                <i class="fas fa-redo-alt mr-1"></i> បង្កើតថ្មី
                                            </button>
                                        </div>
                                    </div>

                                    <div class="aba-footer-info">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span><i class="fas fa-dollar-sign mr-1"></i> ប្រាក់ដុល្លារ ($):</span>
                                            <strong class="text-white">004 117 452</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span><i class="fas fa-coins mr-1"></i> ប្រាក់រៀល (៛):</span>
                                            <strong class="text-white">004 593 669</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-check-circle text-success mr-1"></i> ស្កេនជាមួយ ABA Mobile វានឹងលោតតម្លៃ <strong>${{ number_format($subtotal, 2) }}</strong> ស្វ័យប្រវត្តិ
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ផ្នែកខាងស្ដាំ៖ Order Summary -->
            <div class="col-lg-4">
                <div class="card checkout-card shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="font-weight-bold mb-3" style="color: var(--coffee-dark);">Order Summary</h5>
                        <hr>

                        @foreach ($cart as $item)
                            <div class="d-flex justify-content-between mb-2 small">
                                <span>{{ $item['product_name_kh'] ?? $item['name'] }} <span class="text-muted">x{{ $item['quantity'] }}</span></span>
                                <span class="font-weight-bold">${{ number_format(($item['price_min'] ?? ($item['price'] ?? 0)) * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach

                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="font-weight-bold">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <span class="font-weight-bold text-success">$0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="font-weight-bold fs-5">Total</span>
                            <div class="text-right">
                                <span class="font-weight-bold text-primary fs-5">${{ number_format($subtotal, 2) }}</span>
                                <div class="text-muted small">(≈ {{ number_format($subtotal * 4100) }}៛)</div>
                            </div>
                        </div>

                        <input type="hidden" name="total" value="{{ $subtotal }}">

                        <button type="submit" class="btn btn-dark btn-block py-2 font-weight-bold rounded-pill shadow-sm" style="background-color: var(--coffee-dark);">
                            <i class="fas fa-check-circle mr-1"></i> Place Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let countdownTimer = null;
    let timeLeft = 60; // រយៈពេល ១ នាទី

    function togglePaymentBox(method) {
        document.getElementById('card-box').style.display = (method === 'card') ? 'block' : 'none';
        const khqrBox = document.getElementById('khqr-box');
        
        if (method === 'khqr') {
            khqrBox.style.display = 'block';
            startQrTimer();
        } else {
            khqrBox.style.display = 'none';
            stopQrTimer();
        }
    }

    function startQrTimer() {
        stopQrTimer();
        timeLeft = 60;
        updateTimerDisplay();

        const expiredOverlay = document.getElementById('qr-expired-overlay');
        const activeContent = document.getElementById('qr-active-content');
        
        if (expiredOverlay) expiredOverlay.style.display = 'none';
        if (activeContent) activeContent.style.opacity = '1';

        countdownTimer = setInterval(() => {
            timeLeft--;
            updateTimerDisplay();

            if (timeLeft <= 0) {
                clearInterval(countdownTimer);
                if (expiredOverlay) expiredOverlay.style.display = 'flex';
                if (activeContent) activeContent.style.opacity = '0.12';
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        const formatted = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        
        const displayElement = document.getElementById('timer-display');
        if (displayElement) {
            displayElement.innerText = formatted;
            displayElement.style.color = (timeLeft <= 10) ? '#ff4d4d' : '#ffc107';
        }
    }

    function stopQrTimer() {
        if (countdownTimer) {
            clearInterval(countdownTimer);
        }
    }

    function resetQrTimer() {
        startQrTimer();
    }
</script>
@endsection