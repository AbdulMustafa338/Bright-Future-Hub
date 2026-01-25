@extends('layouts.dashboard')

@section('title', 'Create Opportunity')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Post New Opportunity</h2>
            <p class="text-muted">Share opportunities with students</p>
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

                <form method="POST" action="{{ route('organization.opportunities.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Opportunity Title *</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title"
                            value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label fw-bold">Type *</label>
                        <select class="form-select form-select-lg" id="type" name="type" required>
                            <option value="">Select type...</option>
                            <option value="internship" {{ old('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                            <option value="scholarship" {{ old('type') == 'scholarship' ? 'selected' : '' }}>Scholarship
                            </option>
                            <option value="admission" {{ old('type') == 'admission' ? 'selected' : '' }}>Admission</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="5"
                            required>{{ old('description') }}</textarea>
                        <small class="text-muted">Provide detailed information about the opportunity</small>
                    </div>

                    <div class="mb-3">
                        <label for="eligibility" class="form-label fw-bold">Eligibility Criteria</label>
                        <textarea class="form-control" id="eligibility" name="eligibility"
                            rows="3">{{ old('eligibility') }}</textarea>
                        <small class="text-muted">Who can apply? (e.g., "Undergraduate students in Computer
                            Science")</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="deadline" class="form-label fw-bold">Application Deadline *</label>
                            <input type="date" class="form-control form-control-lg" id="deadline" name="deadline"
                                value="{{ old('deadline') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label fw-bold">Location</label>
                            <input type="text" class="form-control form-control-lg" id="location" name="location"
                                value="{{ old('location') }}" placeholder="e.g., Remote, New York, USA">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fees" class="form-label fw-bold">Fees/Stipend</label>
                            <input type="text" class="form-control form-control-lg" id="fees" name="fees"
                                value="{{ old('fees') }}" placeholder="e.g., $5000, Free, Paid">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="application_link" class="form-label fw-bold">Application Link</label>
                            <input type="url" class="form-control form-control-lg" id="application_link"
                                name="application_link" value="{{ old('application_link') }}"
                                placeholder="https://example.com/apply">
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> Your opportunity will be reviewed by an admin before being published.
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Submit for Review
                        </button>
                        <a href="{{ route('organization.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-3">Tips for Success</h5>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Be Clear:</strong> Write a descriptive title
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Be Detailed:</strong> Include all relevant information
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Be Specific:</strong> Define eligibility criteria clearly
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Be Timely:</strong> Set realistic deadlines
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection