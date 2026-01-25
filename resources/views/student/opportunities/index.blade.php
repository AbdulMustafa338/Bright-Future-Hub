@extends('layouts.dashboard')

@section('title', 'Find Opportunities')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Explore Opportunities</h2>
            <p class="text-muted">Find internships, scholarships, and admissions</p>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="glass-card p-4">
                <form method="GET" action="{{ route('student.opportunities.index') }}">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-lg" name="search"
                                placeholder="Search opportunities..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select form-select-lg" name="type">
                                <option value="">All Types</option>
                                <option value="internship" {{ request('type') == 'internship' ? 'selected' : '' }}>Internship
                                </option>
                                <option value="scholarship" {{ request('type') == 'scholarship' ? 'selected' : '' }}>
                                    Scholarship</option>
                                <option value="admission" {{ request('type') == 'admission' ? 'selected' : '' }}>Admission
                                </option>

                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Opportunities Grid -->
    <div class="row g-4">
        @forelse($opportunities as $opp)
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-primary">{{ ucfirst($opp->type) }}</span>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            {{ $opp->deadline->diffForHumans() }}
                        </small>
                    </div>

                    <h5 class="fw-bold mb-2">{{ $opp->title }}</h5>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-building me-1"></i>{{ $opp->organization->organization_name }}
                    </p>

                    @if($opp->location)
                        <p class="text-muted small mb-3">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $opp->location }}
                        </p>
                    @endif

                    <p class="text-secondary mb-3 flex-grow-1">
                        {{ strlen($opp->description) > 120 ? substr($opp->description, 0, 120) . '...' : $opp->description }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <small class="text-muted">
                            Deadline: {{ $opp->deadline->format('M d, Y') }}
                        </small>
                        <a href="{{ route('opportunities.show', $opp->id) }}" class="btn btn-sm btn-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="glass-card p-5 text-center">
                    <i class="fas fa-search text-muted mb-3" style="font-size: 3rem;"></i>
                    <h5 class="text-muted">No opportunities found</h5>
                    <p class="text-muted">Try adjusting your search filters</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($opportunities->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $opportunities->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
@endsection