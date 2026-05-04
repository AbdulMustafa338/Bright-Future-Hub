<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\OrganizationProfile;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OpportunityController extends Controller
{
    /**
     * Display a listing of opportunities (for students).
     */
    public function index(Request $request)
    {
        // Debug logging
        Log::info('OpportunityController@index called', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role ?? 'guest',
            'search' => $request->search,
            'type' => $request->type
        ]);

        // Build query with eager loading to prevent N+1 queries
        $query = Opportunity::with('organization')
            ->approved()
            ->active();

        Log::info('Base query built', [
            'count_before_filters' => $query->count()
        ]);

        // Filter by type (O(1) indexed query)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search by title or description (uses LIKE with indexes)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Order by deadline (ascending - soonest first) and paginate - using simplePaginate for Next/Prev buttons
        $opportunities = $query->orderBy('deadline', 'asc')->simplePaginate(12);

        Log::info('Opportunities fetched', [
            'count' => $opportunities->count()
        ]);

        // Filter out opportunities with missing organization (data integrity check)
        // $opportunities->getCollection()->transform(function ($opportunity) { ... }

        // Regular view response
        return view('student.opportunities.index', compact('opportunities'));
    }

    /**
     * Show the form for creating a new opportunity (organization).
     */
    public function create()
    {
        // Check if user is organization
        if (Auth::user()->role !== 'organization') {
            abort(403, 'Unauthorized action.');
        }

        return view('organization.opportunities.create');
    }

    /**
     * Store a newly created opportunity (organization).
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'organization') {
            abort(403, 'Unauthorized action.');
        }

        // Debug logging
        \Illuminate\Support\Facades\Log::info('Opportunity Store Request:', [
            'has_file' => $request->hasFile('image'),
            'file_name' => $request->file('image') ? $request->file('image')->getClientOriginalName() : 'none',
            'user_id' => Auth::id()
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'eligibility' => 'nullable|string',
            'type' => 'required|in:internship,scholarship,admission',
            'deadline' => 'required|date|after:today',
            'location' => 'nullable|string|max:255',
            'fees' => 'nullable|string|max:255',
            'application_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Increased to 5MB
        ]);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('opportunities', 'public');
        }

        // Get organization profile
        $organization = OrganizationProfile::where('user_id', Auth::id())->first();

        if (!$organization) {
            return back()->withErrors(['error' => 'Organization profile not found. Please complete your profile first.']);
        }

        if ($organization->status !== 'approved') {
            return back()->with('error', 'Your account is not yet verified by the admin. You will be able to post once verified.');
        }

        $validated['organization_id'] = $organization->id;
        $validated['status'] = 'approved';
        $message = 'Opportunity posted successfully!';

        $opportunity = Opportunity::create($validated);

        if ($opportunity->status === 'approved') {
            \App\Services\OpportunityMatcher::matchAndNotify($opportunity);
        }

        return redirect()->route('organization.opportunities.index')
            ->with('success', $message);
    }

    /**
     * Display the specified opportunity.
     */
    public function show($id)
    {
        $opportunity = Opportunity::with('organization')->findOrFail($id);

        // Ensure organization relationship exists
        if (!$opportunity->organization) {
            abort(404, 'Organization information not found for this opportunity.');
        }

        // Check if user has applied and fetch resumes (if logged in as student)
        $hasApplied = false;
        $resumes = collect();
        if (Auth::check() && Auth::user()->role === 'student') {
            $hasApplied = \App\Models\Application::where('user_id', Auth::id())
                ->where('opportunity_id', $id)
                ->exists();
            
            $resumes = \App\Models\Resume::where('user_id', Auth::id())->latest()->get();
        }

        return view('opportunities.show', compact('opportunity', 'hasApplied', 'resumes'));
    }

    /**
     * Show the form for editing the specified opportunity (organization).
     */
    public function edit($id)
    {
        $opportunity = Opportunity::findOrFail($id);

        // Check ownership
        $organization = OrganizationProfile::where('user_id', Auth::id())->first();
        if (!$organization || $opportunity->organization_id !== $organization->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('organization.opportunities.edit', compact('opportunity'));
    }

    /**
     * Update the specified opportunity (organization).
     */
    public function update(Request $request, $id)
    {
        $opportunity = Opportunity::findOrFail($id);

        // Check ownership
        $organization = OrganizationProfile::where('user_id', Auth::id())->first();
        if (!$organization || $opportunity->organization_id !== $organization->id) {
            abort(403, 'Unauthorized action.');
        }

        // Debug logging
        \Illuminate\Support\Facades\Log::info('Opportunity Update Request:', [
            'id' => $id,
            'has_file' => $request->hasFile('image'),
            'file_name' => $request->file('image') ? $request->file('image')->getClientOriginalName() : 'none',
            'user_id' => Auth::id()
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'eligibility' => 'nullable|string',
            'type' => 'required|in:internship,scholarship,admission',
            'deadline' => 'required|date|after:today',
            'location' => 'nullable|string|max:255',
            'fees' => 'nullable|string|max:255',
            'application_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Increased to 5MB
        ]);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($opportunity->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($opportunity->image);
            }
            $validated['image'] = $request->file('image')->store('opportunities', 'public');
        }

        $validated['status'] = 'approved';
        $message = 'Opportunity updated successfully!';

        $opportunity->update($validated);

        if ($opportunity->status === 'approved') {
            \App\Services\OpportunityMatcher::matchAndNotify($opportunity, true);
        }

        return redirect()->route('organization.opportunities.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified opportunity (organization).
     */
    public function destroy($id)
    {
        $opportunity = Opportunity::findOrFail($id);

        // Check ownership
        $organization = OrganizationProfile::where('user_id', Auth::id())->first();
        if (!$organization || $opportunity->organization_id !== $organization->id) {
            abort(403, 'Unauthorized action.');
        }

        $opportunity->delete();

        return redirect()->route('organization.opportunities.index')
            ->with('success', 'Opportunity deleted successfully.');
    }

    /**
     * Apply for an opportunity (student).
     */
    public function apply($id)
    {
        // Ensure user is a student
        if (Auth::user()->role !== 'student') {
            abort(403, 'Only students can apply for opportunities.');
        }

        $opportunity = Opportunity::findOrFail($id);

        // Validate opportunity is approved
        if ($opportunity->status !== 'approved') {
            return back()->with('error', 'This opportunity is not currently accepting applications.');
        }

        // Validate opportunity is not expired
        if ($opportunity->isExpired()) {
            return back()->with('error', 'The application deadline for this opportunity has passed.');
        }

        // Check if already applied (prevent duplicate applications)
        $existing = Application::where('user_id', Auth::id())
            ->where('opportunity_id', $id)
            ->exists(); // Use exists() instead of first() for better performance

        if ($existing) {
            return back()->with('error', 'You have already applied for this opportunity.');
        }

        // Create application
        Application::create([
            'user_id' => Auth::id(),
            'opportunity_id' => $id,
            'status' => 'applied',
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }
}
