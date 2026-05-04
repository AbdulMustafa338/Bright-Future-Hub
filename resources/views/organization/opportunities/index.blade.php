@extends('layouts.dashboard')

@section('title', 'My Opportunities')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">My Opportunities</h2>
                    <p class="text-muted">You have posted a total of <strong>{{ $opportunities->total() }}</strong> {{ Str::plural('opportunity', $opportunities->total()) }}</p>
                </div>
                <a href="{{ route('organization.opportunities.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Post New Opportunity
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 alert-dismissible fade show d-flex align-items-center gap-3 py-3" role="alert">
            <div class="flex-shrink-0 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                <i class="fas fa-check-circle text-success fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block">Success!</strong>
                <span class="text-secondary">{{ session('success') }}</span>
            </div>
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
                                            </div>

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