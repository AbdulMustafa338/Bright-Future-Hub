@extends('layouts.dashboard')

@section('title', 'My Applications')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">My Applications</h2>
            <p class="text-muted">Track all your submitted applications</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                @if($applications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Opportunity</th>
                                    <th>Organization</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Applied On</th>
                                    <th>Deadline</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $app)
                                    <tr>
                                        <td class="fw-bold">{{ $app->opportunity->title }}</td>
                                        <td>{{ $app->opportunity->organization->organization_name }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($app->opportunity->type) }}</span>
                                        </td>
                                        <td>
                                            @if($app->status === 'applied')
                                                <span class="badge bg-info">Applied</span>
                                            @elseif($app->status === 'viewed')
                                                <span class="badge bg-primary">Viewed</span>
                                            @elseif($app->status === 'shortlisted')
                                                <span class="badge bg-warning">Shortlisted</span>
                                            @elseif($app->status === 'accepted')
                                                <span class="badge bg-success">Accepted</span>
                                            @elseif($app->status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $app->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($app->opportunity->isExpired())
                                                <span class="text-danger">Expired</span>
                                            @else
                                                {{ $app->opportunity->deadline->format('M d, Y') }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('opportunities.show', $app->opportunity->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($applications->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $applications->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No applications yet</h5>
                        <p class="text-muted">Start exploring opportunities and apply to get started</p>
                        <a href="{{ route('student.opportunities.index') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-search me-2"></i>Find Opportunities
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection