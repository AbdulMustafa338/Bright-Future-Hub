<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use App\Models\Opportunity;
use App\Models\Resume;
use App\Services\RecommendationService;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    protected $recommendationService;
    protected $geminiService;

    public function __construct(RecommendationService $recommendationService, GeminiService $geminiService)
    {
        $this->recommendationService = $recommendationService;
        $this->geminiService = $geminiService;
    }

    /**
     * Show the Resume Builder Gallery (Layout selection) and Saved Resumes
     */
    public function index()
    {
        $student = Auth::user();
        
        // Ensure student profile exists
        if (!$student->studentProfile) {
            return redirect()->route('student.profile.edit')->with('error', 'Please complete your profile first to build a CV.');
        }

        $resumes = Resume::where('user_id', $student->id)->latest()->get();

        $layouts = [
            [
                'id' => 'modern',
                'name' => 'Modern Blue',
                'desc' => 'Vibrant, dual-column design for modern roles.',
                'image' => asset('images/layouts/modern.png') // We'll manage these later
            ],
            [
                'id' => 'classic',
                'name' => 'Classic Professional',
                'desc' => 'Traditional, academic look for formal applications.',
                'image' => asset('images/layouts/classic.png')
            ],
            [
                'id' => 'sidebar',
                'name' => 'Clean Sidebar',
                'desc' => 'Minimalist design with a colored sidebar.',
                'image' => asset('images/layouts/sidebar.png')
            ]
        ];

        return view('student.resume.index', compact('layouts', 'resumes'));
    }

    /**
     * Initialize a new resume from profile data and redirect to editor
     */
    public function create($layout)
    {
        $student = Auth::user();
        $profile = $student->studentProfile;

        if (!in_array($layout, ['modern', 'classic', 'sidebar'])) {
            abort(404);
        }

        $skills = $profile->skills ? json_decode($profile->skills, true) : [];
        if (!is_array($skills)) $skills = [];

        $resumeData = [
            'name' => $student->name,
            'email' => $student->email,
            'phone' => $profile->phone ?? '', // If added to profile later
            'dob' => $profile->dob ?? '',
            'field_of_study' => $profile->field_of_study,
            'education_level' => $profile->education_level,
            'location' => $profile->location,
            'linkedin' => '',
            'portfolio' => '',
            'skills' => $skills,
            'interests' => $profile->interests,
            'summary' => "A dedicated and motivated " . ($profile->field_of_study ?? 'student') . " located in " . ($profile->location ?? 'Pakistan') . ".",
            'objective' => "To secure a challenging position that allows me to utilize my skills and contribute to the growth of a dynamic organization.",
            'experience' => [
                ['job_title' => '', 'company' => '', 'duration' => '', 'description' => '']
            ],
            'projects' => [
                ['title' => '', 'link' => '', 'description' => '']
            ],
            'education' => [
                ['degree' => $profile->education_level ?? '', 'school' => '', 'year' => '', 'grade' => '']
            ],
            'languages' => [],
            'certifications' => []
        ];

        $resume = Resume::create([
            'user_id' => $student->id,
            'layout_name' => $layout,
            'resume_name' => 'Resume - ' . ucfirst($layout) . ' - ' . now()->format('M d'),
            'resume_data' => $resumeData
        ]);

        return redirect()->route('student.resume.edit', $resume->id);
    }

    /**
     * Show the Resume Editor
     */
    public function edit($id)
    {
        $resume = Resume::where('user_id', Auth::id())->findOrFail($id);
        return view('student.resume.edit', compact('resume'));
    }

    /**
     * Update the saved resume data
     */
    public function update(Request $request, $id)
    {
        $resume = Resume::where('user_id', Auth::id())->findOrFail($id);
        
        $resume->update([
            'resume_name' => $request->resume_name,
            'resume_data' => $request->resume_data
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Resume updated successfully!');
    }

    /**
     * Preview the CV (for the editor iframe)
     */
    public function preview($id)
    {
        $resume = Resume::where('user_id', Auth::id())->findOrFail($id);
        $student = Auth::user();
        $data = $resume->resume_data;
        $layout = $resume->layout_name;

        return view('student.resume.layouts.' . $layout, [
            'student' => (object) ['name' => $data['name'] ?? '', 'email' => $data['email'] ?? ''],
            'profile' => (object) [
                'field_of_study' => $data['field_of_study'] ?? '',
                'education_level' => $data['education_level'] ?? '',
                'location' => $data['location'] ?? '',
                'interests' => $data['interests'] ?? '',
                'skills' => json_encode($data['skills'] ?? []),
                'phone' => $data['phone'] ?? '',
                'dob' => $data['dob'] ?? '',
                'linkedin' => $data['linkedin'] ?? '',
                'portfolio' => $data['portfolio'] ?? '',
                'experience' => json_encode($data['experience'] ?? []),
                'projects' => json_encode($data['projects'] ?? []),
                'education' => json_encode($data['education'] ?? []),
                'languages' => json_encode($data['languages'] ?? []),
                'certifications' => json_encode($data['certifications'] ?? []),
            ],
            'custom_summary' => $data['summary'] ?? '',
            'custom_objective' => $data['objective'] ?? '',
            'isDefault' => false
        ]);
    }

    /**
     * Download the CV as PDF
     */
    public function download($id)
    {
        $resume = Resume::where('user_id', Auth::id())->findOrFail($id);
        $student = Auth::user();
        $data = $resume->resume_data;
        $layout = $resume->layout_name;

        $pdf = Pdf::loadView('student.resume.layouts.' . $layout, [
            'student' => (object) ['name' => $data['name'] ?? '', 'email' => $data['email'] ?? ''],
            'profile' => (object) [
                'field_of_study' => $data['field_of_study'] ?? '',
                'education_level' => $data['education_level'] ?? '',
                'location' => $data['location'] ?? '',
                'interests' => $data['interests'] ?? '',
                'skills' => json_encode($data['skills'] ?? []),
                'phone' => $data['phone'] ?? '',
                'dob' => $data['dob'] ?? '',
                'linkedin' => $data['linkedin'] ?? '',
                'portfolio' => $data['portfolio'] ?? '',
                'experience' => json_encode($data['experience'] ?? []),
                'projects' => json_encode($data['projects'] ?? []),
                'education' => json_encode($data['education'] ?? []),
                'languages' => json_encode($data['languages'] ?? []),
                'certifications' => json_encode($data['certifications'] ?? []),
            ],
            'custom_summary' => $data['summary'] ?? '',
            'custom_objective' => $data['objective'] ?? '',
            'isDefault' => false
        ]);
        
        return $pdf->download(($data['name'] ?? 'Resume') . '_CV.pdf');
    }

    /**
     * Calculate and return the ATS Score for a specific opportunity
     */
    public function checkMatch($opportunityId, $resumeId = null)
    {
        $opportunity = Opportunity::findOrFail($opportunityId);
        $student = Auth::user();
        
        $sourceData = [];
        if ($resumeId) {
            $resume = Resume::where('user_id', $student->id)->findOrFail($resumeId);
            $sourceData = $resume->resume_data;
        } else {
            if (!$student->studentProfile) {
                return response()->json(['error' => 'No profile found'], 400);
            }
            $sourceData = $student->studentProfile->toArray();
        }

        // Call Gemini for advanced scoring
        $scoreData = $this->geminiService->scoreResume($sourceData, [
            'title' => $opportunity->title,
            'description' => $opportunity->description,
            'eligibility' => $opportunity->eligibility,
        ]);

        // Fallback to basic scoring if AI fails or Key is missing
        if (isset($scoreData['error'])) {
            $scoreData = $this->calculateAtsDetails($student->studentProfile ?? $sourceData, $opportunity, (bool)$resumeId);
            $scoreData['ai_status'] = 'fallback';
        } else {
            $scoreData['ai_status'] = 'success';
        }

        return response()->json($scoreData);
    }

    /**
     * Logic for detailed ATS Scoring
     */
    private function calculateAtsDetails($source, $opportunity, $isResume = false)
    {
        if ($isResume) {
            $skills = $source['skills'] ?? [];
            $searchText = strtolower($opportunity->title . ' ' . $opportunity->description . ' ' . $opportunity->eligibility);
        } else {
            $skills = $source->skills ? json_decode($source->skills, true) : [];
            $searchText = strtolower($opportunity->title . ' ' . $opportunity->description . ' ' . $opportunity->eligibility);
        }
        
        if (!is_array($skills)) $skills = [];

        $matched = [];
        $missing = [];
        
        $potentialKeywords = ['laravel', 'php', 'javascript', 'python', 'react', 'vue', 'sql', 'database', 'ui/ux', 'design', 'management', 'marketing'];
        
        foreach($skills as $skill) {
            if (str_contains($searchText, strtolower($skill))) {
                $matched[] = $skill;
            }
        }

        foreach($potentialKeywords as $keyword) {
            if (str_contains($searchText, $keyword) && !in_array($keyword, array_map('strtolower', $skills))) {
                $missing[] = ucfirst($keyword);
            }
        }

        $baseScore = count($matched) * 20;
        $finalScore = min(max($baseScore, 10), 95);

        return [
            'score' => $finalScore,
            'matched' => $matched,
            'missing' => array_slice($missing, 0, 3),
            'status' => $finalScore >= 70 ? 'Excellent' : ($finalScore >= 40 ? 'Good' : 'Needs Improvement')
        ];
    }
}
