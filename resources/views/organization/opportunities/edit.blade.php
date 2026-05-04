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

                <form method="POST" action="{{ route('organization.opportunities.update', $opportunity->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4 text-center">
                        <div class="position-relative d-inline-block w-100" style="max-width: 500px;">
                            <label for="image" class="form-label fw-bold d-block mb-3">Opportunity Cover Image</label>
                            <div id="image-preview" class="rounded-4 border-2 border-dashed d-flex align-items-center justify-content-center bg-light transition-all shadow-sm" 
                                 style="width: 100%; aspect-ratio: 16/9; cursor: pointer; overflow: hidden; margin: 0 auto; border: 2px dashed #cbd5e0 !important;">
                                @if($opportunity->image)
                                    <img src="{{ asset('storage/' . $opportunity->image) }}" style="width: 100%; height: 100%; object-fit: contain; pointer-events: none; background: #f8f9fa;">
                                @else
                                    <div class="text-center p-4" style="pointer-events: none;">
                                        <div class="bg-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                            <i class="fas fa-cloud-upload-alt text-primary fs-3"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">Click to upload banner</h6>
                                        <p class="text-muted small mb-0">PNG, JPG or WEBP (Max 5MB)</p>
                                    </div>
                                @endif
                            </div>
                            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)"
                                   style="opacity: 0; position: absolute; top: 0; left: 0; width: 1px; height: 1px;">
                        </div>
                    </div>

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