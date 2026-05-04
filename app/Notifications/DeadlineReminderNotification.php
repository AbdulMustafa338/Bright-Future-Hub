<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Opportunity;

class DeadlineReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $opportunity;

    /**
     * Create a new notification instance.
     */
    public function __construct(Opportunity $opportunity)
    {
        $this->opportunity = $opportunity;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->error() // Makes the button red for urgency
                    ->subject('URGENT: Deadline Tomorrow for ' . $this->opportunity->title)
                    ->greeting('Hi ' . $notifiable->name . ',')
                    ->line('This is an urgent reminder that an opportunity matching your profile closes tomorrow!')
                    ->line('**Title:** ' . $this->opportunity->title)
                    ->line('**Organization:** ' . ($this->opportunity->organization->organization_name ?? 'Unknown'))
                    ->action('Apply Now', route('opportunities.show', $this->opportunity->id))
                    ->line('Don\'t miss out on this chance to advance your career.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'opportunity_id' => $this->opportunity->id,
            'title' => $this->opportunity->title,
            'message' => 'Closing Tomorrow! Apply for ' . $this->opportunity->title,
            'url' => route('opportunities.show', $this->opportunity->id)
        ];
    }
}
