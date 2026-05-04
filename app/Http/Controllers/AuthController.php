<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\OrganizationProfile;

/**
 * AuthController - Handles all authentication related tasks
 * 
 * This controller manages user login, registration, and logout.
 * It works with both students and organizations, creating appropriate
 * profiles based on the user's role during registration.
 */
class AuthController extends Controller
{
    /**
     * Show the login page
     * 
     * Simply displays the login form where users can enter
     * their email and password to access their account.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Process the login attempt
     * 
     * This method does several things:
     * 1. Validates that email and password are provided
     * 2. Checks if the credentials match a user in our database
     * 3. If successful:
     *    - Shows when they last logged in (if available)
     *    - Updates their last login time to right now
     *    - Creates a secure session for them
     *    - Redirects them to their dashboard
     * 4. If failed:
     *    - Shows an error message
     *    - Keeps their email filled in so they can try again
     */
    public function login(Request $request)
    {
        // Make sure they provided email and password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Try to log them in with the provided credentials
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Show them when they last logged in (like "2 days ago")
            if ($user->last_login_at) {
                $diff = $user->last_login_at->diffForHumans(['parts' => 2]);
                $request->session()->flash('last_login_diff', $diff);
            }

            // Record this login time for next time
            $user->update(['last_login_at' => now()]);

            // Create a fresh session for security
            $request->session()->regenerate();
            $request->session()->put('login_time', now()->toIso8601String());

            // Send them to their dashboard
            return redirect()->intended('/dashboard');
        }

        // If login failed, send them back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration page
     * 
     * Displays the registration form where new users can sign up
     * as either a student or an organization.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Create a new user account
     * 
     * This handles the registration process:
     * 1. Validates all the information they provided
     * 2. Creates a new user account with encrypted password
     * 3. If they're registering as an organization:
     *    - Creates an organization profile for them
     *    - Sets their status to 'pending' (admin needs to approve)
     * 4. Logs them in automatically
     * 5. Sends them to their dashboard
     */
    public function register(Request $request)
    {
        // Validate all the registration information
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', 'in:student,organization'],
        ];

        if ($request->role === 'organization') {
            $rules['org_name'] = ['required', 'string', 'max:255'];
            $rules['registration_id'] = ['required', 'string', 'max:100'];
            $rules['location'] = ['required', 'string', 'max:255'];
            $rules['google_map_link'] = ['nullable', 'url'];
            $rules['logo'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
        }

        $validated = $request->validate($rules);

        // Handle logo upload if role is organization
        $logoPath = null;
        if ($request->role === 'organization' && $request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Create the user account with encrypted password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // If they're an organization, create their profile
        // They'll need admin approval before they can post opportunities
        if ($request->role === 'organization') {
            OrganizationProfile::create([
                'user_id' => $user->id,
                'organization_name' => $request->org_name,
                'registration_id' => $request->registration_id,
                'location' => $request->location,
                'google_map_link' => $request->google_map_link,
                'logo' => $logoPath,
                'status' => 'pending', // Needs admin approval
            ]);
        }

        // Log them in automatically
        Auth::login($user);

        // Take them to their dashboard
        return redirect('/dashboard');
    }

    /**
     * Log the user out
     * 
     * This securely logs out the user by:
     * 1. Ending their authentication session
     * 2. Destroying their session data
     * 3. Regenerating the security token (prevents attacks)
     * 4. Sending them back to the homepage
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
