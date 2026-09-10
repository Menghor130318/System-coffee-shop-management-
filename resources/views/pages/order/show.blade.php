@extends('layouts.app')

@section('title', 'Order Details')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Order #{{ $order->transaction_no ?? $order->id }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('order.index') }}">Orders</a></div>
                    <div class="breadcrumb-item">Details</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Customer Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Name:</strong> {{ $order->customer_name }}<br>
                                        <strong>Phone:</strong> {{ $order->phone }}<br>
                                        <strong>Email:</strong> {{ $order->email ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Address:</strong> {{ $order->address }}<br>
                                        <strong>Note:</strong> {{ $order->note ?? 'N/A' }}<br>
                                        <strong>Ordered On:</strong> {{ $order->created_at->format('Y-m-d H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
