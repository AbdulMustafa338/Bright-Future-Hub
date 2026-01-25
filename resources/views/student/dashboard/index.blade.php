@extends('layouts.dashboard')

@section('title', 'Student Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Welcome back, {{ Auth::user()->name }}!</h2>
            <p class="text-muted">Discover and apply for amazing opportunities</p>
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
        <div class="col-md-4">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">My Applications</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_applications'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-file-alt text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Active Opportunities</p>
                        <h3 class="fw-bold mb-0 text-success">{{ $stats['active_opportunities'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="fas fa-briefcase text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Shortlisted</p>
                        <h3 class="fw-bold mb-0 text-warning">{{ $stats['shortlisted'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-star text-warning fs-4"></i>
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
                    <a href="{{ route('student.opportunities.index') }}" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Find Opportunities
                    </a>
                    <a href="{{ route('student.applications.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i>My Applications
                    </a>
                    <a href="{{ route('student.profile.edit') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-user me-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Recent Applications</h5>
                    <a href="{{ route('student.applications.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>

                @if($recentApplications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Opportunity</th>
                                    <th>Organization</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Applied On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentApplications as $app)
                                    <tr>
                                        <td class="fw-bold">{{ $app->opportunity->title }}</td>
                                        <td>{{ $app->opportunity->organization->organization_name }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($app->opportunity->type) }}</span>
                                        </td>
                                        <td>
                                            @if($app->status === 'applied')
                                                <span class="badge bg-info">Applied</span>
                                            @elseif($app->status === 'shortlisted')
                                                <span class="badge bg-warning">Shortlisted</span>
                                            @elseif($app->status === 'accepted')
                                                <span class="badge bg-success">Accepted</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($app->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $app->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('opportunities.show', $app->opportunity->id) }}"
                                                class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-search text-muted mb-3" style="font-size: 3rem;"></i>
                        <p class="text-muted">You haven't applied to any opportunities yet</p>
                        <a href="{{ route('student.opportunities.index') }}" class="btn btn-primary mt-2">
                            Explore Opportunities
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection