<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $student->name }} - Professional Resume</title>
    <style>
        @page {
            margin: 0;
            size: a4;
        }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            margin: 0; 
            padding: 0; 
            color: #333; 
            line-height: 1.4; 
            font-size: 12px; 
            background: #fff;
        }
        .header { 
            background-color: #002147; 
            color: white; 
            padding: 25px 40px; 
            text-align: left; 
        }
        .name { 
            font-size: 26px; 
            font-weight: bold; 
            margin-bottom: 5px; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
        }
        .title { 
            font-size: 15px; 
            color: #FFD700; 
            font-weight: bold; 
        }
        .contact-bar { 
            background: #f8f9fa; 
            padding: 8px 40px; 
            border-bottom: 1px solid #dee2e6;
            width: 100%;
        }
        .contact-item { 
            display: inline-block; 
            margin-right: 20px; 
            font-size: 11px;
        }
        .container { 
            width: 100%; 
            border-collapse: collapse; 
            display: table;
            table-layout: fixed;
        }
        .column { 
            display: table-cell; 
            vertical-align: top; 
            padding: 25px;
        }
        .sidebar { 
            width: 28%; 
            background-color: #fcfcfc;
            border-right: 1px solid #eee; 
            padding-left: 40px;
        }
        .main { 
            width: 72%; 
            padding-right: 40px;
            padding-left: 30px;
        }
        .section-title { 
            color: #002147; 
            font-size: 13px; 
            font-weight: bold; 
            border-bottom: 2px solid #FFD700; 
            margin-bottom: 12px; 
            margin-top: 15px; 
            padding-bottom: 2px; 
            text-transform: uppercase; 
        }
        .item-title { font-weight: bold; font-size: 13px; color: #002147; margin-top: 10px; }
        .item-subtitle { color: #555; font-weight: bold; font-style: italic; margin-bottom: 3px; }
        .item-meta { color: #777; font-size: 10.5px; margin-bottom: 5px; }
        
        .skill-tag { 
            display: inline-block; 
            background: #e3f2fd; 
            color: #002147; 
            padding: 2px 7px; 
            margin-right: 3px; 
            margin-bottom: 4px; 
            border-radius: 3px; 
            font-size: 10.5px; 
        }
        .desc { 
            margin-bottom: 10px; 
            white-space: pre-line; 
            text-align: justify; 
            font-size: 11.5px;
        }
        .experience-item, .project-item, .education-item {
            page-break-inside: avoid;
            margin-bottom: 15px;
        }
        ul { padding-left: 15px; margin-top: 5px; }
        li { margin-bottom: 2px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="name">{{ $student->name }}</div>
        <div class="title">{{ $profile->field_of_study ?: ($profile->education_level ?? 'Professional') }}</div>
    </div>
    
    <div class="contact-bar">
        <div class="contact-item"><strong>Email:</strong> {{ $student->email }}</div>
        @if(isset($profile->phone) && $profile->phone) <div class="contact-item"><strong>Phone:</strong> {{ $profile->phone }}</div> @endif
        @if(isset($profile->location) && $profile->location) <div class="contact-item"><strong>Location:</strong> {{ $profile->location }}</div> @endif
        @if(isset($profile->dob) && $profile->dob) <div class="contact-item"><strong>DOB:</strong> {{ $profile->dob }}</div> @endif
    </div>

    <table class="container">
        <tr>
            <td class="column sidebar">
                <div class="section-title">Skills</div>
                @php $skills = is_string($profile->skills) ? json_decode($profile->skills, true) : $profile->skills; @endphp
                @if(is_array($skills) && count($skills) > 0)
                    @foreach($skills as $skill)
                        <span class="skill-tag">{{ $skill }}</span>
                    @endforeach
                @else
                    <div class="item-meta">No skills listed</div>
                @endif

                @php $langs = is_string($profile->languages) ? json_decode($profile->languages, true) : $profile->languages; @endphp
                @if(is_array($langs) && count($langs) > 0)
                    <div class="section-title">Languages</div>
                    @foreach($langs as $lang)
                        <div style="font-size: 11px; margin-bottom: 3px;">• {{ $lang }}</div>
                    @endforeach
                @endif

                @php $certs = is_string($profile->certifications) ? json_decode($profile->certifications, true) : $profile->certifications; @endphp
                @if(is_array($certs) && count($certs) > 0)
                    <div class="section-title">Certifications</div>
                    @foreach($certs as $cert)
                        <div style="margin-bottom: 5px; font-size: 11px;">• {{ $cert }}</div>
                    @endforeach
                @endif

                <div class="section-title">Interests</div>
                <div class="desc" style="font-size: 11px;">{{ $profile->interests ?: 'Professional growth, networking' }}</div>
                
                @if(isset($profile->linkedin) && $profile->linkedin)
                    <div class="section-title">Social</div>
                    <div class="desc" style="font-size: 10px; word-wrap: break-word;"><strong>LinkedIn:</strong><br>{{ $profile->linkedin }}</div>
                @endif
                
                @if(isset($profile->portfolio) && $profile->portfolio)
                    <div class="section-title">Portfolio</div>
                    <div class="desc" style="font-size: 10px; word-wrap: break-word;">{{ $profile->portfolio }}</div>
                @endif
            </td>

            <td class="column main">
                <div class="section-title">Profile Summary</div>
                <div class="desc">{{ $custom_summary ?: 'A dedicated professional looking for new opportunities.' }}</div>

                @php $experience = is_string($profile->experience) ? json_decode($profile->experience, true) : $profile->experience; @endphp
                @if(is_array($experience) && count($experience) > 0)
                    <div class="section-title">Work Experience</div>
                    @foreach($experience as $exp)
                        @if(!empty($exp['job_title']))
                        <div class="experience-item">
                            <div class="item-title">{{ $exp['job_title'] }}</div>
                            <div class="item-subtitle">{{ $exp['company'] }}</div>
                            <div class="item-meta">{{ $exp['duration'] }}</div>
                            <div class="desc">{{ $exp['description'] }}</div>
                        </div>
                        @endif
                    @endforeach
                @endif

                @php $projects = is_string($profile->projects) ? json_decode($profile->projects, true) : $profile->projects; @endphp
                @if(is_array($projects) && count($projects) > 0)
                    <div class="section-title">Projects</div>
                    @foreach($projects as $proj)
                        @if(!empty($proj['title']))
                        <div class="project-item">
                            <div class="item-title">{{ $proj['title'] }}</div>
                            @if(!empty($proj['link'])) <div class="item-meta">Link: {{ $proj['link'] }}</div> @endif
                            <div class="desc">{{ $proj['description'] }}</div>
                        </div>
                        @endif
                    @endforeach
                @endif

                <div class="section-title">Education</div>
                @php $education = is_string($profile->education) ? json_decode($profile->education, true) : $profile->education; @endphp
                @if(is_array($education) && count($education) > 0)
                    @foreach($education as $edu)
                        @if(!empty($edu['degree']))
                        <div class="education-item">
                            <div class="item-title">{{ $edu['degree'] }}</div>
                            <div class="item-subtitle">{{ $edu['school'] }}</div>
                            <div class="item-meta">{{ $edu['year'] }} | Grade: {{ $edu['grade'] }}</div>
                        </div>
                        @endif
                    @endforeach
                @else
                    <div class="education-item">
                        <div class="item-title">{{ $profile->education_level ?: 'Higher Education' }}</div>
                        <div class="item-subtitle">{{ $profile->field_of_study ?: 'General Studies' }}</div>
                    </div>
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
