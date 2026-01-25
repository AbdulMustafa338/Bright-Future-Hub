@extends('layouts.dashboard')

@section('title', 'Applications')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Applications for: {{ $opportunity->title }}</h2>
            <p class="text-muted">{{ $opportunity->organization->organization_name }}</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="glass-card p-3">
                <div class="row">
                    <div class="col-md-3">
                        <small class="text-muted d-block">Total Applications</small>
                        <h4 class="fw-bold mb-0">{{ $applications->total() }}</h4>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Opportunity Type</small>
                        <span class="badge bg-primary">{{ ucfirst($opportunity->type) }}</span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Deadline</small>
                        <strong>{{ $opportunity->deadline->format('M d, Y') }}</strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Status</small>
                        @if($opportunity->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-warning">{{ ucfirst($opportunity->status) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                @if($applications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Applicant Name</th>
                                    <th>Email</th>
                                    <th>Field of Study</th>
                                    <th>Education Level</th>
                                    <th>Applied On</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $app)
                                    <tr>
                                        <td class="fw-bold">{{ $app->user->name }}</td>
                                        <td>{{ $app->user->email }}</td>
                                        <td>{{ $app->user->field_of_study ?? 'N/A' }}</td>
                                        <td>{{ $app->user->education_level ?? 'N/A' }}</td>
                                        <td>{{ $app->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($app->status === 'applied')
                                                <span class="badge bg-info">Applied</span>
                                            @elseif($app->status === 'viewed')
                                                <span class="badge bg-primary">Viewed</span>
                                            @elseif($app->status === 'shortlisted')
                                                <span class="badge bg-warning">Shortlisted</span>
                                            @elseif($app->status === 'accepted')
                                                <span class="badge bg-success">Accepted</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                @if($app->status !== 'shortlisted')
                                                    <form method="POST"
                                                        action="{{ route('organization.applications.update-status', $app->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="shortlisted">
                                                        <button type="submit" class="btn btn-warning btn-sm" title="Shortlist">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($app->status !== 'accepted')
                                                    <form method="POST"
                                                        action="{{ route('organization.applications.update-status', $app->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit" class="btn btn-success btn-sm" title="Accept">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($app->status !== 'rejected')
                                                    <form method="POST"
                                                        action="{{ route('organization.applications.update-status', $app->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Reject">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
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
                        <p class="text-muted">Applications will appear here once students apply</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('organization.opportunities.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to My Opportunities
            </a>
        </div>
    </div>
@endsection