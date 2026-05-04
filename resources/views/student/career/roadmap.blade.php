@extends('layouts.dashboard')

@section('title', 'AI Career Roadmap')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-11">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm rounded-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Header Section -->
        <div class="glass-card p-5 mb-5 text-white position-relative overflow-hidden" style="background: var(--primary) !important;">
            <div class="position-absolute top-0 end-0 p-4 opacity-10">
                <i class="fas fa-route fa-6x"></i>
            </div>
            
            <div class="position-relative z-index-1">
                <h1 class="fw-bold mb-3"><i class="fas fa-magic me-2 text-warning"></i>AI Career Roadmap</h1>
                <p class="lead opacity-75 mb-4">Your personalized path to becoming a professional {{ $roadmap->role_title ?? 'Expert' }}</p>
                
                <form action="{{ route('student.career.generate') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-8">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-0 text-primary rounded-start-4"><i class="fas fa-search"></i></span>
                            <input type="text" name="target_role" class="form-control border-0 rounded-end-4" 
                                   placeholder="Enter target role (e.g. Data Scientist, Cloud Engineer)" 
                                   value="{{ $roadmap->role_title ?? '' }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn-premium-accent w-100 h-100 py-3 shadow-sm border-0">
                            <i class="fas fa-sync-alt me-2"></i> {{ $roadmap ? 'Regenerate' : 'Generate Roadmap' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($roadmap)
            @php $data = $roadmap->roadmap_data; @endphp
            
            <!-- Roadmap Summary -->
            <div class="glass-card p-4 mb-5" style="border-left: 6px solid var(--accent) !important;">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                        <i class="fas fa-info-circle text-primary fs-5"></i>
                    </div>
                    <h4 class="fw-bold mb-0">Strategy Summary</h4>
                </div>
                <p class="text-secondary lead mb-0">{{ $data['summary'] ?? 'Follow this structured path to achieve your career goals.' }}</p>
            </div>

            <!-- Timeline Roadmap -->
            <div class="roadmap-timeline position-relative ps-md-5">
                <div class="timeline-line d-none d-md-block" style="position: absolute; left: 15px; top: 0; bottom: 0; width: 4px; background: rgba(0,33,71,0.05); border-radius: 10px;"></div>

                @foreach($data['steps'] ?? [] as $index => $step)
                    <div class="timeline-item mb-5 position-relative">
                        <!-- Dot -->
                        <div class="timeline-dot d-none d-md-block" style="position: absolute; left: -45px; top: 10px; width: 24px; height: 24px; background: white; border: 4px solid var(--primary); border-radius: 50%; z-index: 2;"></div>
                        
                        <div class="row align-items-center g-4">
                            <div class="col-md-11">
                                <div class="glass-card p-4 border-0 shadow-sm position-relative">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="badge bg-primary px-3 py-2 rounded-pill mb-2">Step {{ $index + 1 }}</span>
                                            <h4 class="fw-bold mb-1">{{ $step['title'] }}</h4>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold">
                                                <i class="far fa-calendar-alt me-1"></i> {{ $step['duration'] ?? 'Self-paced' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-muted mb-4">{{ $step['description'] }}</p>
                                    
                                    @if(!empty($step['resources']))
                                        <div class="mt-3 pt-3 border-top">
                                            <h6 class="fw-bold small text-uppercase text-primary letter-spacing-1 mb-3">
                                                <i class="fas fa-book-reader me-2"></i>Learning Resources
                                            </h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($step['resources'] as $resource)
                                                    <span class="badge bg-white text-dark border-0 shadow-sm p-3 rounded-3 fw-normal">
                                                        <i class="fas fa-external-link-alt me-2 text-primary opacity-50"></i> {{ $resource }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Projects & Certifications -->
            <div class="row g-4 mt-2">
                <div class="col-md-6">
                    <div class="glass-card p-4 h-100 border-0 shadow-sm" style="border-top: 5px solid var(--warning) !important;">
                        <h5 class="fw-bold mb-4 text-warning"><i class="fas fa-laptop-code me-2"></i>Suggested Projects</h5>
                        <div class="list-group list-group-flush gap-2">
                            @foreach($data['project_ideas'] ?? [] as $project)
                                <div class="list-group-item bg-light-subtle rounded-3 border-0 d-flex align-items-center mb-1">
                                    <i class="fas fa-check text-warning me-3"></i> {{ $project }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="glass-card p-4 h-100 border-0 shadow-sm" style="border-top: 5px solid var(--success) !important;">
                        <h5 class="fw-bold mb-4 text-success"><i class="fas fa-certificate me-2"></i>Top Certifications</h5>
                        <div class="list-group list-group-flush gap-2">
                            @foreach($data['certifications'] ?? [] as $cert)
                                <div class="list-group-item bg-light-subtle rounded-3 border-0 d-flex align-items-center mb-1">
                                    <i class="fas fa-award text-success me-3"></i> {{ $cert }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="glass-card p-5 text-center py-5">
                <div class="bg-primary bg-opacity-10 d-inline-block p-4 rounded-circle mb-4">
                    <i class="fas fa-rocket fa-3x text-primary"></i>
                </div>
                <h3 class="fw-bold text-primary">Ready to launch your career?</h3>
                <p class="text-muted col-md-8 mx-auto lead">Enter your target role above and let our Specialized Gemini AI create a step-by-step roadmap tailored just for you.</p>
            </div>
        @endif
    </div>
</div>
@endsection
