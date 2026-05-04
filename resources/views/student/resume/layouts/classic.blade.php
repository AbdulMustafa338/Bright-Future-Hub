<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $student->name }} - Classic Resume</title>
    <style>
        @page {
            margin: 40px;
            size: a4;
        }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            color: #000; 
            line-height: 1.3; 
            margin: 0;
            padding: 0;
            font-size: 11.5px; 
            background: #fff;
        }
        .text-center { text-align: center; }
        .name { 
            font-size: 22px; 
            font-weight: bold; 
            border-bottom: 2px solid #000; 
            margin-bottom: 5px; 
            padding-bottom: 5px;
        }
        .contact { font-size: 10.5px; margin-bottom: 15px; }
        .section-header { 
            font-size: 12px; 
            font-weight: bold; 
            background: #f4f4f4; 
            padding: 4px 8px; 
            margin-top: 12px; 
            border-bottom: 1px solid #000; 
            text-transform: uppercase; 
        }
        .item { margin-top: 8px; margin-bottom: 8px; page-break-inside: avoid; }
        .item-title { font-weight: bold; font-size: 12px; }
        .item-subtitle { font-style: italic; }
        .item-date { text-align: right; font-style: italic; font-size: 10.5px; }
        .skills-list { margin-top: 5px; font-size: 11px; }
        .desc { margin-top: 3px; white-space: pre-line; text-align: justify; }
        .table-full { width: 100%; border-collapse: collapse; }
    </style>
</head>
<body>
    <div class="text-center">
        <div class="name">{{ strtoupper($student->name) }}</div>
        <div class="contact">
            {{ $profile->location ?: 'Pakistan' }} | {{ $student->email }}
            @if(isset($profile->phone) && $profile->phone) | {{ $profile->phone }} @endif
            @if(isset($profile->linkedin) && $profile->linkedin) | LinkedIn: {{ $profile->linkedin }} @endif
        </div>
    </div>

    @if($custom_objective)
        <div class="section-header">Career Objective</div>
        <div class="desc">{{ $custom_objective }}</div>
    @endif

    @if($custom_summary)
        <div class="section-header">Professional Summary</div>
        <div class="desc">{{ $custom_summary }}</div>
    @endif

    @php 
        $experience = is_string($profile->experience) ? json_decode($profile->experience, true) : $profile->experience;
        $projects = is_string($profile->projects) ? json_decode($profile->projects, true) : $profile->projects;
        $education = is_string($profile->education) ? json_decode($profile->education, true) : $profile->education;
        $skills = is_string($profile->skills) ? json_decode($profile->skills, true) : $profile->skills;
        $langs = is_string($profile->languages) ? json_decode($profile->languages, true) : $profile->languages;
        $certs = is_string($profile->certifications) ? json_decode($profile->certifications, true) : $profile->certifications;
    @endphp

    @if(is_array($experience) && count($experience) > 0)
        <div class="section-header">Work Experience</div>
        @foreach($experience as $exp)
            @if(!empty($exp['job_title']))
            <div class="item">
                <table class="table-full">
                    <tr>
                        <td style="text-align: left;"><span class="item-title">{{ $exp['job_title'] }}</span>, <span class="item-subtitle">{{ $exp['company'] }}</span></td>
                        <td style="text-align: right;"><span class="item-date">{{ $exp['duration'] }}</span></td>
                    </tr>
                </table>
                <div class="desc">{{ $exp['description'] }}</div>
            </div>
            @endif
        @endforeach
    @endif

    @if(is_array($projects) && count($projects) > 0)
        <div class="section-header">Projects</div>
        @foreach($projects as $proj)
            @if(!empty($proj['title']))
            <div class="item">
                <span class="item-title">{{ $proj['title'] }}</span> @if(!empty($proj['link'])) | <i>{{ $proj['link'] }}</i> @endif
                <div class="desc">{{ $proj['description'] }}</div>
            </div>
            @endif
        @endforeach
    @endif

    <div class="section-header">Education</div>
    @if(is_array($education) && count($education) > 0)
        @foreach($education as $edu)
            @if(!empty($edu['degree']))
            <div class="item">
                <table class="table-full">
                    <tr>
                        <td style="text-align: left;"><span class="item-title">{{ $edu['degree'] }}</span>, <span class="item-subtitle">{{ $edu['school'] }}</span></td>
                        <td style="text-align: right;"><span class="item-date">{{ $edu['year'] }}</span></td>
                    </tr>
                </table>
                <div class="desc">Result/Grade: {{ $edu['grade'] }}</div>
            </div>
            @endif
        @endforeach
    @else
        <div class="item">
            <span class="item-title">{{ $profile->education_level ?: 'Higher Education' }}</span>
            <div class="item-subtitle">Field of Study: {{ $profile->field_of_study ?: 'General' }}</div>
        </div>
    @endif

    <div class="section-header">Skills & Qualifications</div>
    @if(is_array($skills) && count($skills) > 0)
    <div class="skills-list">
        <strong>Technical Skills:</strong> {{ implode(', ', $skills) }}
    </div>
    @endif
    
    @if(is_array($langs) && count($langs) > 0)
    <div class="skills-list">
        <strong>Languages:</strong> {{ implode(', ', $langs) }}
    </div>
    @endif
    
    @if(is_array($certs) && count($certs) > 0)
    <div class="skills-list">
        <strong>Certifications:</strong> {{ implode(', ', $certs) }}
    </div>
    @endif

    @if($profile->interests)
    <div class="section-header">Interests</div>
    <div class="desc">{{ $profile->interests }}</div>
    @endif
</body>
</html>
