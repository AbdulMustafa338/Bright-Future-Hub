@extends('layouts.dashboard')

@section('title', 'Create Organization Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card p-4 mb-4">
                <h3 class="fw-bold mb-3">Complete Your Organization Profile</h3>
                <p class="text-muted mb-4">Please provide your organization details to get started. Your profile will be
                    reviewed by our admin team.</p>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('organization.profile.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="organization_name" class="form-label fw-bold">Organization Name <span
                                class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control form-control-lg @error('organization_name') is-invalid @enderror"
                            id="organization_name" name="organization_name" value="{{ old('organization_name') }}" required
                            placeholder="e.g., Tech University">
                        @error('organization_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="5"
                            placeholder="Tell us about your organization...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Provide a brief description of your organization and its mission.</small>
                    </div>

                    <div class="mb-4">
                        <label for="contact_person" class="form-label fw-bold">Contact Person</label>
                        <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                            id="contact_person" name="contact_person" value="{{ old('contact_person') }}"
                            placeholder="e.g., John Doe">
                        @error('contact_person')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info rounded-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> Your profile will be submitted for admin review. You'll be able to post
                        opportunities once approved.
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-check me-2"></i>Create Profile
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