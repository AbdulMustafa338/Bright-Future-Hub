@extends('layouts.dashboard')

@section('title', 'Organization Details')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Organization Details</h2>
                    <p class="text-muted mb-0">View organization profile and activity</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Users
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Organization Profile -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Profile Information</h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Organization Name</p>
                        <p class="fw-bold mb-0">{{ $organization->organization_name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Contact Person</p>
                        <p class="fw-bold mb-0">{{ $organization->contact_person ?? 'Not provided' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Status</p>
                        @if($organization->status === 'pending')
                            <span class="badge bg-warning">Pending Review</span>
                        @elseif($organization->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Email</p>
                        <p class="fw-bold mb-0">{{ $organization->user->email }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Account Status</p>
                        @if($organization->user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted mb-1">Joined</p>
                        <p class="fw-bold mb-0">{{ $organization->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                @if($organization->description)
                    <div class="row">
                        <div class="col-12">
                            <p class="text-muted mb-1">Description</p>
                            <p class="mb-0">{{ $organization->description }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Quick Stats</h5>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Total Opportunities</span>
                        <span class="badge bg-primary rounded-pill">{{ $organization->opportunities->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Approved</span>
                        <span
                            class="badge bg-success rounded-pill">{{ $organization->opportunities->where('status', 'approved')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Pending</span>
                        <span
                            class="badge bg-warning rounded-pill">{{ $organization->opportunities->where('status', 'pending')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Rejected</span>
                        <span
                            class="badge bg-danger rounded-pill">{{ $organization->opportunities->where('status', 'rejected')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Opportunities List -->
    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Posted Opportunities</h5>

                @if($organization->opportunities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Deadline</th>
                                    <th>Applications</th>
                                    <th>Posted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($organization->opportunities as $opp)
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
                                        <td>{{ $opp->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('opportunities.show', $opp->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
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
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection