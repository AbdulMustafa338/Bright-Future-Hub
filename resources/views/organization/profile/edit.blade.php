@extends('layouts.dashboard')

@section('title', 'Edit Organization Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold mb-1">Edit Organization Profile</h3>
                        <p class="text-muted mb-0">Update your organization information</p>
                    </div>
                    <a href="{{ route('organization.dashboard') }}" class="btn btn-outline-secondary">
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

                @if($organization && $organization->status === 'pending')
                    <div class="alert alert-warning rounded-3">
                        <i class="fas fa-clock me-2"></i>
                        <strong>Pending Review:</strong> Your profile is currently under admin review.
                    </div>
                @elseif($organization && $organization->status === 'approved')
                    <div class="alert alert-success rounded-3">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Verified:</strong> Your organization profile has been approved.
                    </div>
                @endif

                <form method="POST" action="{{ route('organization.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="organization_name" class="form-label fw-bold">Organization Name <span
                                class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control form-control-lg @error('organization_name') is-invalid @enderror"
                            id="organization_name" name="organization_name"
                            value="{{ old('organization_name', $organization->organization_name ?? '') }}" required>
                        @error('organization_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="5"
                            placeholder="Tell us about your organization...">{{ old('description', $organization->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="contact_person" class="form-label fw-bold">Contact Person</label>
                        <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                            id="contact_person" name="contact_person"
                            value="{{ old('contact_person', $organization->contact_person ?? '') }}">
                        @error('contact_person')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                        <a href="{{ route('organization.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection