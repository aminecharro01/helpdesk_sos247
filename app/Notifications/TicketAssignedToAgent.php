<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketAssignedToAgent extends Notification
{
    use Queueable;

    public $ticket;
    public $supervisor;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket, $supervisor)
    {
        $this->ticket = $ticket;
        $this->supervisor = $supervisor;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database']; // Affichée sur le dashboard
    }

    /**
     * Get the array representation of the notification for database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'message' => 'Un nouveau ticket vous a été assigné par ' . ($this->supervisor->name ?? 'le superviseur') . ' : ' . $this->ticket->title,
            'url' => route('agent.tickets.show', $this->ticket->id),
        ];
    }
}
