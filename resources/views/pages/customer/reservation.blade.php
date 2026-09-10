@extends('layouts.customer')

@section('title', 'Book a Table')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="section-title">Book a Table</h2>
                    <p class="text-muted mb-4">Reserve your table at our coffee shop and enjoy the best coffee experience in Cambodia.</p>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div style="width: 50px; height: 50px; background: #6F4E37; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; margin-right: 15px;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <strong>Opening Hours</strong><br>
                                <span class="text-muted">Everyday: 7:00 AM - 10:00 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 font-weight-bold"><i class="fas fa-calendar-check mr-2" style="color: #6F4E37;"></i>Reservation Form</h5>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('reservation.public.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Full Name *</label>
                                            <input type="text" name="customer_name" class="form-control" value="{{ auth()->user()->full_name ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone *</label>
                                            <input type="text" name="customer_phone" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date *</label>
                                            <input type="date" name="reservation_date" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Time *</label>
                                            <input type="time" name="reservation_time" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Table Number</label>
                                            <input type="text" name="table_number" class="form-control" placeholder="e.g. 5">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Special Requests</label>
                                            <textarea name="notes" class="form-control" rows="3" placeholder="Any special requests?"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-hero btn-block"><i class="fas fa-check-circle mr-1"></i>Submit Reservation</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
