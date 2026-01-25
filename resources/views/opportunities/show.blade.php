@extends('layouts.main')

@section('title', $opportunity->title)

@section('content')
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                @auth
                    @if(Auth::user()->role === 'student')
                        <li class="breadcrumb-item"><a href="{{ route('student.opportunities.index') }}">Opportunities</a></li>
                    @endif
                @endauth
                <li class="breadcrumb-item active">{{ $opportunity->title }}</li>
            </ol>
        </nav>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="glass-card p-4 mb-4">
                    <!-- Header -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-primary fs-6">{{ ucfirst($opportunity->type) }}</span>
                            @if($opportunity->isExpired())
                                <span class="badge bg-danger">Expired</span>
                            @elseif($opportunity->status === 'approved')
                                <span class="badge bg-success">Active</span>
                            @endif
                        </div>

                        <h1 class="fw-bold mb-3">{{ $opportunity->title }}</h1>

                        <div class="d-flex align-items-center text-muted mb-3">
                            <i class="fas fa-building me-2"></i>
                            <span class="fw-bold">{{ $opportunity->organization->organization_name }}</span>
                        </div>

                        <div class="d-flex flex-wrap gap-3 text-muted">
                            @if($opportunity->location)
                                <span><i class="fas fa-map-marker-alt me-2"></i>{{ $opportunity->location }}</span>
                            @endif
                            <span><i class="fas fa-calendar me-2"></i>Deadline:
                                {{ $opportunity->deadline->format('M d, Y') }}</span>
                            @if($opportunity->fees)
                                <span><i class="fas fa-dollar-sign me-2"></i>{{ $opportunity->fees }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h4 class="fw-bold mb-3">About This Opportunity</h4>
                        <p class="text-secondary" style="white-space: pre-line;">{{ $opportunity->description }}</p>
                    </div>

                    <!-- Eligibility -->
                    @if($opportunity->eligibility)
                        <div class="mb-4">
                            <h4 class="fw-bold mb-3">Eligibility Criteria</h4>
                            <p class="text-secondary" style="white-space: pre-line;">{{ $opportunity->eligibility }}</p>
                        </div>
                    @endif

                    <!-- Application Link -->
                    @if($opportunity->application_link)
                        <div class="alert alert-info">
                            <i class="fas fa-link me-2"></i>
                            <strong>External Application:</strong>
                            <a href="{{ $opportunity->application_link }}" target="_blank" class="text-decoration-none">
                                {{ $opportunity->application_link }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="glass-card p-4 mb-4">
                    <h5 class="fw-bold mb-4">Quick Actions</h5>

                    @auth
                        @if(Auth::user()->role === 'student')
                            @if($opportunity->isExpired())
                                <button class="btn btn-secondary btn-lg w-100 mb-3" disabled>
                                    <i class="fas fa-clock me-2"></i>Deadline Passed
                                </button>
                            @elseif($hasApplied)
                                <button class="btn btn-success btn-lg w-100 mb-3" disabled>
                                    <i class="fas fa-check me-2"></i>Already Applied
                                </button>
                            @else
                                <form method="POST" action="{{ route('student.opportunities.apply', $opportunity->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                        <i class="fas fa-paper-plane me-2"></i>Apply Now
                                    </button>
                                </form>
                            @endif

                            @if($opportunity->application_link)
                                <a href="{{ $opportunity->application_link }}" target="_blank"
                                    class="btn btn-outline-primary btn-lg w-100">
                                    <i class="fas fa-external-link-alt me-2"></i>External Application
                                </a>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Apply
                        </a>
                    @endauth
                </div>

                <!-- Key Details -->
                <div class="glass-card p-4">
                    <h5 class="fw-bold mb-4">Key Details</h5>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Type</small>
                        <strong>{{ ucfirst($opportunity->type) }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Deadline</small>
                        <strong>{{ $opportunity->deadline->format('F d, Y') }}</strong>
                        <br>
                        <small class="text-muted">{{ $opportunity->deadline->diffForHumans() }}</small>
                    </div>

                    @if($opportunity->location)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Location</small>
                            <strong>{{ $opportunity->location }}</strong>
                        </div>
                    @endif

                    @if($opportunity->fees)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Fees/Stipend</small>
                            <strong>{{ $opportunity->fees }}</strong>
                        </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Posted</small>
                        <strong>{{ $opportunity->created_at->format('M d, Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection