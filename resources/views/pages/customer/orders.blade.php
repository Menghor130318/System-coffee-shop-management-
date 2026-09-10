@extends('layouts.customer')

@section('title', 'My Orders')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">My Orders</h2>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            @if ($orders->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-receipt" style="font-size: 80px; color: #C8A96A;"></i>
                    <h4 class="mt-3 text-muted">You have no orders yet</h4>
                    <a href="{{ route('menu') }}" class="btn btn-hero mt-3">Order Now</a>
                </div>
            @else
                <div class="row">
                    @foreach ($orders as $order)
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <strong>Order #{{ $order->transaction_no ?? $order->order_number ?? $order->id }}</strong>
                                        <span class="text-muted ml-2">{{ $order->created_at ? $order->created_at->format('M d, Y H:i') : '' }}</span>
                                    </div>
                                    <div class="mt-2 mt-md-0">
                                        @php
                                            $badgeColor = 'info';
                                            $statusLabel = ucfirst(str_replace('_', ' ', $order->status ?? 'pending'));
                                            if ($order->status == 'completed') { $badgeColor = 'success'; $statusLabel = 'Completed'; }
                                            elseif ($order->status == 'preparing') { $badgeColor = 'primary'; $statusLabel = 'Preparing'; }
                                            elseif ($order->status == 'cancelled') { $badgeColor = 'danger'; $statusLabel = 'Cancelled'; }
                                            elseif ($order->status == 'waiting_payment') { $badgeColor = 'warning'; $statusLabel = 'Waiting Payment'; }
                                        @endphp
                                        <span class="badge badge-{{ $badgeColor }} p-2">
                                            <i class="fas fa-{{ $order->status == 'waiting_payment' ? 'hourglass-half' : ($order->status == 'completed' ? 'check-circle' : ($order->status == 'preparing' ? 'fire' : ($order->status == 'cancelled' ? 'times-circle' : 'info-circle'))) }} mr-1"></i>
                                            {{ $statusLabel }}
                                        </span>
                                        <span class="badge badge-secondary p-2 ml-1">
                                            {{ strtoupper($order->payment_method ?? 'CASH') }}
                                        </span>
                                        <span class="badge badge-{{ ($order->payment_status ?? '') == 'paid' ? 'success' : 'danger' }} p-2 ml-1">
                                            {{ ucfirst($order->payment_status ?? 'Pending') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($order->items && $order->items->count())
                                        <table class="table table-sm table-borderless mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Qty</th>
                                                    <th class="text-right">Price</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->items as $item)
                                                    @php
                                                        $unitPrice = $item->unit_price ?? $item->price ?? 0;
                                                        $totalPrice = $item->total_price ?? ($unitPrice * $item->quantity);
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            {{ $item->product->product_name_kh ?? $item->product->product_name ?? $item->product->name ?? $item->product_name ?? 'Coffee' }}
                                                        </td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td class="text-right">${{ number_format($unitPrice, 2) }}</td>
                                                        <td class="text-right">${{ number_format($totalPrice, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-muted mb-0">Order details not available.</p>
                                    @endif
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                                        <div class="text-muted">
                                            @if ($order->receiver)
                                                <i class="fas fa-user-check mr-1"></i>Received by: <strong>{{ $order->receiver->full_name ?? $order->receiver->name }}</strong>
                                            @else
                                                <i class="fas fa-user-clock mr-1"></i>Waiting for staff to accept your order.
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            @php
                                                $subtotal = $order->subtotal ?? $order->total_amount ?? $order->total ?? 0;
                                                $shipping = $order->shipping_fee ?? 0;
                                                $total = $order->total ?? $order->total_amount ?? ($subtotal + $shipping);
                                            @endphp
                                            <div><span class="text-muted">Subtotal:</span> <strong>${{ number_format($subtotal, 2) }}</strong></div>
                                            <div><span class="text-muted">Shipping:</span> <strong>${{ number_format($shipping, 2) }}</strong></div>
                                            <div class="mt-1">
                                                <span class="text-muted">Total:</span> 
                                                <strong class="text-primary" style="font-size:1.2rem">${{ number_format($total, 2) }}</strong>
                                                <div class="small text-muted">(≈ {{ number_format($total * 4100) }}៛)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection