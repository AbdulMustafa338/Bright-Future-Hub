@extends('layouts.dashboard')

@section('title', 'Edit Opportunity')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Edit Opportunity</h2>
            <p class="text-muted">Update your opportunity details</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="glass-card p-4">
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('organization.opportunities.update', $opportunity->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Opportunity Title *</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title"
                            value="{{ old('title', $opportunity->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label fw-bold">Type *</label>
                        <select class="form-select form-select-lg" id="type" name="type" required>
                            <option value="">Select type...</option>
                            <option value="internship" {{ old('type', $opportunity->type) == 'internship' ? 'selected' : '' }}>Internship</option>
                            <option value="scholarship" {{ old('type', $opportunity->type) == 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                            <option value="admission" {{ old('type', $opportunity->type) == 'admission' ? 'selected' : '' }}>
                                Admission</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="5"
                            required>{{ old('description', $opportunity->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="eligibility" class="form-label fw-bold">Eligibility Criteria</label>
                        <textarea class="form-control" id="eligibility" name="eligibility"
                            rows="3">{{ old('eligibility', $opportunity->eligibility) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="deadline" class="form-label fw-bold">Application Deadline *</label>
                            <input type="date" class="form-control form-control-lg" id="deadline" name="deadline"
                                value="{{ old('deadline', $opportunity->deadline->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label fw-bold">Location</label>
                            <input type="text" class="form-control form-control-lg" id="location" name="location"
                                value="{{ old('location', $opportunity->location) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fees" class="form-label fw-bold">Fees/Stipend</label>
                            <input type="text" class="form-control form-control-lg" id="fees" name="fees"
                                value="{{ old('fees', $opportunity->fees) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="application_link" class="form-label fw-bold">Application Link</label>
                            <input type="url" class="form-control form-control-lg" id="application_link"
                                name="application_link"
                                value="{{ old('application_link', $opportunity->application_link) }}">
                        </div>
                    </div>

                    <div class="alert alert-warning mt-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> Editing this opportunity will reset its status to "Pending" and require admin
                        re-approval.
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Opportunity
                        </button>
                        <a href="{{ route('organization.opportunities.index') }}" class="btn btn-outline-secondary btn-lg">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-3">Current Status</h5>
                <div class="mb-3">
                    @if($opportunity->status === 'pending')
                        <span class="badge bg-warning fs-6">Pending Review</span>
                    @elseif($opportunity->status === 'approved')
                        <span class="badge bg-success fs-6">Approved</span>
                    @else
                        <span class="badge bg-danger fs-6">Rejected</span>
                    @endif
                </div>

                @if($opportunity->status === 'rejected' && $opportunity->rejectionMessage)
                    <div class="alert alert-danger">
                        <strong>Rejection Reason:</strong>
                        <p class="mb-0 mt-2">{{ $opportunity->rejectionMessage->reason }}</p>
                    </div>
                @endif

                <small class="text-muted">
                    Created: {{ $opportunity->created_at->format('M d, Y') }}<br>
                    Last Updated: {{ $opportunity->updated_at->format('M d, Y') }}
                </small>
            </div>
        </div>
    </div>
@endsection