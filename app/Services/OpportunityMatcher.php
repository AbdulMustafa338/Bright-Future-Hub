<?php

namespace App\Services;

use App\Models\Opportunity;
use App\Models\User;
use App\Notifications\NewOpportunityNotification;
use App\Notifications\EditedOpportunityNotification;

class OpportunityMatcher
{
    /**
     * Common acronyms and synonyms mapping.
     * This helps match "BSCS" with "Computer Science" profile fields.
     */
    protected static $synonyms = [
        'bscs' => ['computer science', 'cs', 'software engineering'],
        'bba' => ['business administration', 'business', 'management'],
        'ai' => ['artificial intelligence', 'machine learning', 'data science'],
        'ml' => ['machine learning', 'artificial intelligence', 'data science'],
        'se' => ['software engineering', 'computer science'],
        'it' => ['information technology', 'computer science'],
        'cs' => ['computer science', 'software engineering'],
        'ee' => ['electrical engineering', 'electronics'],
    ];

    /**
     * Match an opportunity with students and send notifications.
     */
    public static function matchAndNotify(Opportunity $opportunity, $isUpdate = false)
    {
        $students = User::where('role', 'student')->with('studentProfile')->get();
        
        $oppText = strtolower($opportunity->title . ' ' . $opportunity->description . ' ' . $opportunity->type);

        // Expand acronyms in opportunity text for better matching
        foreach (self::$synonyms as $acronym => $meanings) {
            if (preg_match('/\b' . preg_quote($acronym, '/') . '\b/iu', $oppText)) {
                foreach ($meanings as $meaning) {
                    $oppText .= ' ' . $meaning;
                }
            }
        }

        $matchedCount = 0;

        foreach ($students as $student) {
            $profile = $student->studentProfile;
            $isMatch = false;
            
            if ($profile) {
                $skills = $profile->skills ? json_decode($profile->skills, true) : [];
                $interests = $profile->interests ? array_map('trim', explode(',', $profile->interests)) : [];
                if (!is_array($skills)) $skills = [];
                
                // Add field of study to interests for unified matching
                if (!empty($profile->field_of_study)) {
                    $interests[] = trim($profile->field_of_study);
                }
                
                // Check Skills
                foreach ($skills as $skill) {
                    $skill = trim($skill);
                    if (!empty($skill) && preg_match('/(^|\s|\p{P})' . preg_quote($skill, '/') . '(\s|\p{P}|$)/iu', $oppText)) {
                        $isMatch = true; 
                        break;
                    }
                }
                
                // Check Interests & Field of Study
                if (!$isMatch) {
                    foreach ($interests as $interest) {
                        $interest = trim($interest);
                        if (!empty($interest) && preg_match('/(^|\s|\p{P})' . preg_quote($interest, '/') . '(\s|\p{P}|$)/iu', $oppText)) {
                            $isMatch = true; 
                            break;
                        }
                    }
                }
            }

            if ($isMatch) {
                if ($isUpdate) {
                    $student->notify(new EditedOpportunityNotification($opportunity));
                } else {
                    $student->notify(new NewOpportunityNotification($opportunity));
                }
                $matchedCount++;
            }
        }

        \Illuminate\Support\Facades\Log::info($isUpdate ? 'Opportunity Update Matching Complete' : 'Opportunity Matching Complete', [
            'opportunity_id' => $opportunity->id,
            'notified_students_count' => $matchedCount
        ]);

        return $matchedCount;
    }
}
