@extends('layouts.app')

@section('title', 'Login - Salary Application')

@section('content')

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow rounded-4">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">BSKP Salary</h3>
                    <p class="text-muted">Login to your account</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autofocus
                               placeholder="your@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-decoration-none small text-primary">
                                Forgot Your Password?
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
        <div class="text-center mt-4 text-white small">
            &copy; {{ now()->year }} PT. Bridgestone Kalimantan Plantation. All rights reserved.
        </div>
    </div>
</div>
@endsection
