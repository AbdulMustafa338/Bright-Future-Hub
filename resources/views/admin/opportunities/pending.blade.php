@extends('layouts.dashboard')

@section('title', 'Pending Approvals')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Pending Opportunity Approvals</h2>
            <p class="text-muted">Review and approve opportunities submitted by organizations</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                @if($opportunities->count() > 0)
                    @foreach($opportunities as $opp)
                        <div class="border-bottom pb-4 mb-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="fw-bold mb-2">{{ $opp->title }}</h5>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-building me-2"></i>{{ $opp->organization->organization_name }}
                                    </p>
                                    <div class="mb-3">
                                        <span class="badge bg-secondary me-2">{{ ucfirst($opp->type) }}</span>
                                        @if($opp->location)
                                            <span class="badge bg-light text-dark me-2">
                                                <i class="fas fa-map-marker-alt me-1"></i>{{ $opp->location }}
                                            </span>
                                        @endif
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-calendar me-1"></i>Deadline: {{ $opp->deadline->format('M d, Y') }}
                                        </span>
                                    </div>

                                    <p class="text-secondary mb-2">{{ Str::limit($opp->description, 200) }}</p>

                                    @if($opp->eligibility)
                                        <p class="text-muted small mb-2">
                                            <strong>Eligibility:</strong> {{ Str::limit($opp->eligibility, 150) }}
                                        </p>
                                    @endif

                                    @if($opp->fees)
                                        <p class="text-muted small mb-2">
                                            <strong>Fees/Stipend:</strong> {{ $opp->fees }}
                                        </p>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <div class="d-flex flex-column gap-2">
                                        <a href="{{ route('opportunities.show', $opp->id) }}" class="btn btn-outline-primary btn-sm"
                                            target="_blank">
                                            <i class="fas fa-eye me-1"></i>View Full Details
                                        </a>

                                        <form method="POST" action="{{ route('admin.opportunities.approve', $opp->id) }}"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100"
                                                onclick="return confirm('Are you sure you want to approve this opportunity?')">
                                                <i class="fas fa-check me-1"></i>Approve
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $opp->id }}">
                                            <i class="fas fa-times me-1"></i>Reject
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal{{ $opp->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Reject Opportunity</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.opportunities.reject', $opp->id) }}">
                                        @csrf
                                        <div class="modal-body">
                                            <p class="text-muted">Please provide a reason for rejecting this opportunity:</p>
                                            <textarea class="form-control" name="reason" rows="4" required
                                                placeholder="e.g., Incomplete information, Does not meet quality standards..."></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Reject Opportunity</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    @if($opportunities->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $opportunities->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No pending approvals</h5>
                        <p class="text-muted">All opportunities have been reviewed</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection