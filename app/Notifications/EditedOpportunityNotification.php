<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Opportunity;

class EditedOpportunityNotification extends Notification implements ShouldQueue
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
        return ['database', 'broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Opportunity Updated: ' . $this->opportunity->title)
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('An opportunity matching your profile has just been updated.')
                    ->line('**Title:** ' . $this->opportunity->title)
                    ->line('**Type:** ' . ucfirst($this->opportunity->type))
                    ->line('**Deadline:** ' . $this->opportunity->deadline->format('M d, Y'))
                    ->action('View Updated Opportunity', route('opportunities.show', $this->opportunity->id))
                    ->line('Be sure to check out the new details!');
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
            'message' => 'An opportunity has been updated: ' . $this->opportunity->title,
            'url' => route('opportunities.show', $this->opportunity->id)
        ];
    }
    
    /**
     * Get the broadcast representation of the notification.
     *
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'opportunity_id' => $this->opportunity->id,
            'title' => $this->opportunity->title,
            'message' => 'An opportunity has been updated: ' . $this->opportunity->title,
            'url' => route('opportunities.show', $this->opportunity->id)
        ]);
    }
}
