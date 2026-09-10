@extends('layouts.app')

@section('title', 'Edit User')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></div>
                    <div class="breadcrumb-item">Edit User</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">User Management</h2>
                <p class="section-lead">Update user information and role assignments.</p>

                <div class="card shadow-sm border-0">
                    <form action="{{ route('user.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-header">
                            <h4>User Details</h4>
                        </div>
                        
                        <div class="card-body">
                            <!-- Name Field -->
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text"
                                    id="name"
                                    name="name" 
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->full_name ?? $user->name) }}" 
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email"
                                    id="email"
                                    name="email" 
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" 
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <label for="password">Password <small class="text-muted">(Leave blank if you don't want to change)</small></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <input type="password"
                                        id="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter new password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Role Field -->
                            <div class="form-group">
                                <label class="form-label">Role</label>
                                @php
                                    $currentRole = is_object($user->role) ? $user->role->name : $user->role;
                                    $selectedRole = old('role', $currentRole);
                                @endphp
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="role" value="Admin" class="selectgroup-input"
                                            {{ trim($selectedRole) == 'Admin' ? 'checked' : '' }}>
                                        <span class="selectgroup-button">Admin</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="role" value="Customer" class="selectgroup-input"
                                            {{ trim($selectedRole) == 'Customer' ? 'checked' : '' }}>
                                        <span class="selectgroup-button">Customer</span>
                                    </label>
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer text-right bg-whitesmoke">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush