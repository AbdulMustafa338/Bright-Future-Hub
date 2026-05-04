@extends('layouts.dashboard')

@section('title', 'Editor - ' . $resume->resume_name)

@section('content')
<div class="row h-100">
    <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('student.resume.index') }}">CV Maker</a></li>
                    <li class="breadcrumb-item active">Professional Editor</li>
                </ol>
            </nav>
            <h3 class="fw-bold m-0" id="display-resume-name">{{ $resume->resume_name }}</h3>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary" id="save-status" disabled>
                <i class="fas fa-check me-1"></i> Saved
            </button>
            <a href="{{ route('student.resume.download', $resume->id) }}" class="btn btn-success">
                <i class="fas fa-download me-2"></i> Download PDF
            </a>
        </div>
    </div>

    <!-- Editor Column -->
    <div class="col-lg-6 mb-4" style="max-height: calc(100vh - 180px); overflow-y: auto; padding-right: 15px;">
        <div class="glass-card p-4">
            <form id="resume-editor-form">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-bold">Resume Version Name</label>
                    <input type="text" name="resume_name" class="form-control" value="{{ $resume->resume_name }}" placeholder="e.g. Frontend Dev Resume">
                </div>

                <div class="accordion" id="resumeAccordion">
                    
                    <!-- 1. Personal Details -->
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePersonal">
                                <i class="fas fa-user-circle text-primary me-2"></i> Personal & Contact Info
                            </button>
                        </h2>
                        <div id="collapsePersonal" class="accordion-collapse collapse show" data-bs-parent="#resumeAccordion">
                            <div class="accordion-body bg-light">
                                @php $data = $resume->resume_data; @endphp
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Full Name</label>
                                        <input type="text" name="resume_data[name]" class="form-control" value="{{ $data['name'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Job Title / Tagline</label>
                                        <input type="text" name="resume_data[field_of_study]" class="form-control" value="{{ $data['field_of_study'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Email</label>
                                        <input type="email" name="resume_data[email]" class="form-control" value="{{ $data['email'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Phone Number</label>
                                        <input type="text" name="resume_data[phone]" class="form-control" value="{{ $data['phone'] ?? '' }}" placeholder="+92 3xx xxxxxxx">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Date of Birth</label>
                                        <input type="date" name="resume_data[dob]" class="form-control" value="{{ $data['dob'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Location</label>
                                        <input type="text" name="resume_data[location]" class="form-control" value="{{ $data['location'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">LinkedIn URL</label>
                                        <input type="text" name="resume_data[linkedin]" class="form-control" value="{{ $data['linkedin'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Portfolio / Web</label>
                                        <input type="text" name="resume_data[portfolio]" class="form-control" value="{{ $data['portfolio'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Summary & Objective -->
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSummary">
                                <i class="fas fa-file-alt text-primary me-2"></i> Professional Summary
                            </button>
                        </h2>
                        <div id="collapseSummary" class="accordion-collapse collapse" data-bs-parent="#resumeAccordion">
                            <div class="accordion-body bg-light">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Professional Summary</label>
                                    <textarea name="resume_data[summary]" class="form-control" rows="3">{{ $data['summary'] ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Career Objective</label>
                                    <textarea name="resume_data[objective]" class="form-control" rows="2">{{ $data['objective'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Experience -->
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExperience">
                                <i class="fas fa-briefcase text-primary me-2"></i> Work Experience
                            </button>
                        </h2>
                        <div id="collapseExperience" class="accordion-collapse collapse" data-bs-parent="#resumeAccordion">
                            <div class="accordion-body bg-light">
                                <div id="experience-list">
                                    @foreach($data['experience'] ?? [] as $index => $exp)
                                    <div class="experience-item bg-white p-3 border rounded mb-3 position-relative">
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-item"></button>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label small fw-bold">Job Title</label>
                                                <input type="text" name="resume_data[experience][{{$index}}][job_title]" class="form-control form-control-sm" value="{{ $exp['job_title'] ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label small fw-bold">Company</label>
                                                <input type="text" name="resume_data[experience][{{$index}}][company]" class="form-control form-control-sm" value="{{ $exp['company'] ?? '' }}">
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label class="form-label small fw-bold">Duration (e.g. 2021 - Present)</label>
                                                <input type="text" name="resume_data[experience][{{$index}}][duration]" class="form-control form-control-sm" value="{{ $exp['duration'] ?? '' }}">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label small fw-bold">Description</label>
                                                <textarea name="resume_data[experience][{{$index}}][description]" class="form-control form-control-sm" rows="2">{{ $exp['description'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm w-100" id="add-experience">
                                    <i class="fas fa-plus me-1"></i> Add Experience
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Projects -->
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProjects">
                                <i class="fas fa-project-diagram text-primary me-2"></i> Key Projects
                            </button>
                        </h2>
                        <div id="collapseProjects" class="accordion-collapse collapse" data-bs-parent="#resumeAccordion">
                            <div class="accordion-body bg-light">
                                <div id="projects-list">
                                    @foreach($data['projects'] ?? [] as $index => $proj)
                                    <div class="project-item bg-white p-3 border rounded mb-3 position-relative">
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-item"></button>
                                        <div class="mb-2">
                                            <label class="form-label small fw-bold">Project Title</label>
                                            <input type="text" name="resume_data[projects][{{$index}}][title]" class="form-control form-control-sm" value="{{ $proj['title'] ?? '' }}">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small fw-bold">Link (optional)</label>
                                            <input type="text" name="resume_data[projects][{{$index}}][link]" class="form-control form-control-sm" value="{{ $proj['link'] ?? '' }}">
                                        </div>
                                        <div>
                                            <label class="form-label small fw-bold">Description</label>
                                            <textarea name="resume_data[projects][{{$index}}][description]" class="form-control form-control-sm" rows="2">{{ $proj['description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm w-100" id="add-project">
                                    <i class="fas fa-plus me-1"></i> Add Project
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Education -->
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEducation">
                                <i class="fas fa-graduation-cap text-primary me-2"></i> Education
                            </button>
                        </h2>
                        <div id="collapseEducation" class="accordion-collapse collapse" data-bs-parent="#resumeAccordion">
                            <div class="accordion-body bg-light">
                                <div id="education-list">
                                    @foreach($data['education'] ?? [] as $index => $edu)
                                    <div class="education-item bg-white p-3 border rounded mb-3 position-relative">
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-item"></button>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label small fw-bold">Degree / Certificate</label>
                                                <input type="text" name="resume_data[education][{{$index}}][degree]" class="form-control form-control-sm" value="{{ $edu['degree'] ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label small fw-bold">Institution</label>
                                                <input type="text" name="resume_data[education][{{$index}}][school]" class="form-control form-control-sm" value="{{ $edu['school'] ?? '' }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">Year</label>
                                                <input type="text" name="resume_data[education][{{$index}}][year]" class="form-control form-control-sm" value="{{ $edu['year'] ?? '' }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">Grade / GPA</label>
                                                <input type="text" name="resume_data[education][{{$index}}][grade]" class="form-control form-control-sm" value="{{ $edu['grade'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm w-100" id="add-education">
                                    <i class="fas fa-plus me-1"></i> Add Education
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Skills, Languages, Certs -->
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExtras">
                                <i class="fas fa-star text-primary me-2"></i> Skills, Languages & Certs
                            </button>
                        </h2>
                        <div id="collapseExtras" class="accordion-collapse collapse" data-bs-parent="#resumeAccordion">
                            <div class="accordion-body bg-light">
                                <!-- Skills (Simplified tag input logic) -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold small">Skills</label>
                                    <input type="text" id="skill-input" class="form-control form-control-sm mb-2" placeholder="Press Enter to add skill">
                                    <div id="skills-container" class="d-flex flex-wrap gap-1">
                                        @foreach($data['skills'] ?? [] as $skill)
                                            <span class="badge bg-primary d-flex align-items-center p-2">
                                                {{ $skill }}
                                                <input type="hidden" name="resume_data[skills][]" value="{{ $skill }}">
                                                <i class="fas fa-times ms-2 cursor-pointer remove-tag"></i>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Languages -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold small">Languages</label>
                                    <input type="text" id="lang-input" class="form-control form-control-sm mb-2" placeholder="Press Enter to add language">
                                    <div id="langs-container" class="d-flex flex-wrap gap-1">
                                        @foreach($data['languages'] ?? [] as $lang)
                                            <span class="badge bg-info d-flex align-items-center p-2">
                                                {{ $lang }}
                                                <input type="hidden" name="resume_data[languages][]" value="{{ $lang }}">
                                                <i class="fas fa-times ms-2 cursor-pointer remove-tag"></i>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Certifications -->
                                <div class="mb-2">
                                    <label class="form-label fw-bold small">Certifications</label>
                                    <input type="text" id="cert-input" class="form-control form-control-sm mb-2" placeholder="Press Enter to add certification">
                                    <div id="certs-container" class="d-flex flex-wrap gap-1">
                                        @foreach($data['certifications'] ?? [] as $cert)
                                            <span class="badge bg-secondary d-flex align-items-center p-2">
                                                {{ $cert }}
                                                <input type="hidden" name="resume_data[certifications][]" value="{{ $cert }}">
                                                <i class="fas fa-times ms-2 cursor-pointer remove-tag"></i>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Preview Column -->
    <div class="col-lg-6 mb-4">
        <div class="sticky-top" style="top: 20px;">
            <div class="d-flex justify-content-between mb-2">
                <span class="fw-bold"><i class="fas fa-desktop me-2"></i>Live Preview</span>
                <span class="text-muted small">Automatic update on change</span>
            </div>
            <div class="glass-card shadow-lg bg-white overflow-hidden" style="height: calc(100vh - 220px); border: 1px solid #ddd;">
                <iframe id="preview-iframe" src="{{ route('student.resume.preview', $resume->id) }}" class="w-100 h-100 border-0"></iframe>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .accordion-button:not(.collapsed) { background-color: #f8f9fa; color: var(--primary-color); box-shadow: none; }
    .remove-item { z-index: 10; width: 0.5em; height: 0.5em; }
    .experience-item, .project-item, .education-item { transition: all 0.2s; }
    .experience-item:hover, .project-item:hover, .education-item:hover { border-color: var(--primary-color) !important; }
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const form = $('#resume-editor-form');
    const iframe = document.getElementById('preview-iframe');
    const saveStatus = $('#save-status');

    // Tag Input Helper
    function handleTagInput(inputId, containerId, fieldName, badgeClass) {
        $(`#${inputId}`).keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                const val = $(this).val().trim();
                if (val) {
                    const tag = `
                        <span class="badge ${badgeClass} d-flex align-items-center p-2">
                            ${val}
                            <input type="hidden" name="resume_data[${fieldName}][]" value="${val}">
                            <i class="fas fa-times ms-2 cursor-pointer remove-tag"></i>
                        </span>
                    `;
                    $(`#${containerId}`).append(tag);
                    $(this).val('');
                    triggerAutoSave();
                }
            }
        });
    }

    handleTagInput('skill-input', 'skills-container', 'skills', 'bg-primary');
    handleTagInput('lang-input', 'langs-container', 'languages', 'bg-info');
    handleTagInput('cert-input', 'certs-container', 'certifications', 'bg-secondary');

    $(document).on('click', '.remove-tag', function() {
        $(this).parent().remove();
        triggerAutoSave();
    });

    // Dynamic List Helper
    let expCount = {{ count($data['experience'] ?? [0]) }};
    $('#add-experience').click(function() {
        const index = expCount++;
        const html = `
            <div class="experience-item bg-white p-3 border rounded mb-3 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-item"></button>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold">Job Title</label>
                        <input type="text" name="resume_data[experience][${index}][job_title]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold">Company</label>
                        <input type="text" name="resume_data[experience][${index}][company]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label small fw-bold">Duration</label>
                        <input type="text" name="resume_data[experience][${index}][duration]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Description</label>
                        <textarea name="resume_data[experience][${index}][description]" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                </div>
            </div>`;
        $('#experience-list').append(html);
        triggerAutoSave();
    });

    let projCount = {{ count($data['projects'] ?? [0]) }};
    $('#add-project').click(function() {
        const index = projCount++;
        const html = `
            <div class="project-item bg-white p-3 border rounded mb-3 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-item"></button>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Project Title</label>
                    <input type="text" name="resume_data[projects][${index}][title]" class="form-control form-control-sm">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Link (optional)</label>
                    <input type="text" name="resume_data[projects][${index}][link]" class="form-control form-control-sm">
                </div>
                <div>
                    <label class="form-label small fw-bold">Description</label>
                    <textarea name="resume_data[projects][${index}][description]" class="form-control form-control-sm" rows="2"></textarea>
                </div>
            </div>`;
        $('#projects-list').append(html);
        triggerAutoSave();
    });

    let eduCount = {{ count($data['education'] ?? [0]) }};
    $('#add-education').click(function() {
        const index = eduCount++;
        const html = `
            <div class="education-item bg-white p-3 border rounded mb-3 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-item"></button>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold">Degree</label>
                        <input type="text" name="resume_data[education][${index}][degree]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold">Institution</label>
                        <input type="text" name="resume_data[education][${index}][school]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Year</label>
                        <input type="text" name="resume_data[education][${index}][year]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Grade</label>
                        <input type="text" name="resume_data[education][${index}][grade]" class="form-control form-control-sm">
                    </div>
                </div>
            </div>`;
        $('#education-list').append(html);
        triggerAutoSave();
    });

    $(document).on('click', '.remove-item', function() {
        $(this).closest('div').remove();
        triggerAutoSave();
    });

    // Auto-save logic
    let timeout = null;
    function triggerAutoSave() {
        saveStatus.html('<i class="fas fa-spinner fa-spin me-1"></i> Saving...').prop('disabled', true);
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            saveData();
        }, 1200);
    }

    function saveData() {
        $.ajax({
            url: '{{ route('student.resume.update', $resume->id) }}',
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                saveStatus.html('<i class="fas fa-check me-1"></i> Saved').prop('disabled', true);
                iframe.contentWindow.location.reload();
            }
        });
    }

    form.on('input change', 'input, textarea', function() {
        triggerAutoSave();
    });
});
</script>
@endsection
