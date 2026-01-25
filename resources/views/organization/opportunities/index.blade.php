@extends('layouts.dashboard')

@section('title', 'My Opportunities')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">My Opportunities</h2>
                    <p class="text-muted">Manage your posted opportunities</p>
                </div>
                <a href="{{ route('organization.opportunities.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Post New Opportunity
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

    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                @if($opportunities->count() > 0)
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
                                @foreach($opportunities as $opp)
                                    <tr>
                                        <td class="fw-bold">{{ $opp->title }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($opp->type) }}</span>
                                        </td>
                                        <td>
                                            @if($opp->status === 'pending')
                                                <span class="badge bg-warning">Pending Review</span>
                                            @elseif($opp->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $opp->deadline->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('organization.applications.index', $opp->id) }}"
                                                class="text-decoration-none">
                                                {{ $opp->applications->count() }} applications
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('opportunities.show', $opp->id) }}"
                                                    class="btn btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('organization.opportunities.edit', $opp->id) }}"
                                                    class="btn btn-outline-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST"
                                                    action="{{ route('organization.opportunities.destroy', $opp->id) }}"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this opportunity?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @if($opp->status === 'rejected' && $opp->rejection_reason)
                                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                                        data-bs-target="#reasonModal{{ $opp->id }}" title="View Rejection Reason">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </button>
                                                @endif
                                            </div>

                                            @if($opp->status === 'rejected' && $opp->rejection_reason)
                                                <!-- Rejection Reason Modal -->
                                                <div class="modal fade" id="reasonModal{{ $opp->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning-subtle">
                                                                <h5 class="modal-title text-warning-emphasis">
                                                                    <i class="fas fa-exclamation-circle me-2"></i>Rejection Reason
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h6 class="fw-bold mb-2">Message from Admin:</h6>
                                                                <p class="text-secondary p-3 bg-light rounded border">
                                                                    {{ $opp->rejection_reason }}
                                                                </p>
                                                                <small class="text-muted">
                                                                    Rejected on:
                                                                    {{ $opp->rejectionMessage->created_at->format('M d, Y h:i A') }}
                                                                </small>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <a href="{{ route('organization.opportunities.edit', $opp->id) }}"
                                                                    class="btn btn-primary">Edit Opportunity</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($opportunities->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $opportunities->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-briefcase text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No opportunities yet</h5>
                        <p class="text-muted">Start by posting your first opportunity</p>
                        <a href="{{ route('organization.opportunities.create') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-plus me-2"></i>Post Opportunity
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection