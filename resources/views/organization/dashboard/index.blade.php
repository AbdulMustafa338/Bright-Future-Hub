@extends('layouts.dashboard')

@section('title', 'Organization Dashboard')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-auto">
            @if($organization->logo)
                <img src="{{ asset('storage/' . $organization->logo) }}" alt="Logo" class="rounded-circle border shadow-sm" style="width: 80px; height: 80px; object-fit: contain; background: white;">
            @else
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border" style="width: 80px; height: 80px;">
                    <i class="fas fa-university text-muted fs-2"></i>
                </div>
            @endif
        </div>
        <div class="col">
            <h2 class="fw-bold mb-0">Organization Dashboard</h2>
            <p class="text-muted mb-0">{{ $organization->organization_name }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Verification Status Banner -->
    @if($organization->status === 'pending')
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center p-4 mb-4">
            <i class="fas fa-clock fa-2x me-4 text-warning"></i>
            <div>
                <h5 class="fw-bold mb-1">Account Verification Pending</h5>
                <p class="mb-0">Your organization is currently being reviewed by the admin. You will be able to post opportunities once verified.</p>
            </div>
        </div>
    @elseif($organization->status === 'approved')
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center p-4 mb-4">
            <i class="fas fa-check-circle fa-2x me-4 text-success"></i>
            <div>
                <h5 class="fw-bold mb-1">Account Verified</h5>
                <p class="mb-0">Your organization is verified! Your posts will now be published instantly.</p>
            </div>
        </div>
    @elseif($organization->status === 'rejected')
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center p-4 mb-4">
            <i class="fas fa-times-circle fa-2x me-4 text-danger"></i>
            <div>
                <h5 class="fw-bold mb-1">Application Rejected</h5>
                <p class="mb-1">Unfortunately, your verification request was not approved.</p>
                <div class="mt-2 p-2 bg-white bg-opacity-50 rounded">
                    <strong>Reason:</strong> {{ $organization->rejection_reason ?? 'No specific reason provided.' }}
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Opportunities</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_opportunities'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-briefcase text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <a href="{{ route('organization.applications.all') }}" class="text-decoration-none">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Applications</p>
                            <h3 class="fw-bold mb-0">{{ $stats['total_applications'] }}</h3>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                            <i class="fas fa-users text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-3">Quick Actions</h5>
                <div class="d-flex gap-3">
                    @if($organization->status === 'approved')
                        <a href="{{ route('organization.opportunities.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Post New Opportunity
                        </a>
                    @else
                        <button class="btn btn-primary" disabled data-bs-toggle="tooltip" title="Account verification required">
                            <i class="fas fa-plus me-2"></i>Post New Opportunity
                        </button>
                    @endif
                    <a href="{{ route('organization.opportunities.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i>View All Opportunities
                    </a>
                    <a href="{{ route('organization.profile.edit') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Opportunities -->
    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Recent Opportunities</h5>

                @if($recentOpportunities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Deadline</th>
                                    <th>Applications</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOpportunities as $opp)
                                    <tr>
                                        <td class="fw-bold">{{ $opp->title }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($opp->type) }}</span>
                                        </td>
                                        <td>
                                            @if($opp->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($opp->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $opp->deadline->format('M d, Y') }}</td>
                                        <td>{{ $opp->applications->count() }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('opportunities.show', $opp->id) }}"
                                                    class="btn btn-outline-primary" title="View Public Post"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('organization.applications.index', $opp->id) }}"
                                                    class="btn btn-outline-info" title="View Applications"><i class="fas fa-users"></i></a>
                                                <a href="{{ route('organization.opportunities.edit', $opp->id) }}"
                                                    class="btn btn-outline-secondary" title="Edit Post"><i class="fas fa-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-briefcase text-muted mb-3" style="font-size: 3rem;"></i>
                        <p class="text-muted">No opportunities posted yet</p>
                        <a href="{{ route('organization.opportunities.create') }}" class="btn btn-primary mt-2">
                            Post Your First Opportunity
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection