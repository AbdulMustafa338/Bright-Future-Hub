<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';

    // Models tried in order — primary first, fallbacks if busy/overloaded
    protected $modelFallbacks = [
        'gemini-2.5-flash',
        'gemini-2.0-flash',
        'gemini-2.0-flash-lite',
        'gemini-1.5-flash',
    ];

    // Errors that indicate we should try the next model
    protected $retryableErrors = [
        'currently experiencing high demand',
        'overloaded',
        'UNAVAILABLE',
        'Service Unavailable',
        '503',
    ];

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', env('GEMINI_API_KEY'));
    }

    /**
     * Internal helper - tries each model in fallback order until one succeeds.
     */
    private function callApi(array $payload, string $forceModel = null): string|array
    {
        if (!$this->apiKey || $this->apiKey === 'your_actual_key_here') {
            return ['error' => true, 'message' => 'Gemini API Key is not set. Please add GEMINI_API_KEY to your .env file.'];
        }

        $models = $forceModel ? [$forceModel] : $this->modelFallbacks;
        $lastError = 'Unknown error.';

        foreach ($models as $model) {
            try {
                $url = $this->baseUrl . $model . ':generateContent?key=' . $this->apiKey;

                $response = Http::withOptions([
                    'verify'  => false, // Fix for Windows/XAMPP SSL
                    'timeout' => 30,
                ])->post($url, $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    return $text;
                }

                $errorBody    = $response->json();
                $errorMessage = $errorBody['error']['message'] ?? $response->body();
                Log::warning("Gemini [{$model}] Error [{$response->status()}]: {$errorMessage}");

                // Check if this error is retryable (high demand / overloaded)
                $isRetryable = false;
                foreach ($this->retryableErrors as $retryKeyword) {
                    if (stripos($errorMessage, $retryKeyword) !== false) {
                        $isRetryable = true;
                        break;
                    }
                }

                if ($isRetryable) {
                    $lastError = $errorMessage;
                    continue; // Try next model
                }

                // Non-retryable error (auth, quota, etc.) — stop immediately
                return ['error' => true, 'message' => 'AI Service Error: ' . $errorMessage];

            } catch (\Exception $e) {
                Log::warning("Gemini [{$model}] Exception: " . $e->getMessage());
                $lastError = $e->getMessage();
                continue; // Try next model
            }
        }

        // All models exhausted
        Log::error('Gemini: All fallback models failed. Last error: ' . $lastError);
        return ['error' => true, 'message' => 'AI service is currently busy. Please try again in a moment.'];
    }

    /**
     * Parse JSON from a Gemini text response robustly.
     * Handles markdown code blocks like ```json ... ```
     */
    private function parseJsonResponse(string $text): array
    {
        // Strip markdown code fences (```json ... ``` or ``` ... ```)
        $cleaned = preg_replace('/^```(?:json)?\s*/m', '', $text);
        $cleaned = preg_replace('/```\s*$/m', '', $cleaned);
        $cleaned = trim($cleaned);

        $decoded = json_decode($cleaned, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::warning('Gemini JSON parse failed. Raw text: ' . $text);
            return ['error' => true, 'message' => 'AI returned an unexpected format. Please try again.'];
        }

        return $decoded;
    }

    /**
     * General method to call Gemini API and return a parsed JSON array.
     * Used for Roadmap, Resume Scoring, etc.
     */
    public function generate($prompt): array
    {
        $payload = [
            'contents' => [
                [
                    'parts' => [['text' => $prompt]]
                ]
            ],
            // No responseMimeType — free tier compatible; we parse JSON ourselves
        ];

        $result = $this->callApi($payload);

        if (is_array($result) && isset($result['error'])) {
            return $result;
        }

        return $this->parseJsonResponse($result);
    }

    /**
     * Generate a Career Roadmap
     */
    public function generateRoadmap($currentSkills, $targetRole, $fieldOfStudy = ''): array
    {
        $skillsStr = is_array($currentSkills) ? implode(', ', $currentSkills) : ($currentSkills ?? 'Not specified');
        $fieldStr  = $fieldOfStudy ?? 'Not specified';

        $prompt = "You are a professional career coach for university students. Generate a detailed step-by-step career roadmap.
Current Skills: {$skillsStr}
Field of Study: {$fieldStr}
Target Role: {$targetRole}

Return ONLY a valid JSON object in EXACTLY this structure, no extra text:
{
    \"role\": \"{$targetRole}\",
    \"summary\": \"Brief 2-3 sentence overview of what it takes to become a {$targetRole}\",
    \"steps\": [
        {
            \"title\": \"Step Name\",
            \"description\": \"Detailed explanation of what to do in this step\",
            \"duration\": \"e.g. 2-3 months\",
            \"resources\": [\"Resource 1\", \"Resource 2\"]
        }
    ],
    \"project_ideas\": [\"Project Idea 1\", \"Project Idea 2\", \"Project Idea 3\"],
    \"certifications\": [\"Certification 1\", \"Certification 2\"]
}";

        return $this->generate($prompt);
    }

    /**
     * Score a Resume against an Opportunity
     */
    public function scoreResume($resumeData, $opportunityData): array
    {
        $prompt = "You are an expert HR professional and ATS system. Analyze the student's resume against the job/opportunity description.
Resume Data: " . json_encode($resumeData) . "
Opportunity Data: " . json_encode($opportunityData) . "

Return ONLY a valid JSON object in EXACTLY this structure:
{
    \"score\": 75,
    \"status\": \"Good\",
    \"matched_skills\": [\"skill1\", \"skill2\"],
    \"missing_skills\": [\"skill1\", \"skill2\"],
    \"strengths\": [\"Strength 1\", \"Strength 2\"],
    \"weaknesses\": [\"Weakness 1\", \"Weakness 2\"],
    \"tips\": [\"Tip 1\", \"Tip 2\"]
}
Status must be one of: Excellent, Good, Needs Improvement.";

        return $this->generate($prompt);
    }

    /**
     * Generate a conversational chat reply.
     * Used by the AI Chatbot widget.
     *
     * @param array  $history     Array of ['role' => 'user'|'model', 'text' => '...']
     * @param string $systemPrompt  Background context / instructions for the AI
     * @return string  Plain text / HTML-friendly reply
     */
    public function generateChatResponse(array $history, string $systemPrompt): string|array
    {
        // Build contents array for the API
        $contents = [];
        foreach ($history as $turn) {
            $contents[] = [
                'role'  => $turn['role'], // 'user' or 'model'
                'parts' => [['text' => $turn['text']]]
            ];
        }

        $payload = [
            'system_instruction' => [
                'parts' => [['text' => $systemPrompt]]
            ],
            'contents' => $contents,
            'generationConfig' => [
                'temperature'     => 0.7,
                'maxOutputTokens' => 512,
            ],
        ];

        $result = $this->callApi($payload);

        if (is_array($result) && isset($result['error'])) {
            return $result;
        }

        return trim($result);
    }
}
