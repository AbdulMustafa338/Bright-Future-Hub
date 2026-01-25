<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Opportunity;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * StudentController - Manages student-specific features
 * 
 * This controller handles everything students need:
 * - Viewing their dashboard with application statistics
 * - Managing their applications to opportunities
 * - Updating their profile information
 */
class StudentController extends Controller
{
    /**
     * Security check - Only students can access these functions
     * 
     * Makes sure the logged-in user is a student before allowing
     * access to any student-specific features.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'student') {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    /**
     * Show the student dashboard
     * 
     * Displays useful stats for the student:
     * - How many applications they've submitted
     * - How many active opportunities are available
     * - How many times they've been shortlisted
     * Also shows their 5 most recent applications
     */
    public function dashboard()
    {
        $stats = [
            'total_applications' => Application::where('user_id', Auth::id())->count(),
            'active_opportunities' => Opportunity::approved()->active()->count(),
            'shortlisted' => Application::where('user_id', Auth::id())
                ->where('status', 'shortlisted')->count(),
        ];

        $recentApplications = Application::with('opportunity.organization')
            ->where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard.index', compact('stats', 'recentApplications'));
    }

    /**
     * Show all applications submitted by this student
     * 
     * Lists all the opportunities the student has applied to,
     * along with their application status (pending, shortlisted, etc.)
     */
    public function applications()
    {
        $applications = Application::with('opportunity.organization')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.applications.index', compact('applications'));
    }

    /**
     * Show the profile editing form
     * 
     * Lets students view and edit their profile information like
     * field of study, education level, and interests.
     */
    public function editProfile()
    {
        $profile = StudentProfile::where('user_id', Auth::id())->first();
        $user = Auth::user();

        return view('student.profile.edit', compact('profile', 'user'));
    }

    /**
     * Save updated profile information
     * 
     * Updates the student's profile with new information they provided.
     * If they don't have a profile yet, creates one for them.
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'field_of_study' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'interests' => 'nullable|string',
        ]);

        // Update user fields
        Auth::user()->update([
            'field_of_study' => $validated['field_of_study'],
            'education_level' => $validated['education_level'],
            'interests' => $validated['interests'],
        ]);

        // Update or create student profile if needed
        $profile = StudentProfile::where('user_id', Auth::id())->first();
        if (!$profile) {
            StudentProfile::create([
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->route('student.dashboard')
            ->with('success', 'Profile updated successfully!');
    }
}
