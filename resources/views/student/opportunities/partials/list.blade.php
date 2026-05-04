@forelse($opportunities as $opp)
    <div class="col-md-6 col-lg-4">
        <div class="glass-card h-100 d-flex flex-column overflow-hidden border-0 shadow-sm hover-lift" style="transition: all 0.3s ease;">
            <div class="opportunity-image-header" style="height: 180px; position: relative; overflow: hidden;">
                @if($opp->image)
                    <img src="{{ asset('storage/' . $opp->image) }}" class="w-100 h-100" style="object-fit: contain; transition: transform 0.5s ease; background-color: #f8f9fa;">
                @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(45deg, #002147 0%, #004a99 100%); color: rgba(255,255,255,0.1); font-size: 3.5rem;">
                        <i class="fas {{ $opp->type == 'scholarship' ? 'fa-graduation-cap' : ($opp->type == 'internship' ? 'fa-laptop-code' : 'fa-building') }}"></i>
                    </div>
                @endif
                <div class="position-absolute top-0 end-0 m-3">
                    <span class="badge rounded-pill px-3 py-2 shadow-sm {{ $opp->type == 'scholarship' ? 'bg-primary' : ($opp->type == 'internship' ? 'bg-success' : 'bg-info') }}">
                        {{ ucfirst($opp->type) }}
                    </span>
                </div>
            </div>
            
            <div class="p-4 flex-grow-1 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                        @if($opp->organization->logo)
                            <img src="{{ asset('storage/' . $opp->organization->logo) }}" class="rounded-3 shadow-sm" style="width: 32px; height: 32px; object-fit: contain; border: 1px solid rgba(0,0,0,0.05); background: white;">
                        @else
                            <div class="rounded-3 bg-light d-flex align-items-center justify-content-center text-primary fw-bold shadow-sm" style="width: 32px; height: 32px; font-size: 0.8rem; border: 1px solid rgba(0,0,0,0.05);">
                                {{ substr($opp->organization->organization_name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="ms-2 overflow-hidden">
                        <p class="text-muted small fw-bold mb-0 text-truncate" style="letter-spacing: 0.5px;">
                            {{ $opp->organization->organization_name }}
                        </p>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 text-dark line-clamp-2" style="height: 3rem; line-height: 1.5;">{{ $opp->title }}</h5>

                @if($opp->location)
                    <p class="text-secondary small mb-2">
                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $opp->location }}
                    </p>
                @endif

                <div class="text-secondary small mb-4 flex-grow-1">
                    <p class="line-clamp-3 mb-0">
                        {{ Str::limit($opp->description, 100) }}
                    </p>
                </div>

                <div class="mt-auto border-top pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="deadline-info">
                            <small class="d-block text-muted x-small text-uppercase fw-bold">Deadline</small>
                            <small class="fw-bold {{ $opp->isExpired() ? 'text-danger' : 'text-dark' }}">
                                <i class="far fa-calendar-alt me-1"></i>{{ $opp->deadline->format('M d, Y') }}
                            </small>
                        </div>
                        <a href="{{ route('opportunities.show', $opp->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
                            Details <i class="fas fa-chevron-right ms-1 small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 33, 71, 0.1) !important;
        }
        .hover-lift:hover img {
            transform: scale(1.05);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .x-small {
            font-size: 0.7rem;
        }
    </style>
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