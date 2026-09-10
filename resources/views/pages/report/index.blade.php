@extends('layouts.app')

@section('title', 'Sales Reports')

@section('main')
    <div class="main-content report-page">
        <section class="section">
            <div class="section-header no-print">
                <h1>Sales Reports</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Reports</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row no-print">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('reports.index') }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>From Date</label>
                                            <input type="date" name="from" class="form-control" value="{{ $from }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>To Date</label>
                                            <input type="date" name="to" class="form-control" value="{{ $to }}">
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <button class="btn btn-primary mr-2" type="submit"><i class="fas fa-filter"></i> Filter</button>
                                            <a href="{{ route('reports.index') }}" class="btn btn-light border mr-2">Reset</a>
                                            <button type="button" onclick="window.print()" class="btn btn-success"><i class="fas fa-print"></i> Print Report</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="report-print-area">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="text-center mb-3 report-header">
                                <h3 class="mb-1" style="color: #3E2723;">Coffee Shop Cambodia - Sales Report</h3>
                                <div class="text-muted">Generated: {{ now()->format('Y-m-d H:i') }}</div>
                                @if($from || $to)
                                    <div class="text-muted">
                                        Period:
                                        {{ $from ? \Carbon\Carbon::parse($from)->format('Y-m-d') : 'Start' }}
                                        -
                                        {{ $to ? \Carbon\Carbon::parse($to)->format('Y-m-d') : 'Now' }}
                                    </div>
                                @endif
                            </div>

                            @php
                                // Helper Functions សម្រាប់បំប្លែងតម្លៃដុល្លារ និងរៀលស្វ័យប្រវត្តិ
                                $toUsd = fn($val) => $val > 500 ? $val / 4100 : $val;
                                $toKhr = fn($val) => $val > 500 ? $val : $val * 4100;

                                $revUsd = $toUsd($totalRevenue ?? 0);
                                $revKhr = $toKhr($totalRevenue ?? 0);

                                $unpaidUsd = $toUsd($totalUnpaid ?? 0);
                                $unpaidKhr = $toKhr($totalUnpaid ?? 0);

                                $grandUsd = $revUsd + $unpaidUsd;
                                $grandKhr = $revKhr + $unpaidKhr;
                            @endphp

                            <div class="row">
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="p-3 stat-box">
                                        <div class="text-muted">Total Orders</div>
                                        <h4 class="mb-0">{{ $totalOrders }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="p-3 stat-box">
                                        <div class="text-muted">Paid Orders</div>
                                        <h4 class="mb-0 text-success">{{ $paidOrders }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="p-3 stat-box">
                                        <div class="text-muted">Unpaid Orders</div>
                                        <h4 class="mb-0 text-danger">{{ $unpaidOrders }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="p-3 stat-box">
                                        <div class="text-muted">Paid Revenue</div>
                                        <h4 class="mb-0 text-primary">${{ number_format($revUsd, 2) }}</h4>
                                        <small class="text-muted">(≈ {{ number_format($revKhr) }}៛)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 stat-box">
                                        <div class="text-muted">Unpaid Amount</div>
                                        <h5 class="mb-0 text-warning">${{ number_format($unpaidUsd, 2) }}</h5>
                                        <small class="text-muted">(≈ {{ number_format($unpaidKhr) }}៛)</small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 stat-box">
                                        <div class="text-muted">Grand Revenue (Paid + Unpaid)</div>
                                        <h5 class="mb-0">${{ number_format($grandUsd, 2) }}</h5>
                                        <small class="text-muted">(≈ {{ number_format($grandKhr) }}៛)</small>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4">Paid Revenue by Payment Method</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Payment Method</th>
                                            <th class="text-center">Orders</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($byMethod as $row)
                                            @php
                                                $mUsd = $toUsd($row->total ?? 0);
                                                $mKhr = $toKhr($row->total ?? 0);
                                            @endphp
                                            <tr>
                                                <td>{{ ucfirst($row->payment_method) }}</td>
                                                <td class="text-center">{{ $row->count }}</td>
                                                <td class="text-right font-weight-bold">
                                                    ${{ number_format($mUsd, 2) }}
                                                    <small class="text-muted font-weight-normal">(≈ {{ number_format($mKhr) }}៛)</small>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No paid data found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="mt-4">Recent Orders</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Customer</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                            <th class="text-right">Total</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentOrders as $order)
                                            @php
                                                $oTotal = $order->total ?? 0;
                                                $oUsd = $toUsd($oTotal);
                                                $oKhr = $toKhr($oTotal);
                                            @endphp
                                            <tr>
                                                <td>{{ $order->transaction_no ?? 'ORD-' . $order->id }}</td>
                                                <td>{{ $order->customer_name }}</td>
                                                <td>{{ ucfirst($order->payment_status) }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</td>
                                                <td class="text-right font-weight-bold">
                                                    ${{ number_format($oUsd, 2) }}
                                                    <small class="text-muted font-weight-normal">(≈ {{ number_format($oKhr) }}៛)</small>
                                                </td>
                                                <td>{{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i') : 'N/A' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No orders found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .report-page {
            background: #f7f4ef;
        }
        .report-header {
            border-bottom: 2px dashed #d8c3a5;
            padding-bottom: 10px;
        }
        .stat-box {
            background: #fffaf2;
            border: 1px solid #eadfce;
            border-radius: 10px;
        }

        @media print {
            .no-print,
            .main-sidebar,
            .main-navbar,
            .main-footer,
            .section-header {
                display: none !important;
            }
            .main-content {
                padding: 0 !important;
                margin: 0 !important;
            }
            #report-print-area .card {
                border: none !important;
                box-shadow: none !important;
            }
            body {
                background: #fff !important;
            }
            @page {
                margin: 10mm;
            }
        }
    </style>
@endsection