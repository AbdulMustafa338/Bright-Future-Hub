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
    @if(request()->page == 1 || !request()->has('page'))
        <div class="col-12">
            <div class="glass-card p-5 text-center">
                <i class="fas fa-search text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-muted">No opportunities found</h5>
                <p class="text-muted">Try adjusting your search filters</p>
            </div>
        </div>
    @endif
@endforelse