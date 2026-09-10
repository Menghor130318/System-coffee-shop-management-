@extends('layouts.app')

@section('title', 'Manage Order')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Order #{{ $order->transaction_no ?? $order->order_number ?? ('ORD-' . $order->id) }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('order.index') }}">Orders</a></div>
                    <div class="breadcrumb-item">Manage</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')
                
                <div class="row">
                    <!-- ផ្នែកខាងឆ្វេង៖ ព័ត៌មានលម្អិតនៃ Order -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-header">
                                <h4>Order Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Customer:</strong> {{ $order->customer_name ?? $order->user->full_name ?? $order->user->name ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Phone:</strong> {{ $order->phone ?? $order->user->phone ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Email:</strong> {{ $order->email ?? $order->user->email ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Note:</strong> {{ $order->note ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Date:</strong> {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i') : 'N/A' }}</p>
                                    </div>
                                </div>

                                @php
                                    $orderItems = $order->items ?? $order->orderDetails ?? [];
                                @endphp

                                @if (count($orderItems) > 0)
                                    <div class="table-responsive">
                                        <table class="table-sm table-bordered table">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Product</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-right">Price</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orderItems as $item)
                                                    @php
                                                        $unitPrice = $item->unit_price ?? $item->price ?? 0;
                                                        $totalPrice = $item->total_price ?? ($unitPrice * ($item->quantity ?? 1));
                                                        
                                                        // គណនាបង្ហាញជា $ និង ៛ តាមតម្លៃ
                                                        $priceUsd = $unitPrice > 500 ? $unitPrice / 4100 : $unitPrice;
                                                        $totalUsd = $totalPrice > 500 ? $totalPrice / 4100 : $totalPrice;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $item->product->name ?? $item->product_name ?? ('Product #' . ($item->product_id ?? '')) }}</td>
                                                        <td class="text-center">{{ $item->quantity ?? $item->qty ?? 1 }}</td>
                                                        <td class="text-right">${{ number_format($priceUsd, 2) }}</td>
                                                        <td class="text-right font-weight-bold">${{ number_format($totalUsd, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-warning">No items found for this order.</div>
                                @endif

                                <hr>
                                
                                @php
                                    $rawTotal = $order->total ?? $order->total_amount ?? 0;
                                    $totalUsd = $rawTotal > 500 ? $rawTotal / 4100 : $rawTotal;
                                    $totalKhr = $rawTotal > 500 ? $rawTotal : $rawTotal * 4100;
                                @endphp

                                <div class="text-right">
                                    <div><span class="text-muted">Subtotal:</span> <strong>${{ number_format($order->subtotal ?? $totalUsd, 2) }}</strong></div>
                                    <div><span class="text-muted">Shipping:</span> <strong>${{ number_format($order->shipping_fee ?? 0, 2) }}</strong></div>
                                    <div><span class="text-muted">Discount:</span> <strong>${{ number_format($order->discount ?? 0, 2) }}</strong></div>
                                    <div class="mt-2">
                                        <span class="text-muted">Total:</span> 
                                        <strong class="text-success" style="font-size:1.4rem">${{ number_format($totalUsd, 2) }}</strong>
                                        <small class="text-muted d-block">(≈ {{ number_format($totalKhr) }}៛)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ផ្នែកខាងស្តាំ៖ Update Status & Receiver -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header">
                                <h4>Update Status & Receiver</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('order.update', $order->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label class="font-weight-bold">Order Status</label>
                                        <select name="status" class="form-control">
                                            <option value="waiting_payment" {{ $order->status == 'waiting_payment' ? 'selected' : '' }}>Waiting Payment</option>
                                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Payment Status</label>
                                        <select name="payment_status" class="form-control">
                                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Assign Receiver</label>
                                        <select name="receiver_user_id" class="form-control">
                                            <option value="">-- Select receiver --</option>
                                            @foreach ($staff ?? [] as $user)
                                                <option value="{{ $user->id }}" {{ ($order->receiver_user_id ?? $order->receiver_id) == $user->id ? 'selected' : '' }}>
                                                    {{ $user->full_name ?? $user->name }} ({{ $user->role->name ?? $user->role ?? 'Staff' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">The person who accepts/completes this order.</small>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm mt-4">
                                        <i class="fas fa-save mr-1"></i> Save Changes
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection