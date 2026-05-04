@extends('layouts.main')

@section('title', $opportunity->title)

@section('styles')
<style>
    .opportunity-hero {
        position: relative;
        background: linear-gradient(135deg, var(--primary) 0%, #001a35 100%);
        color: white;
        padding: 4rem 0;
        overflow: hidden;
        margin-top: -20px;
    }

    .opportunity-hero::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: radial-gradient(circle at top right, rgba(255, 215, 0, 0.15), transparent 40%),
                    radial-gradient(circle at bottom left, rgba(255, 215, 0, 0.05), transparent 40%);
        pointer-events: none;
    }

    .opportunity-hero-content {
        position: relative;
        z-index: 2;
    }

    .org-logo-lg {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border-radius: 16px;
        border: 3px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        background: white;
    }

    .badge-premium {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
    }

    .detail-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .detail-card {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }

    .detail-card:hover {
        border-left-color: var(--accent);
        transform: translateX(5px);
        background: rgba(0, 33, 71, 0.02);
    }
</style>
@endsection

@section('content')
    <!-- Premium Hero Section -->
    <div class="opportunity-hero mb-5">
        <div class="container opportunity-hero-content">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="--bs-breadcrumb-divider-color: rgba(255,255,255,0.5);">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white text-decoration-none opacity-75 hover-opacity-100">Home</a></li>
                    @auth
                        @if(Auth::user()->role === 'student')
                            <li class="breadcrumb-item"><a href="{{ route('student.opportunities.index') }}" class="text-white text-decoration-none opacity-75 hover-opacity-100">Opportunities</a></li>
                        @endif
                    @endauth
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($opportunity->title, 40) }}</li>
                </ol>
            </nav>

            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        @if($opportunity->organization->logo)
                            <img src="{{ asset('storage/' . $opportunity->organization->logo) }}" alt="Logo" class="org-logo-lg">
                        @else
                            <div class="org-logo-lg d-flex align-items-center justify-content-center text-primary fs-1 fw-bold">
                                {{ substr($opportunity->organization->organization_name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <div class="d-flex gap-2 mb-2 flex-wrap">
                                <span class="badge-premium">
                                    <i class="fas {{ $opportunity->type == 'scholarship' ? 'fa-graduation-cap' : ($opportunity->type == 'internship' ? 'fa-laptop-code' : 'fa-university') }} text-warning me-2"></i>
                                    {{ ucfirst($opportunity->type) }}
                                </span>
                                @if($opportunity->isExpired())
                                    <span class="badge-premium" style="background: rgba(220, 53, 69, 0.2); border-color: rgba(220, 53, 69, 0.5);">Expired</span>
                                @elseif($opportunity->status === 'approved')
                                    <span class="badge-premium" style="background: rgba(40, 167, 69, 0.2); border-color: rgba(40, 167, 69, 0.5);">Active</span>
                                @endif
                            </div>
                            <h5 class="text-white opacity-75 mb-0 fw-normal">{{ $opportunity->organization->organization_name }}</h5>
                        </div>
                    </div>
                    
                    <h1 class="display-4 fw-bold mb-3 text-white">{{ $opportunity->title }}</h1>
                    
                    <div class="d-flex flex-wrap gap-4 text-white opacity-75">
                        @if($opportunity->location)
                            <span><i class="fas fa-map-marker-alt me-2 text-warning"></i>{{ $opportunity->location }}</span>
                        @endif
                        <span><i class="fas fa-calendar-alt me-2 text-warning"></i>Deadline: {{ $opportunity->deadline->format('M d, Y') }}</span>
                        <span><i class="fas fa-clock me-2 text-warning"></i>Posted {{ $opportunity->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8" data-aos="fade-up">
                
                @if($opportunity->image)
                    <div class="glass-card mb-4 overflow-hidden rounded-4 border-0 shadow-sm">
                        <img src="{{ asset('storage/' . $opportunity->image) }}" alt="{{ $opportunity->title }}" class="w-100" style="max-height: 400px; object-fit: contain; background: #f8f9fa;">
                    </div>
                @endif

                <div class="glass-card p-4 p-md-5 mb-4 rounded-4 border-0 shadow-sm">
                    <h4 class="fw-bold mb-4 d-flex align-items-center">
                        <i class="fas fa-info-circle text-primary me-2"></i>About This Opportunity
                    </h4>
                    <div class="text-secondary" style="white-space: pre-line; line-height: 1.8; font-size: 1.05rem;">
                        {{ $opportunity->description }}
                    </div>
                </div>

                @if($opportunity->eligibility)
                    <div class="glass-card p-4 p-md-5 mb-4 rounded-4 border-0 shadow-sm">
                        <h4 class="fw-bold mb-4 d-flex align-items-center">
                            <i class="fas fa-clipboard-check text-primary me-2"></i>Eligibility Criteria
                        </h4>
                        <div class="text-secondary p-4 bg-light rounded-4" style="white-space: pre-line; line-height: 1.8;">
                            {{ $opportunity->eligibility }}
                        </div>
                    </div>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                
                <!-- Action Card -->
                <div class="glass-card p-4 mb-4 rounded-4 border-0 shadow-sm" style="background: linear-gradient(to bottom right, #ffffff, #f8f9fa);">
                    <h5 class="fw-bold mb-4 border-bottom pb-3">Quick Actions</h5>

                    @auth
                        @if(Auth::user()->role === 'student')
                            @if($opportunity->isExpired())
                                <button class="btn btn-secondary btn-lg w-100 mb-3 rounded-pill fw-bold" disabled>
                                    <i class="fas fa-clock me-2"></i>Deadline Passed
                                </button>
                            @elseif($hasApplied)
                                <button class="btn btn-success btn-lg w-100 mb-3 rounded-pill fw-bold" disabled>
                                    <i class="fas fa-check-circle me-2"></i>Already Applied
                                </button>
                            @else
                                <form method="POST" action="{{ route('student.opportunities.apply', $opportunity->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-premium btn-lg w-100 mb-3 rounded-pill text-center d-flex justify-content-center align-items-center">
                                        <i class="fas fa-paper-plane me-2"></i>Apply Now
                                    </button>
                                </form>
                            @endif

                            @if($opportunity->application_link)
                                <a href="{{ $opportunity->application_link }}" target="_blank"
                                    class="btn btn-outline-primary btn-lg w-100 rounded-pill fw-bold d-flex justify-content-center align-items-center">
                                    <i class="fas fa-external-link-alt me-2"></i>External Link
                                </a>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-premium btn-lg w-100 mb-3 rounded-pill text-center d-flex justify-content-center align-items-center">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Apply
                        </a>
                    @endauth
                </div>

                @auth
                @if(Auth::user()->role === 'student')
                <!-- SMART ATS ANALYSIS -->
                <div class="glass-card p-4 mb-4 rounded-4 border-0 shadow-sm position-relative overflow-hidden">
                    <!-- Decorative background blur -->
                    <div style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: rgba(0, 33, 71, 0.05); border-radius: 50%; filter: blur(20px);"></div>
                    
                    <div class="mb-4 position-relative z-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="fw-bold m-0"><i class="fas fa-robot text-primary me-2"></i>ATS Analysis</h5>
                            <span class="badge bg-light text-primary border rounded-pill px-3 py-2 shadow-sm" id="ats-score-status">Calculating...</span>
                        </div>
                        
                        @if($resumes->count() > 0)
                            <div class="form-floating mt-3">
                                <select id="resume-selector" class="form-select border-primary-subtle rounded-3">
                                    <option value="">Default Profile</option>
                                    @foreach($resumes as $res)
                                        <option value="{{ $res->id }}">{{ $res->resume_name }}</option>
                                    @endforeach
                                </select>
                                <label for="resume-selector">Select Resume</label>
                            </div>
                        @else
                            <div class="alert alert-info mt-2 small border-0 py-2">
                                <i class="fas fa-info-circle me-1"></i> Build a resume to see custom match score.
                            </div>
                        @endif
                    </div>
                    
                    <div class="text-center py-4 bg-light rounded-4 mb-4 shadow-sm border border-white position-relative z-1">
                        <div class="position-relative d-inline-block">
                            <svg width="140" height="140" viewBox="0 0 140 140">
                                <circle cx="70" cy="70" r="60" fill="none" stroke="#e9ecef" stroke-width="10"></circle>
                                <circle id="score-circle" cx="70" cy="70" r="60" fill="none" stroke="url(#scoreGradient)" stroke-width="10" stroke-linecap="round" stroke-dasharray="376.99" stroke-dashoffset="376.99" style="transition: stroke-dashoffset 1.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);"></circle>
                                <defs>
                                    <linearGradient id="scoreGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" stop-color="#002147" />
                                        <stop offset="100%" stop-color="#004a99" />
                                    </linearGradient>
                                </defs>
                                <text x="70" y="80" text-anchor="middle" font-size="28" font-weight="bold" fill="#002147" id="ats-score-text">0%</text>
                            </svg>
                        </div>
                        <p class="mt-3 text-muted fw-bold mb-0">Profile vs Job Match</p>
                    </div>

                    <div id="ats-details" class="d-none position-relative z-1">
                        <div class="mb-3">
                            <h6 class="fw-bold small text-uppercase text-muted mb-2" style="letter-spacing: 1px;">Matched Keywords</h6>
                            <div id="matched-skills" class="d-flex flex-wrap gap-2"></div>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold small text-uppercase text-muted mb-2" style="letter-spacing: 1px;">Missing Skills</h6>
                            <div id="missing-skills" class="d-flex flex-wrap gap-2"></div>
                        </div>
                        <div class="alert bg-warning bg-opacity-10 text-dark border-warning border-opacity-25 rounded-3 p-3 small mb-0 d-flex align-items-start">
                            <i class="fas fa-lightbulb text-warning mt-1 me-2 fs-5"></i> 
                            <span id="ats-tip" class="fw-medium">Add missing skills to improve your score!</span>
                        </div>
                    </div>

                    <!-- AI Insights -->
                    <div id="ai-insights" class="mt-4 pt-4 border-top d-none position-relative z-1">
                        <h6 class="fw-bold small text-uppercase text-primary mb-3 d-flex align-items-center" style="letter-spacing: 1px;">
                            <i class="fas fa-magic me-2 fs-5"></i> AI Detailed Feedback
                        </h6>
                        
                        <div class="mb-3 p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-10">
                            <h6 class="fw-bold d-block mb-2 text-success" style="font-size: 0.9rem;"><i class="fas fa-check-circle me-2"></i>Strengths</h6>
                            <ul id="ai-strengths" class="ps-3 mb-0 text-dark small" style="line-height: 1.6;"></ul>
                        </div>

                        <div class="mb-3 p-3 bg-danger bg-opacity-10 rounded-3 border border-danger border-opacity-10">
                            <h6 class="fw-bold d-block mb-2 text-danger" style="font-size: 0.9rem;"><i class="fas fa-times-circle me-2"></i>Areas to Improve</h6>
                            <ul id="ai-weaknesses" class="ps-3 mb-0 text-dark small" style="line-height: 1.6;"></ul>
                        </div>

                        <div class="p-3 bg-primary bg-opacity-10 rounded-3 border border-primary border-opacity-10">
                            <h6 class="fw-bold d-block mb-2 text-primary" style="font-size: 0.9rem;"><i class="fas fa-bolt me-2"></i>Quick Tips</h6>
                            <ul id="ai-tips" class="ps-3 mb-0 text-dark small" style="line-height: 1.6;"></ul>
                        </div>
                    </div>
                </div>
                @endif
                @endauth

                <!-- Key Details -->
                <div class="glass-card p-4 rounded-4 border-0 shadow-sm">
                    <h5 class="fw-bold mb-4 border-bottom pb-3">Key Information</h5>

                    <div class="detail-card d-flex align-items-center p-3 mb-2 rounded-3">
                        <div class="detail-icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block fw-semibold text-uppercase" style="font-size: 0.7rem;">Opportunity Type</small>
                            <strong class="text-dark">{{ ucfirst($opportunity->type) }}</strong>
                        </div>
                    </div>

                    <div class="detail-card d-flex align-items-center p-3 mb-2 rounded-3">
                        <div class="detail-icon-box bg-danger bg-opacity-10 text-danger">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block fw-semibold text-uppercase" style="font-size: 0.7rem;">Application Deadline</small>
                            <strong class="text-dark">{{ $opportunity->deadline->format('F d, Y') }}</strong>
                        </div>
                    </div>

                    @if($opportunity->location)
                        <div class="detail-card d-flex align-items-center p-3 mb-2 rounded-3">
                            <div class="detail-icon-box bg-success bg-opacity-10 text-success">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block fw-semibold text-uppercase" style="font-size: 0.7rem;">Location</small>
                                <strong class="text-dark">{{ $opportunity->location }}</strong>
                            </div>
                        </div>
                    @endif

                    @if($opportunity->fees)
                        <div class="detail-card d-flex align-items-center p-3 mb-2 rounded-3">
                            <div class="detail-icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block fw-semibold text-uppercase" style="font-size: 0.7rem;">Stipend / Fees</small>
                                <strong class="text-dark">{{ $opportunity->fees }}</strong>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@auth
@if(Auth::user()->role === 'student')
<script>
    $(document).ready(function() {
        function fetchAtsScore(resumeId = '') {
            $('#ats-score-status').text('Calculating...');
            
            let url = '{{ route('student.resume.check-match', $opportunity->id) }}';
            if (resumeId) {
                url += '/' + resumeId;
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    // Update Score
                    $('#ats-score-text').text(data.score + '%');
                    $('#ats-score-status').text(data.status);
                    
                    // Update Circle
                    const circle = document.getElementById('score-circle');
                    if (circle) {
                        const radius = 60;
                        const circumference = 2 * Math.PI * radius;
                        const offset = circumference - (data.score / 100) * circumference;
                        circle.style.strokeDashoffset = offset;
                    }
                    
                    // Show details
                    $('#ats-details').removeClass('d-none');
                    
                    // Fill Skills
                    let matchedHtml = '';
                    data.matched.forEach(skill => {
                        matchedHtml += `<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill"><i class="fas fa-check me-1 small"></i>${skill}</span>`;
                    });
                    $('#matched-skills').html(matchedHtml || '<small class="text-muted">None</small>');
                    
                    let missingHtml = '';
                    data.missing.forEach(skill => {
                        missingHtml += `<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill"><i class="fas fa-times me-1 small"></i>${skill}</span>`;
                    });
                    $('#missing-skills').html(missingHtml || '<small class="text-muted">None</small>');

                    if(data.score < 50) {
                        $('#ats-tip').text('Profile needs more relevant keywords.');
                    } else if(data.score < 80) {
                        $('#ats-tip').text('Good match! Add a few more skills.');
                    } else {
                        $('#ats-tip').text('Excellent match! You are ready.');
                    }

                    // Populate AI Insights if available
                    if (data.ai_status === 'success') {
                        $('#ai-insights').removeClass('d-none');
                        
                        let strengthsHtml = '';
                        (data.strengths || []).forEach(s => strengthsHtml += `<li class="mb-1">${s}</li>`);
                        $('#ai-strengths').html(strengthsHtml || '<li>Keep building your skills!</li>');

                        let weaknessesHtml = '';
                        (data.weaknesses || []).forEach(w => weaknessesHtml += `<li class="mb-1">${w}</li>`);
                        $('#ai-weaknesses').html(weaknessesHtml || '<li>No major weaknesses found!</li>');

                        let tipsHtml = '';
                        (data.tips || []).forEach(t => tipsHtml += `<li class="mb-1">${t}</li>`);
                        $('#ai-tips').html(tipsHtml || '<li>You are good to go.</li>');
                    } else {
                        $('#ai-insights').addClass('d-none');
                    }
                }
            });
        }

        // Initial fetch
        fetchAtsScore();

        // Handle Change
        $('#resume-selector').on('change', function() {
            fetchAtsScore($(this).val());
        });
    });
</script>
@endif
@endauth
@endsection