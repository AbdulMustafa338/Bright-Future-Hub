@extends('layouts.dashboard')

@section('title', 'CV Maker - My Resumes')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-primary">CV Maker</h2>
                <p class="text-muted">Create multiple professional resumes and customize them for different jobs.</p>
            </div>
            <a href="#layouts-gallery" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Create New Resume
            </a>
        </div>
    </div>
</div>

<!-- Saved Resumes -->
@if($resumes->count() > 0)
<div class="row mb-5">
    <div class="col-12 mb-3">
        <h4 class="fw-bold">My Saved Resumes</h4>
    </div>
    @foreach($resumes as $resume)
    <div class="col-md-4 mb-4">
        <div class="glass-card p-4 d-flex flex-column h-100 border-top-0 border-end-0 border-bottom-0" style="border-left: 5px solid var(--primary-color);">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h5 class="fw-bold m-0">{{ $resume->resume_name }}</h5>
                <span class="badge bg-light text-primary border">{{ ucfirst($resume->layout_name) }}</span>
            </div>
            <p class="text-muted small mb-4">Last edited: {{ $resume->updated_at->diffForHumans() }}</p>
            <div class="d-grid gap-2 mt-auto">
                <a href="{{ route('student.resume.edit', $resume->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit me-1"></i> Edit & Preview
                </a>
                <a href="{{ route('student.resume.download', $resume->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-download me-1"></i> Download PDF
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- Layouts Gallery -->
<div class="row" id="layouts-gallery">
    <div class="col-12 mb-3">
        <h4 class="fw-bold">Choose a Layout to Start</h4>
    </div>
    @foreach($layouts as $layout)
    <div class="col-md-4 mb-4">
        <div class="glass-card h-100 overflow-hidden d-flex flex-column">
            <div class="layout-preview position-relative" style="height: 350px; background: #e0e6ed; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-file-invoice fa-5x text-white opacity-50"></i>
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25 opacity-0 hover-opacity-100 transition-all">
                    <a href="{{ route('student.resume.create', $layout['id']) }}" class="btn btn-light">
                        <i class="fas fa-plus-circle me-1"></i> Select Layout
                    </a>
                </div>
            </div>
            <div class="p-4 flex-grow-1">
                <h5 class="fw-bold">{{ $layout['name'] }}</h5>
                <p class="text-secondary small">{{ $layout['desc'] }}</p>
                <div class="d-grid gap-2 mt-auto">
                    <a href="{{ route('student.resume.create', $layout['id']) }}" class="btn btn-primary">
                        <i class="fas fa-magic me-2"></i> Use Template
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
    .hover-opacity-100:hover { opacity: 1 !important; }
    .transition-all { transition: all 0.3s ease; }
    .glass-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .glass-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .layout-preview { background: linear-gradient(45deg, #002147, #003366) !important; }
</style>
@endsection
