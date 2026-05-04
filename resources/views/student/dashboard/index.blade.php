@extends('layouts.dashboard')

@section('title', 'Student Dashboard')

@section('content')
    <!-- Dashboard Header -->
    <div class="row align-items-center mb-5" data-aos="fade-down">
        <div class="col-md-8">
            <h2 class="fw-bold display-6 mb-1">Welcome back, {{ Auth::user()->name }}! 🎓</h2>
            <p class="text-muted lead">Your personalized academic success portal is ready.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <span class="badge bg-white text-primary border shadow-sm px-4 py-2 rounded-pill fw-bold">
                <i class="far fa-calendar-check me-2"></i> {{ date('l, M d') }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 py-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Stats Section -->
    <div class="row g-4 mb-5">
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="glass-card p-4 h-100 position-relative border-0 shadow-sm" style="border-left: 6px solid var(--primary) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small text-uppercase fw-bold letter-spacing-1">My Applications</p>
                        <h2 class="fw-bold mb-0 display-5">{{ $stats['total_applications'] }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-4 rounded-4">
                        <i class="fas fa-file-signature text-primary fs-3"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">
                    <i class="fas fa-arrow-up text-success me-1"></i> Active tracking enabled
                </div>
            </div>
        </div>

        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="glass-card p-4 h-100 border-0 shadow-sm" style="border-left: 6px solid var(--success) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small text-uppercase fw-bold letter-spacing-1">Active Opps</p>
                        <h2 class="fw-bold mb-0 text-success display-5">{{ $stats['active_opportunities'] }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-4 rounded-4">
                        <i class="fas fa-bolt text-success fs-3"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">
                    <i class="fas fa-check text-success me-1"></i> Ready for submission
                </div>
            </div>
        </div>

        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="glass-card p-4 h-100 border-0 shadow-sm" style="border-left: 6px solid var(--warning) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small text-uppercase fw-bold letter-spacing-1">Your Rank</p>
                        <h2 class="fw-bold mb-0 text-warning display-5">Top 5%</h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-4 rounded-4">
                        <i class="fas fa-crown text-warning fs-3"></i>
                    </div>
                </div>
                <div class="mt-3 small text-muted">
                    <i class="fas fa-star text-warning me-1"></i> Based on profile completion
                </div>
            </div>
        </div>
    </div>

    <!-- AI Promo & Actions -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8" data-aos="fade-right">
            <div class="glass-card p-4 h-100 border-0 shadow-sm overflow-hidden position-relative">
                <div class="position-absolute top-0 end-0 p-5 opacity-05">
                    <i class="fas fa-brain fa-8x"></i>
                </div>
                <div class="position-relative z-index-1">
                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                        <span class="bg-primary p-2 rounded-3 me-3"><i class="fas fa-plus text-white small"></i></span>
                        Personalized Quick Actions
                    </h5>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('student.opportunities.index') }}" class="btn-premium">
                            <i class="fas fa-search me-2"></i> Explore Opportunities
                        </a>
                        <a href="{{ route('student.resume.index') }}" class="btn btn-outline-primary px-4 py-3 rounded-4 border-2">
                            <i class="fas fa-pen-nib me-2"></i> Update Resume
                        </a>
                        <a href="{{ route('student.profile.edit') }}" class="btn btn-light px-4 py-3 rounded-4">
                            <i class="fas fa-cog me-2"></i> Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4" data-aos="fade-left">
            <div class="glass-card p-4 h-100 text-white border-0 shadow-premium" style="background: var(--primary) !important;">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold">AI POWERED</span>
                    <i class="fas fa-route fs-2 opacity-25"></i>
                </div>
                <h5 class="fw-bold mb-2">Success Roadmap</h5>
                <p class="small opacity-75 mb-4">Let our specialized AI analyze your profile and generate a step-by-step career path.</p>
                <a href="{{ route('student.career.roadmap') }}" class="btn-premium-accent w-100 py-3 text-center border-0">
                    Get My Roadmap
                </a>
            </div>
        </div>
    </div>

    <!-- Recommendations -->
    @if(isset($recommendations) && $recommendations->count() > 0)
    <div class="mb-5" data-aos="fade-up">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><i class="fas fa-sparkles text-warning me-2"></i>AI Recommendations</h4>
            <a href="{{ route('student.opportunities.index') }}" class="text-primary text-decoration-none fw-bold small">Explore All <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        
        <div class="row g-4">
            @foreach($recommendations->take(4) as $opp)
            <div class="col-md-6 col-lg-3">
                <div class="glass-card h-100 border-0 p-0 overflow-hidden shadow-hover shadow-sm">
                    <div class="opportunity-image-thumbnail" style="height: 120px; position: relative; overflow: hidden; background: #f8f9fa;">
                        @if($opp->image)
                            <img src="{{ asset('storage/' . $opp->image) }}" alt="{{ $opp->title }}" style="width: 100%; height: 100%; object-fit: contain; background-color: #f8f9fa;">
                        @else
                            <div class="h-100 w-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #002147 0%, #003366 100%); color: rgba(255,255,255,0.05); font-size: 2.5rem;">
                                <i class="fas {{ $opp->type == 'scholarship' ? 'fa-graduation-cap' : ($opp->type == 'internship' ? 'fa-laptop-code' : 'fa-building') }}"></i>
                            </div>
                        @endif
                        @if($opp->match_percentage >= 80)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-success shadow-sm" style="font-size: 0.65rem;">
                                    <i class="fas fa-star me-1"></i> Best Match
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge rounded-pill px-2 py-1 fw-bold {{ $opp->type == 'scholarship' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success' }}" style="font-size: 0.65rem;">
                                {{ ucfirst($opp->type) }}
                            </span>
                            @if($opp->match_percentage)
                                <div class="text-success small fw-bold" style="font-size: 0.7rem;">
                                    {{ $opp->match_percentage }}% Match
                                </div>
                            @endif
                        </div>
                        <h6 class="fw-bold text-truncate mb-1" title="{{ $opp->title }}">{{ $opp->title }}</h6>
                        <p class="text-muted small mb-4"><i class="fas fa-building me-1 small"></i> {{ $opp->organization->organization_name }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="small text-muted fw-bold"><i class="far fa-clock me-1"></i> {{ $opp->deadline->diffForHumans(null, true) }} left</span>
                            <a href="{{ route('opportunities.show', $opp->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Recent History -->
    <div class="row" data-aos="fade-up">
        <div class="col-12">
            <div class="glass-card p-0 border-0 shadow-sm overflow-hidden">
                <div class="p-4 bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Recent Applications</h5>
                    <a href="{{ route('student.applications.index') }}" class="btn btn-sm btn-link text-decoration-none fw-bold">View History</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th class="ps-4 py-3 small text-muted">ORGANIZATION</th>
                                <th class="py-3 small text-muted">OPPORTUNITY</th>
                                <th class="py-3 small text-muted text-center">STATUS</th>
                                <th class="py-3 small text-muted">DATE</th>
                                <th class="pe-4 py-3 text-end">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentApplications as $app)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $app->opportunity->organization->organization_name }}</div>
                                    </td>
                                    <td>{{ $app->opportunity->title }}</td>
                                    <td class="text-center">
                                        @php
                                            $badgeClass = match($app->status) {
                                                'applied' => 'bg-info',
                                                'shortlisted' => 'bg-warning text-dark',
                                                'accepted' => 'bg-success',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge rounded-pill px-3 py-2 fw-bold text-uppercase" style="font-size: 0.65rem;">{{ $app->status }}</span>
                                    </td>
                                    <td class="text-muted small">{{ $app->created_at->format('M d, Y') }}</td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('opportunities.show', $app->opportunity->id) }}" class="btn btn-sm btn-light border rounded-pill px-3">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-center text-muted">
                                        No recent applications found. Start exploring!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection