<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\OrganizationProfile;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * OrganizationController - Manages organization-specific features
 * 
 * This controller handles everything organizations need:
 * - Viewing their dashboard with statistics
 * - Creating and managing opportunities (internships, scholarships, etc.)
 * - Managing their organization profile
 * - Reviewing and responding to student applications
 */
class OrganizationController extends Controller
{
    /**
     * Security check - Only organizations can access these functions
     * 
     * Makes sure the logged-in user is an organization before allowing
     * access to any organization-specific features.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'organization') {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    /**
     * Show the organization dashboard
     * 
     * If they haven't created their profile yet, shows the profile creation form.
     * Otherwise, displays stats about their opportunities and applications:
     * - Total opportunities posted
     * - How many are approved/pending
     * - Total applications received
     * Also shows their 5 most recent opportunities
     */
    public function dashboard()
    {
        $organization = OrganizationProfile::where('user_id', Auth::id())->first();

        if (!$organization) {
            return view('organization.profile.create');
        }

        $stats = [
            'total_opportunities' => Opportunity::where('organization_id', $organization->id)->count(),
            'approved_opportunities' => Opportunity::where('organization_id', $organization->id)
                ->where('status', 'approved')->count(),
            'pending_opportunities' => Opportunity::where('organization_id', $organization->id)
                ->where('status', 'pending')->count(),
            'total_applications' => Application::whereHas('opportunity', function ($q) use ($organization) {
                $q->where('organization_id', $organization->id);
            })->count(),
        ];

        $recentOpportunities = Opportunity::where('organization_id', $organization->id)
            ->latest()
            ->take(5)
            ->get();

        return view('organization.dashboard.index', compact('stats', 'recentOpportunities', 'organization'));
    }

    /**
     * Show all opportunities posted by this organization
     * 
     * Lists all the internships, scholarships, or competitions
     * this organization has created, with their approval status.
     */
    public function opportunities()
    {
        $organization = OrganizationProfile::where('user_id', Auth::id())->first();

        if (!$organization) {
            return redirect()->route('organization.profile.create')
                ->with('error', 'Please complete your organization profile first.');
        }

        $opportunities = Opportunity::where('organization_id', $organization->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('organization.opportunities.index', compact('opportunities'));
    }

    /**
     * View all applications for a specific opportunity
     * 
     * Shows all students who applied to one of their opportunities.
     * Organizations can review applications and update their status
     * (shortlist, accept, reject).
     */
    public function viewApplications($opportunityId)
    {
        $organization = OrganizationProfile::where('user_id', Auth::id())->first();
        $opportunity = Opportunity::findOrFail($opportunityId);

        // Check ownership
        if ($opportunity->organization_id !== $organization->id) {
            abort(403, 'Unauthorized action.');
        }

        $applications = Application::with('user')
            ->where('opportunity_id', $opportunityId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('organization.applications.index', compact('opportunity', 'applications'));
    }

    /**
     * Show the form to create organization profile
     * 
     * New organizations need to fill out their profile before
     * they can post opportunities. If profile already exists,
     * redirects to the edit page instead.
     */
    public function createProfile()
    {
        $organization = OrganizationProfile::where('user_id', Auth::id())->first();

        // If profile already exists, redirect to edit
        if ($organization) {
            return redirect()->route('organization.profile.edit');
        }

        return view('organization.profile.create');
    }

    /**
     * Save the new organization profile
     * 
     * Creates the organization's profile with their information.
     * Status is set to 'pending' - admin needs to approve before
     * they can start posting opportunities.
     */
    public function storeProfile(Request $request)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';
        OrganizationProfile::create($validated);

        return redirect()->route('organization.dashboard')
            ->with('success', 'Profile created successfully! It will be reviewed by admin.');
    }

    /**
     * Show the form to edit organization profile
     * 
     * Lets organizations update their profile information like
     * name, description, and contact person.
     */
    public function editProfile()
    {
        $organization = OrganizationProfile::where('user_id', Auth::id())->first();

        return view('organization.profile.edit', compact('organization'));
    }

    /**
     * Save updated organization profile
     * 
     * Updates the organization's profile with new information.
     * If somehow they don't have a profile yet, creates one.
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
        ]);

        $organization = OrganizationProfile::where('user_id', Auth::id())->first();

        if ($organization) {
            $organization->update($validated);
        } else {
            $validated['user_id'] = Auth::id();
            $validated['status'] = 'pending';
            OrganizationProfile::create($validated);
        }

        return redirect()->route('organization.dashboard')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the status of a student's application
     * 
     * Organizations can mark applications as:
     * - viewed: They've looked at it
     * - shortlisted: Student is being considered
     * - accepted: Student got the opportunity!
     * - rejected: Application was declined
     */
    public function updateApplicationStatus(Request $request, $applicationId)
    {
        $validated = $request->validate([
            'status' => 'required|in:shortlisted,accepted,rejected,viewed',
        ]);

        $application = Application::findOrFail($applicationId);
        $opportunity = $application->opportunity;

        // Verify ownership
        $organization = OrganizationProfile::where('user_id', Auth::id())->first();
        if (!$organization || $opportunity->organization_id !== $organization->id) {
            abort(403, 'Unauthorized action.');
        }

        // Update status
        $application->update(['status' => $validated['status']]);

        $statusMessages = [
            'shortlisted' => 'Application shortlisted successfully!',
            'accepted' => 'Application accepted successfully!',
            'rejected' => 'Application rejected.',
            'viewed' => 'Application marked as viewed.',
        ];

        return back()->with('success', $statusMessages[$validated['status']] ?? 'Application status updated.');
    }
}
