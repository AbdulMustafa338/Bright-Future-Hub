@extends('layouts.dashboard')

@section('title', 'Edit Student Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold mb-1">Edit Your Profile</h3>
                        <p class="text-muted mb-0">Keep your information up to date</p>
                    </div>
                    <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('student.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Full Name</label>
                        <input type="text" class="form-control form-control-lg" id="name" value="{{ $user->name }}"
                            disabled>
                        <small class="text-muted">Contact admin to change your name</small>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Email Address</label>
                        <input type="email" class="form-control form-control-lg" id="email" value="{{ $user->email }}"
                            disabled>
                        <small class="text-muted">Contact admin to change your email</small>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label for="field_of_study" class="form-label fw-bold">Field of Study</label>
                        <input type="text" class="form-control @error('field_of_study') is-invalid @enderror"
                            id="field_of_study" name="field_of_study"
                            value="{{ old('field_of_study', $user->field_of_study ?? '') }}"
                            placeholder="e.g., Computer Science, Business Administration">
                        @error('field_of_study')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="education_level" class="form-label fw-bold">Education Level</label>
                        <select class="form-select @error('education_level') is-invalid @enderror" id="education_level"
                            name="education_level">
                            <option value="">Select your education level</option>
                            <option value="High School" {{ old('education_level', $user->education_level ?? '') == 'High School' ? 'selected' : '' }}>High School</option>
                            <option value="Undergraduate" {{ old('education_level', $user->education_level ?? '') == 'Undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                            <option value="Graduate" {{ old('education_level', $user->education_level ?? '') == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                            <option value="Postgraduate" {{ old('education_level', $user->education_level ?? '') == 'Postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                            <option value="PhD" {{ old('education_level', $user->education_level ?? '') == 'PhD' ? 'selected' : '' }}>PhD</option>
                        </select>
                        @error('education_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="interests" class="form-label fw-bold">Interests & Skills</label>
                        <textarea class="form-control @error('interests') is-invalid @enderror" id="interests"
                            name="interests" rows="4"
                            placeholder="Tell us about your interests, skills, and what you're looking for...">{{ old('interests', $user->interests ?? '') }}</textarea>
                        @error('interests')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">This helps us match you with relevant opportunities</small>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                        <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection