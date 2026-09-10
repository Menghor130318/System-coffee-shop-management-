@extends('layouts.customer')

@section('title', 'My Profile')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">My Profile</h2>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 font-weight-bold"><i class="fas fa-user-circle mr-2" style="color: #6F4E37;"></i>Account Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Avatar Upload -->
                                <div class="text-center mb-4">
                                    <div class="d-inline-block position-relative">
                                        @if ($user->avatar && file_exists(public_path($user->avatar)))
                                            <img src="{{ asset($user->avatar) }}" alt="avatar" class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #C8A96A;">
                                        @else
                                            <img src="{{ asset('img/avatar/avatar-1.png') }}" alt="avatar" class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #C8A96A;">
                                        @endif
                                    </div>
                                    <div class="mt-3">
                                        <label for="avatar" class="btn btn-sm btn-outline-dark"><i class="fas fa-camera mr-1"></i>Change Photo</label>
                                        <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*" onchange="previewAvatar(event)">
                                    </div>
                                    <div class="text-muted small">JPG, PNG, GIF or SVG. Max 2MB.</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Full Name *</label>
                                            <input type="text" name="full_name" class="form-control" value="{{ $user->full_name ?? $user->name ?? '' }}" required>
                                            @error('full_name')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email *</label>
                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" placeholder="+855 12 345 678">
                                            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Role</label>
                                            <input type="text" class="form-control" value="{{ $user->role->name ?? 'Customer' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea name="address" class="form-control" rows="2" placeholder="Your address">{{ $user->address }}</textarea>
                                            @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h6 class="font-weight-bold"><i class="fas fa-lock mr-2" style="color: #6F4E37;"></i>Change Password</h6>
                                <button type="button" class="btn btn-link btn-sm p-0 mb-3 text-primary" data-toggle="collapse" data-target="#passwordSection">
                                    <i class="fas fa-chevron-down mr-1"></i>Show / Hide password fields
                                </button>
                                <div class="collapse {{ $errors->has('password') || $errors->has('current_password') ? 'show' : '' }}" id="passwordSection">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Current Password</label>
                                                <input type="password" name="current_password" class="form-control" placeholder="Enter current password">
                                                @error('current_password')<small class="text-danger">{{ $message }}</small>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="Min 8 characters">
                                                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Confirm New Password</label>
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-hero mt-2"><i class="fas fa-save mr-1"></i>Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function previewAvatar(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.querySelector('.rounded-circle.shadow');
                    if (img) {
                        img.src = e.target.result;
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
