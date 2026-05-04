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

                <form method="POST" action="{{ route('organization.opportunities.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4 text-center">
                        <div class="position-relative d-inline-block w-100" style="max-width: 500px;">
                            <label for="image" class="form-label fw-bold d-block mb-3">Opportunity Cover Image</label>
                            <div id="image-preview" class="rounded-4 border-2 border-dashed d-flex align-items-center justify-content-center bg-light transition-all shadow-sm" 
                                 style="width: 100%; aspect-ratio: 16/9; cursor: pointer; overflow: hidden; margin: 0 auto; border: 2px dashed #cbd5e0 !important;">
                                <div class="text-center p-4" style="pointer-events: none;">
                                    <div class="bg-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-cloud-upload-alt text-primary fs-3"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">Click to upload banner</h6>
                                    <p class="text-muted small mb-0">PNG, JPG or WEBP (Max 5MB)</p>
                                    <p class="text-primary small fw-bold mt-2">16:9 Aspect Ratio Recommended</p>
                                </div>
                            </div>
                            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)"
                                   style="opacity: 0; position: absolute; top: 0; left: 0; width: 1px; height: 1px;">
                        </div>
                    </div>

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

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Post Opportunity
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
@push('scripts')
<script>
    document.getElementById('image-preview').addEventListener('click', function() {
        document.getElementById('image').click();
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                preview.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: contain; background: #f8f9fa;">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection