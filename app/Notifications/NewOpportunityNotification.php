<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Opportunity;

class NewOpportunityNotification extends Notification implements ShouldQueue
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
        return ['database', 'broadcast'];
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
            'message' => 'A new opportunity has been posted: ' . $this->opportunity->title,
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
            'message' => 'A new opportunity has been posted: ' . $this->opportunity->title,
            'url' => route('opportunities.show', $this->opportunity->id)
        ]);
    }
}
