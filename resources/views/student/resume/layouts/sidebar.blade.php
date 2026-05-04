<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $student->name }} - Sidebar Resume</title>
    <style>
        @page {
            margin: 0;
            size: a4;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 0; 
            font-size: 11.5px; 
            background: #fff;
            color: #333;
        }
        .container { 
            width: 100%; 
            border-collapse: collapse; 
            display: table;
            table-layout: fixed;
            min-height: 100%;
        }
        .sidebar { 
            width: 30%; 
            background: #2c3e50; 
            color: white; 
            padding: 30px 20px; 
            vertical-align: top;
            height: 100%;
        }
        .main { 
            width: 70%; 
            padding: 40px 30px; 
            vertical-align: top;
        }
        .sidebar h2 { 
            color: #3498db; 
            border-bottom: 2px solid #3498db; 
            padding-bottom: 5px; 
            font-size: 14px; 
            text-transform: uppercase; 
            margin-top: 25px; 
        }
        .main h1 { 
            font-size: 28px; 
            margin-top: 0; 
            color: #2c3e50; 
            margin-bottom: 5px; 
            text-transform: uppercase;
        }
        .main h3 { 
            color: #3498db; 
            border-bottom: 1px solid #eee; 
            padding-bottom: 5px; 
            margin-top: 25px; 
            text-transform: uppercase; 
            font-size: 13px; 
        }
        .contact-item { margin-bottom: 12px; font-size: 11px; word-wrap: break-word; }
        .skill-list { list-style: none; padding: 0; margin-top: 10px; }
        .skill-list li { margin-bottom: 6px; font-size: 11px; border-left: 3px solid #3498db; padding-left: 8px; }
        .desc { color: #444; line-height: 1.4; white-space: pre-line; text-align: justify; }
        .item-title { font-weight: bold; font-size: 13px; margin-top: 12px; display: block; color: #2c3e50; }
        .item-subtitle { color: #3498db; font-weight: 500; font-style: italic; }
        .item-meta { color: #888; font-size: 10.5px; margin-bottom: 5px; }
        .experience-item, .project-item, .education-item { page-break-inside: avoid; }
    </style>
</head>
<body>
    @php 
        $experience = is_string($profile->experience) ? json_decode($profile->experience, true) : $profile->experience;
        $projects = is_string($profile->projects) ? json_decode($profile->projects, true) : $profile->projects;
        $education = is_string($profile->education) ? json_decode($profile->education, true) : $profile->education;
        $skills = is_string($profile->skills) ? json_decode($profile->skills, true) : $profile->skills;
        $langs = is_string($profile->languages) ? json_decode($profile->languages, true) : $profile->languages;
        $certs = is_string($profile->certifications) ? json_decode($profile->certifications, true) : $profile->certifications;
    @endphp

    <table class="container">
        <tr>
            <td class="sidebar">
                <h2 style="margin-top: 0;">CONTACT</h2>
                <div class="contact-item"><strong>Email:</strong><br>{{ $student->email }}</div>
                @if(isset($profile->phone) && $profile->phone) <div class="contact-item"><strong>Phone:</strong><br>{{ $profile->phone }}</div> @endif
                <div class="contact-item"><strong>Location:</strong><br>{{ $profile->location ?: 'Pakistan' }}</div>
                @if(isset($profile->dob) && $profile->dob) <div class="contact-item"><strong>DOB:</strong><br>{{ $profile->dob }}</div> @endif

                @if(is_array($skills) && count($skills) > 0)
                    <h2>SKILLS</h2>
                    <ul class="skill-list">
                        @foreach($skills as $skill) <li>{{ $skill }}</li> @endforeach
                    </ul>
                @endif

                @if(is_array($langs) && count($langs) > 0)
                    <h2>LANGUAGES</h2>
                    <ul class="skill-list">
                        @foreach($langs as $lang) <li>{{ $lang }}</li> @endforeach
                    </ul>
                @endif

                @if(isset($profile->linkedin) && $profile->linkedin)
                    <h2>SOCIAL</h2>
                    <div class="contact-item" style="font-size: 9px;"><strong>LinkedIn:</strong><br>{{ $profile->linkedin }}</div>
                @endif
            </td>

            <td class="main">
                <h1>{{ $student->name }}</h1>
                <p style="font-size: 14px; color: #3498db; margin-top: -5px; font-weight: bold;">{{ $profile->field_of_study ?: 'Professional' }}</p>

                <h3>PROFILE SUMMARY</h3>
                <div class="desc">{{ $custom_summary ?: 'A dedicated and motivated professional.' }}</div>

                @if(is_array($experience) && count($experience) > 0)
                    <h3>WORK EXPERIENCE</h3>
                    @foreach($experience as $exp)
                        @if(!empty($exp['job_title']))
                        <div class="experience-item">
                            <span class="item-title">{{ $exp['job_title'] }}</span>
                            <span class="item-subtitle">{{ $exp['company'] }}</span>
                            <div class="item-meta">{{ $exp['duration'] }}</div>
                            <div class="desc">{{ $exp['description'] }}</div>
                        </div>
                        @endif
                    @endforeach
                @endif

                @if(is_array($projects) && count($projects) > 0)
                    <h3>SELECTED PROJECTS</h3>
                    @foreach($projects as $proj)
                        @if(!empty($proj['title']))
                        <div class="project-item">
                            <span class="item-title">{{ $proj['title'] }}</span>
                            @if(!empty($proj['link'])) <div class="item-meta">{{ $proj['link'] }}</div> @endif
                            <div class="desc">{{ $proj['description'] }}</div>
                        </div>
                        @endif
                    @endforeach
                @endif

                <h3>EDUCATION</h3>
                @if(is_array($education) && count($education) > 0)
                    @foreach($education as $edu)
                        @if(!empty($edu['degree']))
                        <div class="education-item">
                            <span class="item-title">{{ $edu['degree'] }}</span>
                            <span class="item-subtitle">{{ $edu['school'] }}</span>
                            <div class="item-meta">{{ $edu['year'] }} | Result: {{ $edu['grade'] }}</div>
                        </div>
                        @endif
                    @endforeach
                @else
                    <div class="education-item">
                        <span class="item-title">{{ $profile->education_level ?: 'Higher Education' }}</span>
                        <div class="desc">Field: {{ $profile->field_of_study ?: 'General' }}</div>
                    </div>
                @endif

                @if(is_array($certs) && count($certs) > 0)
                    <h3>CERTIFICATIONS</h3>
                    @foreach($certs as $cert)
                        <div style="margin-bottom: 5px; font-size: 11px;">• {{ $cert }}</div>
                    @endforeach
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
