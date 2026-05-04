@extends('layouts.dashboard')

@section('title', 'Review Organization')

@section('content')
<div class="row items-center mb-4">
    <div class="col-md-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.organizations.pending') }}">Requests</a></li>
                <li class="breadcrumb-item active">{{ $organization->organization_name }}</li>
            </ol>
        </nav>
        <h2 class="fw-bold mb-0">Verification Review</h2>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <span class="badge {{ $organization->status === 'approved' ? 'bg-success' : ($organization->status === 'rejected' ? 'bg-danger' : 'bg-warning') }} px-3 py-2 rounded-pill shadow-sm">
            Status: {{ ucfirst($organization->status) }}
        </span>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Organization Profile Details -->
        <div class="glass-card p-4 mb-4">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                @if($organization->logo)
                    <img src="{{ asset('storage/' . $organization->logo) }}" alt="Logo" class="rounded-circle me-3 border shadow-sm" style="width: 80px; height: 80px; object-fit: contain; background: white;">
                @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 border" style="width: 80px; height: 80px;">
                        <i class="fas fa-university text-muted fs-2"></i>
                    </div>
                @endif
                <div>
                    <h3 class="fw-bold mb-1">{{ $organization->organization_name }}</h3>
                    <p class="text-muted mb-0"><i class="fas fa-envelope me-2"></i>{{ $organization->user->email }}</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1">Registration ID</label>
                    <div class="p-3 bg-light rounded-3 fw-bold">
                        <i class="fas fa-id-card me-2 text-primary"></i><code>{{ $organization->registration_id }}</code>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1">Location</label>
                    <div class="p-3 bg-light rounded-3 fw-bold">
                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $organization->location }}
                    </div>
                </div>
                <div class="col-12">
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1">Google Maps Link</label>
                    <div class="p-3 bg-light rounded-3">
                        @if($organization->google_map_link)
                            <a href="{{ $organization->google_map_link }}" target="_blank" class="text-primary fw-bold text-decoration-none">
                                <i class="fas fa-external-link-alt me-2"></i>View on Google Maps
                            </a>
                        @else
                            <span class="text-muted">Not provided</span>
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1">Account Holder Name</label>
                    <div class="p-3 bg-light rounded-3">
                        <i class="fas fa-user-circle me-2 text-info"></i>{{ $organization->user->name }}
                    </div>
                </div>
                @if($organization->rejection_reason)
                <div class="col-12">
                    <div class="alert alert-danger mb-0">
                        <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Rejection Reason:</h6>
                        <p class="mb-0">{{ $organization->rejection_reason }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($organization->status === 'pending')
        <!-- Action Buttons (Sticky Bottom) -->
        <div class="glass-card p-4 d-flex gap-3 justify-content-center border-top border-primary border-4 shadow">
            <form action="{{ route('admin.organizations.approve', $organization->id) }}" method="POST" class="flex-grow-1">
                @csrf
                <button type="submit" class="btn btn-success w-100 py-3 fw-bold shadow-sm" onclick="return confirm('Verify this organization? This will allow them to post directly.')">
                    <i class="fas fa-check-circle me-2"></i> Approve & Verify
                </button>
            </form>
            <button type="button" class="btn btn-outline-danger px-5 py-3 fw-bold" data-bs-toggle="modal" data-bs-target="#rejectModal">
                <i class="fas fa-times-circle me-2"></i> Reject
            </button>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="glass-card p-4 mb-4 text-center">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Guidelines</h5>
            <ul class="text-start small text-muted ps-3">
                <li class="mb-2">Check Registration ID against official records.</li>
                <li class="mb-2">Verify location exists on maps.</li>
                <li class="mb-2">Ensure logo is professional and belongs to the entity.</li>
            </ul>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.organizations.reject', $organization->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="rejectModalLabel">Reject Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reason" class="form-label fw-bold">Reason for Rejection</label>
                        <textarea class="form-control" id="reason" name="reason" rows="4" required placeholder="Explain why the registration was not approved..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection