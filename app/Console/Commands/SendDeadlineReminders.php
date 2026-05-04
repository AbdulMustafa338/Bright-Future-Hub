<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Opportunity;
use App\Models\User;
use App\Notifications\DeadlineReminderNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendDeadlineReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:deadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders to targeted students for opportunities closing tomorrow.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting deadline reminders check...');
        Log::info('Deadline reminders command triggered.');

        // Find opportunities that are approved and expiring tomorrow
        $tomorrow = Carbon::tomorrow()->toDateString();
        $opportunities = Opportunity::with('organization')
                            ->approved()
                            ->whereDate('deadline', $tomorrow)
                            ->get();

        if ($opportunities->isEmpty()) {
            $this->info('No opportunities expiring tomorrow.');
            return 0;
        }

        $students = User::where('role', 'student')->with('studentProfile')->get();
        $notificationsSent = 0;

        foreach ($opportunities as $opportunity) {
            $oppText = strtolower($opportunity->title . ' ' . $opportunity->description . ' ' . $opportunity->type);
            
            // Get IDs of students who already applied
            $appliedUserIds = $opportunity->applications()->pluck('user_id')->toArray();

            foreach ($students as $student) {
                // Skip if already applied
                if (in_array($student->id, $appliedUserIds)) {
                    continue;
                }

                $profile = $student->studentProfile;
                $isMatch = false;

                if ($profile) {
                    $skills = $profile->skills ? json_decode($profile->skills, true) : [];
                    $interests = $profile->interests ? array_map('trim', explode(',', $profile->interests)) : [];
                    if (!is_array($skills)) $skills = [];

                    foreach ($skills as $skill) {
                        $skill = trim($skill);
                        if (!empty($skill) && preg_match('/(^|\s|\p{P})' . preg_quote($skill, '/') . '(\s|\p{P}|$)/iu', $oppText)) {
                            $isMatch = true; break;
                        }
                    }

                    if (!$isMatch) {
                        foreach ($interests as $interest) {
                            $interest = trim($interest);
                            if (!empty($interest) && preg_match('/(^|\s|\p{P})' . preg_quote($interest, '/') . '(\s|\p{P}|$)/iu', $oppText)) {
                                $isMatch = true; break;
                            }
                        }
                    }

                    if (!$isMatch && !empty($profile->field_of_study)) {
                        $field = trim($profile->field_of_study);
                        if (preg_match('/(^|\s|\p{P})' . preg_quote($field, '/') . '(\s|\p{P}|$)/iu', $oppText)) {
                            $isMatch = true;
                        }
                    }
                }

                if ($isMatch) {
                    $student->notify(new DeadlineReminderNotification($opportunity));
                    $notificationsSent++;
                }
            }
        }

        $this->info("Completed. Sent {$notificationsSent} reminder notifications.");
        Log::info("Deadline reminders command completed. Sent {$notificationsSent} notifications.");
        return 0;
    }
}
