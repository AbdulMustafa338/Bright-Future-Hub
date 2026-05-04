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

                <form method="POST" action="{{ route('organization.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="d-flex align-items-center mb-3">
                                @if($organization && $organization->logo)
                                    <div class="me-4 text-center">
                                        <p class="small fw-bold text-muted mb-1">Current Logo</p>
                                        <img src="{{ asset('storage/' . $organization->logo) }}" alt="Logo" class="rounded-3 border shadow-sm" style="width: 100px; height: 100px; object-fit: contain; background: white;">
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <label for="logo" class="form-label fw-bold">Update Logo</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                        id="logo" name="logo" accept="image/*">
                                    <small class="text-muted">Max size: 2MB (JPG, PNG). Leave empty to keep current logo.</small>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
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

                        <div class="col-md-6 mb-4">
                            <label for="registration_id" class="form-label fw-bold">Registration ID / Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('registration_id') is-invalid @enderror" 
                                id="registration_id" name="registration_id" 
                                value="{{ old('registration_id', $organization->registration_id ?? '') }}" required>
                            @error('registration_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="location" class="form-label fw-bold">Location / Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                id="location" name="location" 
                                value="{{ old('location', $organization->location ?? '') }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="google_map_link" class="form-label fw-bold">Google Map Link</label>
                            <input type="url" class="form-control @error('google_map_link') is-invalid @enderror" 
                                id="google_map_link" name="google_map_link" 
                                value="{{ old('google_map_link', $organization->google_map_link ?? '') }}">
                            @error('google_map_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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