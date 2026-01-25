@extends('layouts.main')

@section('title', 'Login - Bright Future Hub')

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="card glass-card border-0 p-4 animate__animated animate__fadeIn">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Welcome Back</h3>
                    <p class="text-muted">Login to access your opportunities</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small text-secondary">Email Address</label>
                        <input type="email" class="form-control form-control-lg rounded-3 bg-light border-0" id="email"
                            name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="password" class="form-label fw-bold small text-secondary">Password</label>
                            <a href="#" class="small text-decoration-none">Forgot?</a>
                        </div>
                        <input type="password" class="form-control form-control-lg rounded-3 bg-light border-0"
                            id="password" name="password" required>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                            Sign In
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-muted mb-0">Don't have an account? <a href="{{ route('register') }}"
                                class="fw-bold text-primary text-decoration-none">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection