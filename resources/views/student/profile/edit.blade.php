@extends('layouts.dashboard')

@section('title', 'Edit Student Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold mb-1">Edit Your Profile</h3>
                        <p class="text-muted mb-0">Keep your information up to date</p>
                    </div>
                    <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Full Name</label>
                        <input type="text" class="form-control form-control-lg" id="name" value="{{ $user->name }}"
                            disabled>
                        <small class="text-muted">Contact admin to change your name</small>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Email Address</label>
                        <input type="email" class="form-control form-control-lg" id="email" value="{{ $user->email }}"
                            disabled>
                        <small class="text-muted">Contact admin to change your email</small>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label for="profile_image" class="form-label fw-bold">Profile Image</label>
                        <input class="form-control @error('profile_image') is-invalid @enderror" type="file" id="profile_image" name="profile_image" accept="image/jpeg,image/png,image/gif">
                        @if($profile && $profile->profile_image)
                            <div class="mt-2"><img src="{{ asset('storage/' . $profile->profile_image) }}" alt="Current Image" style="width: 80px; height: 80px; object-fit: cover;" class="rounded-circle shadow-sm"></div>
                            <div class="mt-1 text-muted small">Current image. Uploading a new one will replace it.</div>
                        @else
                            <div class="mt-1 text-muted small">Upload a clear photo (max 2MB, JPEG/PNG).</div>
                        @endif
                        @error('profile_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="age" class="form-label fw-bold">Age <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age"
                                value="{{ old('age', $profile->age ?? '') }}" placeholder="e.g., 22" required>
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label fw-bold">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location"
                                value="{{ old('location', $profile->location ?? '') }}" placeholder="e.g., Karachi, Pakistan" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="field_of_study" class="form-label fw-bold">Field of Study</label>
                        <input type="text" class="form-control @error('field_of_study') is-invalid @enderror"
                            id="field_of_study" name="field_of_study"
                            value="{{ old('field_of_study', $user->field_of_study ?? '') }}"
                            placeholder="e.g., Computer Science, Business Administration">
                        @error('field_of_study')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="education_level" class="form-label fw-bold">Education Level</label>
                        <select class="form-select @error('education_level') is-invalid @enderror" id="education_level"
                            name="education_level">
                            <option value="">Select your education level</option>
                            <option value="High School" {{ old('education_level', $user->education_level ?? '') == 'High School' ? 'selected' : '' }}>High School</option>
                            <option value="Undergraduate" {{ old('education_level', $user->education_level ?? '') == 'Undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                            <option value="Graduate" {{ old('education_level', $user->education_level ?? '') == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                            <option value="Postgraduate" {{ old('education_level', $user->education_level ?? '') == 'Postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                            <option value="PhD" {{ old('education_level', $user->education_level ?? '') == 'PhD' ? 'selected' : '' }}>PhD</option>
                        </select>
                        @error('education_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Skills & Interests <span class="text-danger">*</span></label>
                        <p class="text-muted small mb-3">Select your technical and soft skills, as well as your fields of interest.</p>
                        
                        @php
                            // Massive list of predefined skills
                            $predefinedSkills = [
                                'Software Engineering', 'PHP', 'Laravel', 'Python', 'JavaScript', 'React', 'Vue.js', 'Node.js', 'Java', 'C++', 'C#', 'SQL', 'NoSQL', 'MongoDB', 'Angular', 'TypeScript', 'Ruby', 'Go', 'Rust', 'Swift', 'Kotlin', 'Dart', 'Flutter', 'React Native',
                                'Machine Learning', 'Data Science', 'Artificial Intelligence', 'Deep Learning', 'NLP', 'Computer Vision',
                                'Cybersecurity', 'Ethical Hacking', 'Network Security', 'Cryptography',
                                'Cloud Computing', 'AWS', 'Azure', 'Google Cloud (GCP)', 'DevOps', 'Docker', 'Kubernetes', 'CI/CD', 'Jenkins',
                                'Web Development', 'Mobile App Development', 'Game Development', 'Unity', 'Unreal Engine',
                                'Business Administration', 'Marketing', 'Digital Marketing', 'SEO', 'SEM', 'Social Media Management', 'Sales', 'Finance', 'Accounting', 'Human Resources', 'Supply Chain Management', 'Logistics',
                                'Project Management', 'Agile/Scrum', 'Leadership', 'Communication', 'Public Speaking', 'Problem Solving', 'Teamwork', 'Critical Thinking', 'Time Management', 'Negotiation',
                                'UI/UX Design', 'Graphic Design', 'Figma', 'Adobe XD', 'Photoshop', 'Illustrator', 'Video Editing', 'Premiere Pro', 'After Effects', 'Content Creation', 'Copywriting', 'Blogging',
                                'Mechanical Engineering', 'Electrical Engineering', 'Civil Engineering', 'Robotics', 'IoT', 'CAD', 'AutoCAD', 'SolidWorks',
                                'Data Analysis', 'Tableau', 'Power BI', 'Excel', 'Statistics', 'R', 'MATLAB',
                                'Healthcare', 'Nursing', 'Pharmacy', 'Biotechnology', 'Environmental Science', 'Psychology', 'Sociology'
                            ];
                            sort($predefinedSkills);
                            
                            $userSkills = [];
                            if(isset($profile->skills)) {
                                $jsonDecoded = json_decode($profile->skills, true);
                                if(json_last_error() === JSON_ERROR_NONE && is_array($jsonDecoded)) {
                                    $userSkills = $jsonDecoded;
                                } else {
                                    $userSkills = array_map('trim', explode(',', $profile->skills));
                                }
                            }
                            
                            // Find custom skills (those not in the predefined list) so we can populate the text box
                            $customSkills = array_diff($userSkills, $predefinedSkills);
                            $customSkillsString = implode(', ', $customSkills);
                        @endphp
                        
                        <div class="row g-2 mb-3" style="max-height: 300px; overflow-y: auto; border: 1px solid #ced4da; padding: 15px; border-radius: 8px; background-color: #f8f9fa;">
                            @foreach($predefinedSkills as $skill)
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skills[]" value="{{ $skill }}" id="skill_{{ md5($skill) }}" {{ in_array($skill, $userSkills) ? 'checked' : '' }}>
                                        <label class="form-check-label" style="font-size: 0.9rem; cursor: pointer;" for="skill_{{ md5($skill) }}">
                                            {{ $skill }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-3">
                            <label for="custom_skills" class="form-label fw-bold small text-secondary">Other Skills/Interests (Comma Separated)</label>
                            <input type="text" class="form-control form-control-lg @error('custom_skills') is-invalid @enderror" id="custom_skills" name="custom_skills"
                                value="{{ old('custom_skills', $customSkillsString) }}" placeholder="e.g., Quantum Computing, Origami">
                            <small class="text-muted">Can't find your skill? Add it here.</small>
                            @error('custom_skills')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @error('skills')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                        <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection