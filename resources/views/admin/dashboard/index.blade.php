@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Admin Dashboard</h2>
            <p class="text-muted">Manage users, organizations, and opportunities</p>
        </div>
    </div>

    @if(session('last_login_diff'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-history me-2"></i>Welcome back! You last logged in
                    <strong>{{ session('last_login_diff') }}</strong> ago.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Users</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_users'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-users text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Pending Approvals</p>
                        <h3 class="fw-bold mb-0 text-warning">{{ $stats['pending_opportunities'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-clock text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Approved Opportunities</p>
                        <h3 class="fw-bold mb-0 text-success">{{ $stats['approved_opportunities'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="fas fa-check-circle text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-3">User Distribution</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Students</span>
                    <span class="fw-bold">{{ $stats['total_students'] }}</span>
                </div>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar"
                        style="width: {{ $stats['total_users'] > 0 ? ($stats['total_students'] / $stats['total_users'] * 100) : 0 }}%">
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Organizations</span>
                    <span class="fw-bold">{{ $stats['total_organizations'] }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-info" role="progressbar"
                        style="width: {{ $stats['total_users'] > 0 ? ($stats['total_organizations'] / $stats['total_users'] * 100) : 0 }}%">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-3">Total Applications</h5>
                <div class="text-center">
                    <h2 class="fw-bold text-primary mb-0">{{ $stats['total_applications'] }}</h2>
                    <p class="text-muted small">Applications submitted</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Opportunities -->
    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Recent Opportunities</h5>
                    <a href="{{ route('admin.opportunities.pending') }}" class="btn btn-sm btn-outline-primary">
                        View All Pending
                    </a>
                </div>

                @if($recentOpportunities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Organization</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Deadline</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOpportunities as $opp)
                                    <tr>
                                        <td class="fw-bold">{{ $opp->title }}</td>
                                        <td>{{ $opp->organization->organization_name }}</td>
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
                                        <td>
                                            <a href="{{ route('opportunities.show', $opp->id) }}"
                                                class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-4">No opportunities yet</p>
                @endif
            </div>
        </div>
    </div>
@endsection