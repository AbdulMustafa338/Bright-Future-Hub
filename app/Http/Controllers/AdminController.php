<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opportunity;
use App\Models\OrganizationProfile;
use App\Models\Application;
use Illuminate\Http\Request;

/**
 * AdminController - The control center for platform administration
 * 
 * This controller handles all admin tasks like:
 * - Reviewing and approving/rejecting opportunities posted by organizations
 * - Managing user accounts (activating/deactivating)
 * - Viewing platform statistics and activity
 * - Monitoring organizations and their posts
 */
class AdminController extends Controller
{
    /**
     * Security check - Only admins can access these functions
     * 
     * This runs before every method in this controller to make sure
     * the logged-in user is actually an admin. If not, they get blocked.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    /**
     * Show the admin dashboard with platform overview
     * 
     * Displays important statistics like:
     * - How many users are registered (students and organizations)
     * - How many opportunities are pending approval
     * - Total applications submitted
     * Also shows the 5 most recent opportunities for quick access
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_organizations' => User::where('role', 'organization')->count(),
            'pending_organizations' => OrganizationProfile::where('status', 'pending')->count(),
            'total_opportunities' => Opportunity::count(),
            'total_applications' => Application::count(),
        ];

        // --- Data for User Growth Chart (Last 30 Days) ---
        $userGrowthData = [];
        $userGrowthLabels = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = User::whereDate('created_at', $date)->count();
            $userGrowthLabels[] = now()->subDays($i)->format('M d');
            $userGrowthData[] = $count;
        }

        // --- Data for Opportunity Distribution Chart ---
        $opportunityDistribution = [
            'Admission' => Opportunity::where('type', 'admission')->count(),
            'Internship' => Opportunity::where('type', 'internship')->count(),
            'Scholarship' => Opportunity::where('type', 'scholarship')->count(),
        ];

        $chartData = [
            'userGrowth' => [
                'labels' => $userGrowthLabels,
                'data' => $userGrowthData,
            ],
            'opportunityDistribution' => [
                'labels' => array_keys($opportunityDistribution),
                'data' => array_values($opportunityDistribution),
            ],
        ];

        $recentOrganizations = OrganizationProfile::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recentOrganizations', 'chartData'));
    }

    /**
     * Show all organizations waiting for admin verification
     */
    public function pendingOrganizations()
    {
        $organizations = OrganizationProfile::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.organizations.pending', compact('organizations'));
    }

    /**
     * Approve an organization after verification
     */
    public function approveOrganization($id)
    {
        $organization = OrganizationProfile::findOrFail($id);
        $organization->update([
            'status' => 'approved',
            'rejection_reason' => null
        ]);

        return back()->with('success', 'Organization verified successfully! They can now post opportunities directly.');
    }

    /**
     * Reject an organization with a reason
     */
    public function rejectOrganization(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $organization = OrganizationProfile::findOrFail($id);
        $organization->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason
        ]);

        return back()->with('success', 'Organization registration rejected.');
    }

    /**
     * View and manage all user accounts
     * 
     * Shows a list of all registered users (students and organizations)
     * so admin can monitor accounts and manage their status.
     */
    public function manageUsers()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Activate or deactivate a user account
     * 
     * Admins can toggle user accounts on/off. Deactivated users can't log in.
     * This is useful for handling problematic accounts without deleting them.
     * Note: Admin accounts can't be deactivated for safety.
     */
    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot deactivate admin users.');
        }

        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', 'User status updated successfully.');
    }

    /**
     * View all opportunities with optional filtering
     * 
     * Shows all opportunities regardless of status (approved, pending, rejected).
     * Admin can filter by status to focus on specific types.
     */
    public function allOpportunities(Request $request)
    {
        $query = Opportunity::with('organization');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $opportunities = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.opportunities.index', compact('opportunities'));
    }

    /**
     * View detailed information about an organization
     * 
     * Shows the organization's profile and all opportunities they've posted.
     * Useful for monitoring organization activity.
     */
    public function viewOrganization($id)
    {
        $organization = OrganizationProfile::with('user', 'opportunities')->findOrFail($id);

        return view('admin.organizations.show', compact('organization'));
    }
}
