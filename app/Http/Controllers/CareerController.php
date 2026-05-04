<?php

namespace App\Http\Controllers;

use App\Models\CareerRoadmap;
use App\Models\StudentProfile;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CareerController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
        $this->middleware('auth');
    }

    /**
     * Show the career roadmap page
     */
    public function roadmap()
    {
        if (Auth::user()->role !== 'student') {
            abort(403);
        }

        $profile = StudentProfile::where('user_id', Auth::id())->first();
        $roadmap = CareerRoadmap::where('user_id', Auth::id())->latest()->first();

        return view('student.career.roadmap', compact('profile', 'roadmap'));
    }

    /**
     * Generate a new roadmap using Gemini
     */
    public function generateRoadmap(Request $request)
    {
        $request->validate([
            'target_role' => 'required|string|max:100',
        ]);

        $user = Auth::user();
        $profile = StudentProfile::where('user_id', $user->id)->first();

        if (!$profile) {
            return back()->with('error', 'Please complete your profile first.');
        }

        // Update target role in profile
        $profile->update(['target_role' => $request->target_role]);

        // Call Gemini
        $roadmapData = $this->geminiService->generateRoadmap(
            $profile->skills,
            $request->target_role,
            $profile->field_of_study
        );

        if (isset($roadmapData['error'])) {
            return back()->with('error', $roadmapData['message']);
        }

        // Save to DB
        CareerRoadmap::create([
            'user_id' => $user->id,
            'role_title' => $request->target_role,
            'roadmap_data' => $roadmapData,
        ]);

        return redirect()->route('student.career.roadmap')->with('success', 'AI has generated your personalized career roadmap!');
    }
}
