@extends('layouts.dashboard')

@section('title', 'Organization Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Organization Dashboard</h2>
            <p class="text-muted">{{ $organization->organization_name }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
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

        <div class="col-md-3">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Approved</p>
                        <h3 class="fw-bold mb-0 text-success">{{ $stats['approved_opportunities'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="fas fa-check text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Pending</p>
                        <h3 class="fw-bold mb-0 text-warning">{{ $stats['pending_opportunities'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-clock text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Applications</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_applications'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-info bg-opacity-10 p-3">
                        <i class="fas fa-users text-info fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-3">Quick Actions</h5>
                <div class="d-flex gap-3">
                    <a href="{{ route('organization.opportunities.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Post New Opportunity
                    </a>
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
                                            <a href="{{ route('opportunities.show', $opp->id) }}"
                                                class="btn btn-sm btn-outline-primary">View</a>
                                            <a href="{{ route('organization.opportunities.edit', $opp->id) }}"
                                                class="btn btn-sm btn-outline-secondary">Edit</a>
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