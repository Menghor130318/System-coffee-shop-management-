@extends('layouts.app')

@section('title', 'Orders')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Orders</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Orders</div>
                    <div class="breadcrumb-item">All Orders</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>All Orders</h4>
                                <a href="{{ route('reports.index') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-print"></i> Print Report
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Customer</th>
                                                <th>Phone</th>
                                                <th class="text-right">Total</th>
                                                <th class="text-center">Payment</th>
                                                <th class="text-center">Status</th>
                                                <th>Receiver</th>
                                                <th>Date</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($orders as $order)
                                                @php
                                                    $rawTotal = $order->total ?? $order->total_amount ?? 0;
                                                    $totalUsd = $rawTotal > 500 ? $rawTotal / 4100 : $rawTotal;
                                                    $totalKhr = $rawTotal > 500 ? $rawTotal : $rawTotal * 4100;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <strong>{{ $order->transaction_no ?? $order->order_number ?? ('ORD-' . $order->id) }}</strong>
                                                    </td>
                                                    <td>{{ $order->customer_name ?? $order->user->name ?? $order->user->full_name ?? 'N/A' }}</td>
                                                    <td>{{ $order->phone ?? $order->user->phone ?? 'N/A' }}</td>
                                                    <td class="text-right">
                                                        <div class="font-weight-bold">${{ number_format($totalUsd, 2) }}</div>
                                                        <small class="text-muted font-weight-normal">(≈ {{ number_format($totalKhr) }}៛)</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge badge-secondary d-block mb-1">
                                                            {{ strtoupper($order->payment_method ?? 'CASH') }}
                                                        </span>
                                                        <span class="badge badge-{{ ($order->payment_status ?? '') == 'paid' ? 'success' : 'warning' }}">
                                                            {{ ucfirst($order->payment_status ?? 'Pending') }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $badge = 'info';
                                                            $statusLabel = ucfirst(str_replace('_', ' ', $order->status ?? 'pending'));
                                                            if ($order->status == 'completed') $badge = 'success';
                                                            elseif ($order->status == 'preparing') $badge = 'primary';
                                                            elseif ($order->status == 'cancelled') $badge = 'danger';
                                                            elseif ($order->status == 'waiting_payment') $badge = 'warning';
                                                        @endphp
                                                        <span class="badge badge-{{ $badge }} p-2">
                                                            {{ $statusLabel }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($order->receiver)
                                                            {{ $order->receiver->full_name ?? $order->receiver->name }}
                                                        @else
                                                            <span class="text-muted">Not assigned</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i') : 'N/A' }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <!-- ប៊ូតុងមើល Order Details (Modal) -->
                                                            <button type="button" class="btn btn-sm btn-primary btn-icon mr-1" data-toggle="modal" data-target="#orderDetailModal{{ $order->id }}">
                                                                <i class="fas fa-eye"></i> Details
                                                            </button>

                                                            <a href="{{ route('order.edit', $order->id) }}" class="btn btn-sm btn-info btn-icon mr-1">
                                                                <i class="fas fa-edit"></i> Manage
                                                            </a>

                                                            <form action="{{ route('order.destroy', $order->id) }}" method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this order?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger btn-icon">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Modal សម្រាប់បង្ហាញ Order Details -->
                                                <div class="modal fade" id="orderDetailModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="orderDetailModalLabel{{ $order->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="orderDetailModalLabel{{ $order->id }}">Order Details - #{{ $order->transaction_no ?? $order->order_number ?? $order->id }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-left">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <p class="mb-1"><strong>Customer:</strong> {{ $order->customer_name ?? $order->user->name ?? 'N/A' }}</p>
                                                                        <p class="mb-1"><strong>Phone:</strong> {{ $order->phone ?? $order->user->phone ?? 'N/A' }}</p>
                                                                        <p class="mb-1"><strong>Payment Method:</strong> {{ strtoupper($order->payment_method ?? 'CASH') }}</p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p class="mb-1"><strong>Status:</strong> <span class="badge badge-{{ $badge }}">{{ $statusLabel }}</span></p>
                                                                        <p class="mb-1"><strong>Payment Status:</strong> {{ ucfirst($order->payment_status ?? 'Pending') }}</p>
                                                                        <p class="mb-1"><strong>Date:</strong> {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i') : 'N/A' }}</p>
                                                                    </div>
                                                                </div>

                                                                <h6>Order Items</h6>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-sm">
                                                                        <thead>
                                                                            <tr class="bg-light">
                                                                                <th>Product</th>
                                                                                <th class="text-center">Qty</th>
                                                                                <th class="text-right">Unit Price</th>
                                                                                <th class="text-right">Total Price</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @forelse ($order->orderDetails ?? $order->details ?? $order->items ?? [] as $detail)
                                                                                @php
                                                                                    $unitPrice = $detail->unit_price ?? $detail->price ?? 0;
                                                                                    $totalPrice = $detail->total_price ?? ($unitPrice * $detail->quantity);
                                                                                    
                                                                                    $unitUsd = $unitPrice > 500 ? $unitPrice / 4100 : $unitPrice;
                                                                                    $totalUsdDetail = $totalPrice > 500 ? $totalPrice / 4100 : $totalPrice;
                                                                                    $totalKhrDetail = $totalPrice > 500 ? $totalPrice : $totalPrice * 4100;
                                                                                @endphp
                                                                                <tr>
                                                                                    <td>{{ $detail->product->name ?? $detail->product_name ?? 'Product' }}</td>
                                                                                    <td class="text-center">{{ $detail->quantity ?? $detail->qty ?? 1 }}</td>
                                                                                    <td class="text-right">${{ number_format($unitUsd, 2) }}</td>
                                                                                    <td class="text-right">
                                                                                        ${{ number_format($totalUsdDetail, 2) }}
                                                                                        <br><small class="text-muted">(≈ {{ number_format($totalKhrDetail) }}៛)</small>
                                                                                    </td>
                                                                                </tr>
                                                                            @empty
                                                                                <tr>
                                                                                    <td colspan="4" class="text-center text-muted">No items found for this order.</td>
                                                                                </tr>
                                                                            @endforelse
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                                                    <h5 class="mb-0">Grand Total:</h5>
                                                                    <div class="text-right">
                                                                        <h4 class="text-success mb-0">${{ number_format($totalUsd, 2) }}</h4>
                                                                        <small class="text-muted">(≈ {{ number_format($totalKhr) }}៛)</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center py-4">No orders found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right mt-3">
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush