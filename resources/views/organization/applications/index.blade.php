@extends('layouts.dashboard')

@section('title', 'Applications')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            @if(isset($isAllView) && $isAllView)
                <h2 class="fw-bold">All Applications</h2>
                <p class="text-muted">Consolidated view of all student applications</p>
            @else
                <h2 class="fw-bold">Applications for: {{ $opportunity->title }}</h2>
                <p class="text-muted">{{ $opportunity->organization->organization_name }}</p>
            @endif
        </div>
    </div>

    @if(!(isset($isAllView) && $isAllView))
    <div class="row mb-4">
        <div class="col-12">
            <div class="glass-card p-3">
                <div class="row">
                    <div class="col-md-3">
                        <small class="text-muted d-block">Total Applications</small>
                        <h4 class="fw-bold mb-0">{{ $applications->total() }}</h4>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Opportunity Type</small>
                        <span class="badge bg-primary">{{ ucfirst($opportunity->type) }}</span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Deadline</small>
                        <strong>{{ $opportunity->deadline->format('M d, Y') }}</strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Status</small>
                        @if($opportunity->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-warning">{{ ucfirst($opportunity->status) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                @if($applications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Applicant</th>
                                    @if(isset($isAllView) && $isAllView)
                                        <th>Opportunity</th>
                                    @endif
                                    <th>Field of Study</th>
                                    <th>Applied On</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $app)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($app->user->studentProfile && $app->user->studentProfile->profile_image)
                                                    <img src="{{ asset('storage/' . $app->user->studentProfile->profile_image) }}" 
                                                         class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 40px; height: 40px; font-weight: bold; color: var(--primary);">
                                                        {{ substr($app->user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold">{{ $app->user->name }}</div>
                                                    <small class="text-muted">{{ $app->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        @if(isset($isAllView) && $isAllView)
                                            <td>
                                                <div class="fw-bold text-primary">{{ $app->opportunity->title }}</div>
                                                <small class="text-muted">{{ ucfirst($app->opportunity->type) }}</small>
                                            </td>
                                        @endif
                                        <td>{{ $app->user->field_of_study ?? 'N/A' }}</td>
                                        <td>{{ $app->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-info',
                                                    'viewed' => 'bg-secondary',
                                                    'shortlisted' => 'bg-warning',
                                                    'accepted' => 'bg-success',
                                                    'rejected' => 'bg-danger'
                                                ];
                                                $color = $statusColors[$app->status] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $color }}">{{ ucfirst($app->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <!-- View Profile Button -->
                                                <button type="button" class="btn btn-outline-primary" 
                                                        data-bs-toggle="modal" data-bs-target="#profileModal{{ $app->id }}" title="View Profile">
                                                    <i class="fas fa-user-circle"></i>
                                                </button>

                                                @if($app->status !== 'shortlisted')
                                                    <form method="POST" action="{{ route('organization.applications.update-status', $app->id) }}" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="shortlisted">
                                                        <button type="submit" class="btn btn-outline-warning" title="Shortlist">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($app->status !== 'accepted')
                                                    <form method="POST" action="{{ route('organization.applications.update-status', $app->id) }}" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit" class="btn btn-outline-success" title="Accept">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($app->status !== 'rejected')
                                                    <form method="POST" action="{{ route('organization.applications.update-status', $app->id) }}" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="btn btn-outline-danger" title="Reject">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($applications->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $applications->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No applications found</h5>
                        <p class="text-muted">Students who apply will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-5">
        <div class="col-12 text-center">
            <a href="{{ route('organization.opportunities.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to My Opportunities
            </a>
        </div>
    </div>

    <!-- Modals Section - Placed outside of containers for better rendering -->
    @foreach($applications as $app)
    <div class="modal fade" id="profileModal{{ $app->id }}" tabindex="-1" aria-labelledby="profileModalLabel{{ $app->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header bg-primary text-white border-0 py-3">
                    <h5 class="modal-title fw-bold" id="profileModalLabel{{ $app->id }}">
                        <i class="fas fa-id-card me-2"></i>Student Profiling
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <!-- Profile Header -->
                    <div class="bg-primary bg-opacity-10 p-4 text-center border-bottom border-primary border-opacity-10">
                        @if($app->user->studentProfile && $app->user->studentProfile->profile_image)
                            <img src="{{ asset('storage/' . $app->user->studentProfile->profile_image) }}" 
                                 class="rounded-circle shadow-sm border border-4 border-white mb-3" 
                                 style="width: 110px; height: 110px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm border border-4 border-white" 
                                 style="width: 110px; height: 110px;">
                                <i class="fas fa-user-graduate text-primary" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <h3 class="fw-bold mb-1 text-dark">{{ $app->user->name }}</h3>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <span class="badge bg-white text-dark shadow-sm py-2 px-3 border">
                                <i class="fas fa-envelope text-primary me-2"></i>{{ $app->user->email }}
                            </span>
                            @if($app->user->studentProfile && $app->user->studentProfile->location)
                            <span class="badge bg-white text-dark shadow-sm py-2 px-3 border">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $app->user->studentProfile->location }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="p-4">
                        <div class="row g-4 mb-4">
                            <!-- Education Info -->
                            <div class="col-md-6">
                                <div class="p-3 rounded-4 bg-light h-100">
                                    <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">Academic Information</h6>
                                    <div class="mb-3">
                                        <label class="text-muted small d-block">Education Level</label>
                                        <span class="fw-bold">{{ $app->user->education_level ?? $app->user->studentProfile->education_level ?? 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <label class="text-muted small d-block">Field of Study</label>
                                        <span class="fw-bold">{{ $app->user->field_of_study ?? $app->user->studentProfile->field_of_study ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Personal Info -->
                            <div class="col-md-6">
                                <div class="p-3 rounded-4 bg-light h-100">
                                    <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">Personal Details</h6>
                                    <div class="mb-3">
                                        <label class="text-muted small d-block">Age</label>
                                        <span class="fw-bold">{{ $app->user->studentProfile->age ?? 'N/A' }} Years</span>
                                    </div>
                                    <div>
                                        <label class="text-muted small d-block">Member Since</label>
                                        <span class="fw-bold">{{ $app->user->created_at->format('M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Skills -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-cogs me-2"></i>Professional Skills</h6>
                            @if($app->user->studentProfile && $app->user->studentProfile->skills)
                                @php
                                    $skills = $app->user->studentProfile->skills;
                                    if (is_string($skills) && (str_starts_with($skills, '[') || str_starts_with($skills, '{'))) {
                                        $skills = json_decode($skills, true);
                                    } elseif (is_string($skills)) {
                                        $skills = explode(',', $skills);
                                    }
                                @endphp
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($skills as $skill)
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 py-2 px-3">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted italic small">Skills not listed yet</p>
                            @endif
                        </div>

                        <!-- Interests -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-lightbulb me-2"></i>Areas of Interest</h6>
                            @php
                                $interests = $app->user->interests ?? ($app->user->studentProfile ? $app->user->studentProfile->interests : null);
                            @endphp
                            @if($interests)
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(explode(',', $interests) as $interest)
                                        <span class="badge bg-secondary bg-opacity-10 text-dark border border-dark border-opacity-10 py-2 px-3">
                                            {{ trim($interest) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted italic small">Interests not listed yet</p>
                            @endif
                        </div>

                        <!-- Resume Link -->
                        @if($app->user->resumes->count() > 0)
                        <div class="p-3 rounded-4 bg-success bg-opacity-5 border border-success border-opacity-20">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success rounded-circle p-2 me-3">
                                        <i class="fas fa-file-invoice text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Professional Resume</h6>
                                        <small class="text-muted">Updated Candidate CV</small>
                                    </div>
                                </div>
                                <a href="{{ route('student.resume.preview', $app->user->resumes->first()->id) }}" 
                                   target="_blank" class="btn btn-success btn-sm px-4">
                                    <i class="fas fa-external-link-alt me-2"></i>Open
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="p-3 rounded-4 bg-light border border-dashed text-center">
                            <small class="text-muted">No resume uploaded via CV Builder</small>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Action Footer -->
                <div class="modal-footer bg-light border-0 py-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                    <div class="btn-group gap-2">
                        <form method="POST" action="{{ route('organization.applications.update-status', $app->id) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" class="btn btn-success px-4" {{ $app->status === 'accepted' ? 'disabled' : '' }}>
                                <i class="fas fa-check-circle me-2"></i>Accept
                            </button>
                        </form>
                        <form method="POST" action="{{ route('organization.applications.update-status', $app->id) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger px-4" {{ $app->status === 'rejected' ? 'disabled' : '' }}>
                                <i class="fas fa-times-circle me-2"></i>Reject
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection