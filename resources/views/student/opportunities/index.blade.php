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
    <div class="row g-4" id="opportunities-container">
        @include('student.opportunities.partials.list', ['opportunities' => $opportunities])
    </div>

    <!-- Pagination -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $opportunities->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection