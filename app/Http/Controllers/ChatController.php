<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunity;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function handleMessage(Request $request)
    {
        $message = strtolower($request->input('message', ''));
        
        // 1. Core Knowledge Base / FAQ Logic
        $faqs = [
            'how to apply' => "Applying is easy! Just go to any opportunity, click on it to see details, and then click the **'Apply Now'** button. You can track your applications in the 'My Applications' section.",
            'edit profile' => "To edit your profile, go to your **Dashboard**, click on the **'Student Profile'** or **'Organization Profile'** link, and update your details like skills, experience, or bio.",
            'who are you' => "I am the **Bright Future Hub Guide**, an AI assistant designed to help you find jobs, scholarships, and internships while navigating this portal efficiently.",
            'bright future hub' => "**Bright Future Hub** is a platform connecting students with the best professional and educational opportunities including jobs, internships, and scholarships.",
            'track application' => "You can track the status of your applications (Pending, Approved, Rejected) from the **'Applications'** tab in your dashboard.",
            'login' => "You can login using your email and password from the [Login Page](" . route('login') . ").",
            'register' => "If you don't have an account, you can create one at the [Registration Page](" . route('register') . "). Select 'Student' or 'Organization' based on your needs.",
            'help' => "I can help you with:<br>• Finding Jobs/Internships/Scholarships<br>• Guidance on how to use the portal<br>• Account and Profile support"
        ];

        foreach ($faqs as $keyword => $response) {
            if (Str::contains($message, $keyword)) {
                return response()->json(['reply' => $response]);
            }
        }

        // 2. Basic Greetings (Refined)
        if (Str::contains($message, ['hello', 'hi', 'hey', 'aoa', 'assalam', 'dear'])) {
            $reply = "Hello! 👋 I'm your Bright Future Hub assistant. How can I help you today?<br><br>You can ask me things like:<br>• 'Find me an internship'<br>• 'How to apply?'<br>• 'About this portal'";
            return response()->json(['reply' => $reply]);
        }

        // 3. Intent Detection for Search
        $type = null;
        if (Str::contains($message, ['internship', 'intern'])) $type = 'Internship';
        elseif (Str::contains($message, ['scholarship', 'study', 'phd', 'master'])) $type = 'Scholarship';
        elseif (Str::contains($message, ['job', 'work', 'employment', 'hiring'])) $type = 'Job';

        // 4. Search Query Logic (Existing)
        $query = Opportunity::where('status', 'approved');

        if ($type) {
            $query->where('type', 'LIKE', '%' . $type . '%');
        }

        $words = explode(' ', $message);
        $ignoreWords = ['find', 'me', 'a', 'an', 'the', 'any', 'is', 'for', 'in', 'at', 'with', 'search', 'give', 'show', 'please'];
        $keywords = array_filter($words, function($word) use ($ignoreWords) {
            return !in_array($word, $ignoreWords) && strlen($word) > 2;
        });

        if (!empty($keywords)) {
            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $word) {
                    if (in_array(strtolower($word), ['internship', 'scholarship', 'job'])) continue;
                    $q->orWhere('title', 'LIKE', '%' . $word . '%')
                      ->orWhere('description', 'LIKE', '%' . $word . '%')
                      ->orWhere('location', 'LIKE', '%' . $word . '%');
                }
            });
        }

        $results = $query->latest()->take(3)->get();

        if ($results->count() > 0) {
            $reply = "I found these " . ($type ? strtolower($type) . " " : "") . "opportunities for you:<br><ul class='mt-2 ps-3'>";
            foreach ($results as $item) {
                $url = route('opportunities.show', $item->id);
                $reply .= "<li><a href='{$url}' class='text-primary fw-bold' style='text-decoration: none;'>{$item->title}</a> ({$item->location})</li>";
            }
            $reply .= "</ul>";
        } else {
            $reply = "I'm not exactly sure about that, but I can find jobs and scholarships for you! Try asking 'Find me a software internship' or 'How to apply?'.";
        }

        return response()->json(['reply' => $reply]);
    }
}
