@extends('layouts.main')

@section('title', 'Register - Bright Future Hub')

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh; padding-top: 20px;">
        <div class="col-md-6">
            <div class="card glass-card border-0 p-4 animate__animated animate__fadeInUp">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Create Account</h3>
                    <p class="text-muted">Join opportunities or post them.</p>
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

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold small text-secondary">Full Name</label>
                        <input type="text" class="form-control form-control-lg rounded-3 bg-light border-0" id="name"
                            name="name" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small text-secondary">Email Address</label>
                        <input type="email" class="form-control form-control-lg rounded-3 bg-light border-0" id="email"
                            name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-bold small text-secondary">I am a...</label>
                        <select class="form-select form-select-lg rounded-3 bg-light border-0" id="role" name="role"
                            required onchange="toggleOrgFields()">
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student (Looking for
                                opportunities)</option>
                            <option value="organization" {{ old('role') == 'organization' ? 'selected' : '' }}>Organization
                                (Posting opportunities)</option>
                        </select>
                    </div>

                    <!-- Organization Fields (Hidden by default) -->
                    <div id="org-fields" class="mb-3" style="display: none;">
                        <label for="org_name" class="form-label fw-bold small text-secondary">Organization Name</label>
                        <input type="text" class="form-control form-control-lg rounded-3 bg-light border-0" id="org_name"
                            name="org_name" value="{{ old('org_name') }}" placeholder="e.g. University of Tech">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold small text-secondary">Password</label>
                        <input type="password" class="form-control form-control-lg rounded-3 bg-light border-0"
                            id="password" name="password" required>
                    </div>

                    <div class="mb-5">
                        <label for="password_confirmation" class="form-label fw-bold small text-secondary">Confirm
                            Password</label>
                        <input type="password" class="form-control form-control-lg rounded-3 bg-light border-0"
                            id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                            Register
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-muted mb-0">Already have an account? <a href="{{ route('login') }}"
                                class="fw-bold text-primary text-decoration-none">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleOrgFields() {
            const role = document.getElementById('role').value;
            const orgFields = document.getElementById('org-fields');
            if (role === 'organization') {
                orgFields.style.display = 'block';
            } else {
                orgFields.style.display = 'none';
            }
        }
        // Run on load in case of validation error return
        document.addEventListener('DOMContentLoaded', toggleOrgFields);
    </script>
@endsection