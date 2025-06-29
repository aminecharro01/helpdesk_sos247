<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;

class SlaBreachedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Ticket $ticket
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/tickets/' . $this->ticket->id);

        return (new MailMessage)
                    ->subject('Alerte Critique : Violation de SLA pour le Ticket #' . $this->ticket->id)
                    ->error()
                    ->greeting('Attention,')
                    ->line('Le délai de résolution pour le ticket suivant a été dépassé :')
                    ->line('Titre : ' . $this->ticket->title)
                    ->action('Voir le Ticket', $url)
                    ->line('Une action immédiate est requise.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => $this->ticket->title,
            'message' => 'Le délai de résolution pour ce ticket a été dépassé.',
        ];
    }
}
