@extends('layouts.customer')

@section('title', 'Invoice #' . ($order->transaction_no ?? $order->id))

@section('content')
    <section class="py-5 invoice-page">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 no-print">
                <h2 class="section-title mb-0">Invoice</h2>
                <div>
                    <a href="{{ route('my.orders') }}" class="btn btn-outline-secondary mr-2"><i class="fas fa-arrow-left mr-1"></i>Back to Orders</a>
                    <button class="btn btn-hero" onclick="window.print()"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <!-- Printable Invoice -->
            <div class="card border-0 shadow-sm invoice-card" id="invoice-print">
                <div class="card-body p-4 p-md-5">
                    <!-- Header -->
                    <div class="text-center mb-4 invoice-header">
                        <h3 class="font-weight-bold mb-1" style="color: #3E2723;"><i class="fas fa-coffee mr-2" style="color: #C8A96A;"></i>Coffee Shop Cambodia</h3>
                        <div class="text-muted small">Komboul, Phnom Penh, Cambodia</div>
                        <div class="text-muted small">+855 963072500 | bromenghor130318@gmail.com</div>
                    </div>

                    <hr>

                    <!-- Invoice meta -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>Invoice No:</strong> {{ $order->transaction_no ?? '#' . $order->id }}<br>
                            <strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}<br>
                            <strong>Payment Method:</strong> <span class="text-capitalize">{{ $order->payment_method }}</span>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <div class="mb-2">
                                @php
                                    $badgeColor = 'info';
                                    $statusLabel = ucfirst(str_replace('_', ' ', $order->status));
                                    if ($order->status == 'completed') { $badgeColor = 'success'; $statusLabel = 'Completed'; }
                                    elseif ($order->status == 'preparing') { $badgeColor = 'primary'; $statusLabel = 'Preparing'; }
                                    elseif ($order->status == 'cancelled') { $badgeColor = 'danger'; $statusLabel = 'Cancelled'; }
                                    elseif ($order->status == 'waiting_payment') { $badgeColor = 'warning'; $statusLabel = 'Waiting Payment'; }
                                @endphp
                                <span class="badge badge-{{ $badgeColor }} p-2">{{ $statusLabel }}</span>
                                <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }} p-2 ml-1">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                            @if ($order->queue_number)
                                <div class="mt-2">
                                    <span class="text-muted">Queue / Waiting Number:</span>
                                    <h4 class="d-inline font-weight-bold" style="color:#C8A96A;">{{ $order->queue_number }}</h4>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Customer info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>Billed To:</strong><br>
                            {{ $order->customer_name }}<br>
                            {{ $order->phone }}<br>
                            @if ($order->email){{ $order->email }}<br>@endif
                            {{ $order->address }}
                        </div>
                        <div class="col-md-6 text-md-right">
                            @if ($order->receiver)
                                <strong>Received By:</strong> {{ $order->receiver->full_name }}
                            @endif
                        </div>
                    </div>

                    <!-- Items -->
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Unit Price</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product->name ?? 'Product' }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-right">{{ number_format($item->unit_price, 0) }}៛</td>
                                    <td class="text-right">{{ number_format($item->total_price, 0) }}៛</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Totals -->
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Subtotal:</span>
                                <strong>{{ number_format($order->subtotal, 0) }}៛</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Shipping:</span>
                                <strong>{{ number_format($order->shipping_fee, 0) }}៛</strong>
                            </div>
                            @if ($order->discount > 0)
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Discount:</span>
                                <strong>-{{ number_format($order->discount, 0) }}៛</strong>
                            </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Total:</span>
                                <h4 class="mb-0 font-weight-bold text-success">{{ number_format($order->total, 0) }}៛</h4>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <span class="text-muted">(~USD ${{ number_format($order->total / 4050, 2) }})</span>
                            </div>
                        </div>
                    </div>

                    @if ($order->note)
                        <div class="mt-4">
                            <strong>Note:</strong> {{ $order->note }}
                        </div>
                    @endif

                    <hr>
                    <div class="text-center text-muted">
                        Thank you for your order! Please wait for your Queue Number to be called.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .invoice-page {
            background: #f7f4ef;
        }
        .invoice-card {
            border-radius: 18px;
            border: 1px solid #eadfce !important;
        }
        .invoice-header {
            border-bottom: 2px dashed #d8c3a5;
            padding-bottom: 12px;
        }
        #invoice-print table thead th {
            background: #f4eee4;
            color: #3E2723;
            border-color: #e8dcc8;
        }
        #invoice-print table td,
        #invoice-print table th {
            border-color: #ecdfca;
        }

        @media print {
            .customer-nav, .customer-footer, .main-nav, .no-print {
                display: none !important;
            }
            .btn, .section-title {
                display: none !important;
            }
            .invoice-page {
                background: #fff !important;
                padding: 0 !important;
            }
            #invoice-print {
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            body {
                background: #fff !important;
            }
            @page {
                margin: 12mm;
            }
        }
    </style>
@endsection
