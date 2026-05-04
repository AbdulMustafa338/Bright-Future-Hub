<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunity;
use App\Services\GeminiService;

class ChatController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function handleMessage(Request $request)
    {
        $message = trim($request->input('message', ''));

        if (empty($message)) {
            return response()->json(['reply' => 'Please type a message.']);
        }

        // --- 1. Fetch live platform context for the AI ---
        $opportunities = Opportunity::where('status', 'approved')
            ->where('deadline', '>=', now()->toDateString())
            ->latest()
            ->take(5)
            ->get(['title', 'type', 'location', 'deadline']);

        $opportunitiesText = '';
        if ($opportunities->isNotEmpty()) {
            $opportunitiesText = "\n\nCurrently available opportunities on the platform:\n";
            foreach ($opportunities as $opp) {
                $deadline = \Carbon\Carbon::parse($opp->deadline)->format('d M Y');
                $opportunitiesText .= "- [{$opp->type}] {$opp->title} | Location: {$opp->location} | Deadline: {$deadline}\n";
            }
        } else {
            $opportunitiesText = "\n\nCurrently there are no active opportunities on the platform.";
        }

        // --- 2. Build system prompt ---
        $systemPrompt = "You are 'Hub Guide', a friendly and professional AI assistant for the 'Bright Future Hub' portal.
Bright Future Hub is a platform that connects Pakistani students with internships, jobs, and scholarships.
You help students navigate the platform, find opportunities, understand the application process, and plan their careers.

Key platform features:
- Students can browse and apply for Internships, Jobs, and Scholarships.
- Students have a profile page where they can update their skills, education, and target role.
- There is an AI Career Roadmap feature that generates personalized step-by-step career guides.
- There is a CV Builder to create professional resumes.
- Students can track their application status (Pending, Approved, Rejected) in their dashboard.
- Organizations post opportunities, which are reviewed by an admin before going live.
{$opportunitiesText}

Guidelines:
- Be warm, helpful, and concise. Use bullet points when listing items.
- If someone asks about available jobs/internships/scholarships, mention the ones listed above.
- If someone wants to apply, tell them to browse Opportunities and click 'Apply Now'.
- To edit a profile, tell them to go to Dashboard > Student Profile.
- Format your response in clean HTML using <b>, <br>, <ul>, <li> tags — do NOT use markdown.
- Keep replies short (3-5 sentences max unless asked for details).
- Do not answer questions unrelated to careers, the portal, or education.";

        // --- 3. Retrieve and maintain session history (max last 10 turns for context) ---
        $history = session('chat_history', []);

        // Add the new user message
        $history[] = ['role' => 'user', 'text' => $message];

        // Trim to last 10 messages (5 exchanges) to avoid token overflow
        if (count($history) > 10) {
            $history = array_slice($history, -10);
        }

        // --- 4. Call Gemini ---
        $result = $this->gemini->generateChatResponse($history, $systemPrompt);

        if (is_array($result) && isset($result['error'])) {
            return response()->json(['reply' => '⚠️ ' . $result['message']]);
        }

        $reply = $result;

        // --- 5. Save model's reply to session history ---
        $history[] = ['role' => 'model', 'text' => $reply];
        session(['chat_history' => $history]);

        return response()->json(['reply' => $reply]);
    }

    /**
     * Clear the chat history from session (called when user clicks "New Chat")
     */
    public function clearHistory()
    {
        session()->forget('chat_history');
        return response()->json(['status' => 'ok']);
    }
}
