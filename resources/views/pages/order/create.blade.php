@extends('layouts.app') {{-- Change to your layout name if different --}}

@section('content')
<div class="container py-4">
    <h2>Create New Order</h2>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Customer Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter customer name">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" required placeholder="012345678">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" required placeholder="Table 1 or Street Address">
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" class="form-select" required>
                <option value="cash">Cash</option>
                <option value="khqr">KHQR</option>
                <option value="card">Card</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Note (Optional)</label>
            <textarea name="note" class="form-control" rows="2"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Order</button>
    </form>
</div>
@endsection