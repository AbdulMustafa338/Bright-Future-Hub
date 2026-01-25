@extends('layouts.dashboard')

@section('title', 'All Opportunities')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">All Opportunities</h2>
                    <p class="text-muted">Manage all opportunities on the platform</p>
                </div>
                <a href="{{ route('admin.opportunities.pending') }}" class="btn btn-warning">
                    <i class="fas fa-clock me-2"></i>Pending Approvals
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

    <!-- Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="glass-card p-3">
                <form method="GET" action="{{ route('admin.opportunities.index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Filter by Status</label>
                            <select class="form-select" name="status">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                @if($opportunities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Organization</th>
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
                                        <td class="fw-bold">{{ Str::limit($opp->title, 40) }}</td>
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
                                        <td>
                                            {{ $opp->deadline->format('M d, Y') }}
                                            @if($opp->isExpired())
                                                <br><small class="text-danger">Expired</small>
                                            @endif
                                        </td>
                                        <td>{{ $opp->applications->count() }}</td>
                                        <td>
                                            <a href="{{ route('opportunities.show', $opp->id) }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
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
                        <h5 class="text-muted">No opportunities found</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection