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

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="role" class="form-label fw-bold small text-secondary">I am a...</label>
                        <select class="form-select form-select-lg rounded-3 bg-light border-0" id="role" name="role"
                            required onchange="toggleFormMode()">
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student (Looking for
                                opportunities)</option>
                            <option value="organization" {{ old('role') == 'organization' ? 'selected' : '' }}>Organization
                                (Posting opportunities)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label id="name_label" for="name" class="form-label fw-bold small text-secondary">Full Name</label>
                        <input type="text" class="form-control form-control-lg rounded-3 bg-light border-0" id="name"
                            name="name" value="{{ old('name') }}" required autofocus oninput="syncOrgName()">
                    </div>

                    <!-- Hidden organization name field to satisfy validation (Synced via JS) -->
                    <input type="hidden" id="org_name" name="org_name" value="{{ old('org_name') }}">

                    <div id="org_fields" style="display: none;">
                        <div class="mb-3">
                            <label for="registration_id" class="form-label fw-bold small text-secondary">Registration ID / Code</label>
                            <input type="text" class="form-control form-control-lg rounded-3 bg-light border-0" id="registration_id"
                                name="registration_id" value="{{ old('registration_id') }}" placeholder="e.g. REG-123456">
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label fw-bold small text-secondary">Location / Address</label>
                            <input type="text" class="form-control form-control-lg rounded-3 bg-light border-0" id="location"
                                name="location" value="{{ old('location') }}" placeholder="City, Country">
                        </div>

                        <div class="mb-3">
                            <label for="google_map_link" class="form-label fw-bold small text-secondary">Google Map Link (Optional)</label>
                            <input type="url" class="form-control form-control-lg rounded-3 bg-light border-0" id="google_map_link"
                                name="google_map_link" value="{{ old('google_map_link') }}" placeholder="https://goo.gl/maps/...">
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label fw-bold small text-secondary">Official Logo</label>
                            <input type="file" class="form-control form-control-lg rounded-3 bg-light border-0" id="logo"
                                name="logo" accept="image/*">
                            <small class="text-muted">Max size: 2MB (JPG, PNG)</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small text-secondary">Email Address</label>
                        <input type="email" class="form-control form-control-lg rounded-3 bg-light border-0" id="email"
                            name="email" value="{{ old('email') }}" required>
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
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm" onclick="syncOrgName()">
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
        function toggleFormMode() {
            const role = document.getElementById('role').value;
            const nameLabel = document.getElementById('name_label');
            const orgFields = document.getElementById('org_fields');
            const nameInput = document.getElementById('name');
            const regIdInput = document.getElementById('registration_id');
            const locationInput = document.getElementById('location');
            const logoInput = document.getElementById('logo');

            if (role === 'organization') {
                nameLabel.innerText = "University / Organization Name";
                nameInput.placeholder = "Full name of the institution";
                orgFields.style.display = 'block';
                regIdInput.required = true;
                locationInput.required = true;
                logoInput.required = true;
            } else {
                nameLabel.innerText = "Full Name";
                nameInput.placeholder = "Enter your full name";
                orgFields.style.display = 'none';
                regIdInput.required = false;
                locationInput.required = false;
                logoInput.required = false;
            }
            syncOrgName();
        }

        function syncOrgName() {
            const role = document.getElementById('role').value;
            const name = document.getElementById('name').value;
            if (role === 'organization') {
                document.getElementById('org_name').value = name;
            } else {
                document.getElementById('org_name').value = '';
            }
        }

        // Run on load in case of validation error return
        document.addEventListener('DOMContentLoaded', toggleFormMode);
    </script>
@endsection