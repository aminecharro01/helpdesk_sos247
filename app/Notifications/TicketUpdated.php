<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Support\Facades\Log;

class TicketUpdated extends Notification
{
    use Queueable;

    public $ticket;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket, $message)
    {
        $this->ticket = $ticket;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database']; // 👈 très important : permet l'enregistrement dans la base
    }

    /**
     * Get the array representation of the notification for database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'message' => $this->message,
            'url' => route(
                $notifiable->role === 'client' ? 'client.tickets.show' : 
                ($notifiable->role === 'agent' ? 'agent.tickets.show' : 'admin.tickets.show'), 
                $this->ticket->id
            ),
        ];
    }
}