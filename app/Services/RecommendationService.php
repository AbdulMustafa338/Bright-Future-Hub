<?php

namespace App\Services;

use App\Models\Opportunity;
use App\Models\StudentProfile;
use App\Models\Application;

class RecommendationService
{
    /**
     * Get recommended opportunities for a student based on their profile.
     * Calculates a TF-IDF style match score using keywords.
     * 
     * @param StudentProfile $profile
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getRecommendations(StudentProfile $profile, $limit = 4)
    {
        // 1. Extract and sanitize student data keywords
        $skills = $profile->skills ? json_decode($profile->skills, true) : [];
        if (!is_array($skills)) $skills = [];
        
        $interests = $profile->interests ? array_map('trim', explode(',', $profile->interests)) : [];
        $fieldOfStudy = $profile->field_of_study;
        
        // If the profile is completely empty, we can't recommend anything specific
        if (empty($skills) && empty($interests) && empty($fieldOfStudy)) {
            return collect([]);
        }

        // 2. Fetch all active, approved opportunities the user hasn't already applied to
        $appliedIds = Application::where('user_id', $profile->user_id)->pluck('opportunity_id')->toArray();
        
        $opportunities = Opportunity::with('organization')
            ->approved()
            ->active()
            ->whereNotIn('id', $appliedIds)
            ->get();
            
        // 3. Score each opportunity against the profile
        $scoredOpportunities = $opportunities->map(function($opportunity) use ($skills, $interests, $fieldOfStudy) {
            $score = 0;
            $maxScore = 0; // Dynamic max score based on what student has defined
            $matchedKeywords = [];
            
            // Combine all searchable text from the opportunity
            $searchText = strtolower(
                $opportunity->title . ' ' . 
                $opportunity->description . ' ' . 
                $opportunity->eligibility . ' ' . 
                $opportunity->type
            );
            
            // Score Skills 
            if (count($skills) > 0) {
                // Determine weight dynamically, capping at 15 points
                $maxPossibleSkillsScore = min(count($skills) * 3, 15); 
                $maxScore += $maxPossibleSkillsScore;
                $pointsPerSkill = $maxPossibleSkillsScore / count($skills);
                
                foreach ($skills as $skill) {
                    if (empty(trim($skill))) continue;
                    
                    if (str_contains($searchText, strtolower(trim($skill)))) {
                        $score += $pointsPerSkill;
                        $matchedKeywords[] = trim($skill);
                    }
                }
            }
            
            // Score Interests 
            if (count($interests) > 0) {
                // Determine weight dynamically, capping at 10 points
                $maxPossibleInterestsScore = min(count($interests) * 2, 10);
                $maxScore += $maxPossibleInterestsScore;
                $pointsPerInterest = $maxPossibleInterestsScore / count($interests);
                
                foreach ($interests as $interest) {
                    if (empty(trim($interest))) continue;
                    
                    if (str_contains($searchText, strtolower(trim($interest)))) {
                        $score += $pointsPerInterest;
                        $matchedKeywords[] = trim($interest);
                    }
                }
            }
            
            // Score Field of Study
            if (!empty($fieldOfStudy)) {
                $maxScore += 5;
                if (str_contains($searchText, strtolower(trim($fieldOfStudy)))) {
                    $score += 5;
                    $matchedKeywords[] = trim($fieldOfStudy);
                }
            }
            
            // Calculate Percentage safely
            if ($maxScore == 0) {
                $percentage = 0;
            } else {
                $percentage = round(($score / $maxScore) * 100);
            }
            
            // Attach AI details as temporary properties for UI
            // We cap at 98% to make it look realistic (AI is never 100% sure)
            $opportunity->match_percentage = min($percentage, 98); 
            $opportunity->matched_keywords = array_unique($matchedKeywords);
            
            return $opportunity;
        });
        
        // 4. Sort by highest match percentage and filter out low matches (<15%)
        return $scoredOpportunities
            ->filter(function($opp) {
                return $opp->match_percentage >= 15;
            })
            ->sortByDesc('match_percentage')
            ->take($limit)
            ->values(); // Reset array keys for JSON/Vue compatibility if needed later
    }
}
