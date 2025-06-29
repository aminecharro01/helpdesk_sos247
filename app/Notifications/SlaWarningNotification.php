<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;

class SlaWarningNotification extends Notification implements ShouldQueue
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
        // We need a generic route to show a ticket, accessible by agents and supervisors.
        // For now, we'll build a generic URL.
        $url = url('/tickets/' . $this->ticket->id);

        return (new MailMessage)
                    ->subject('Avertissement SLA : Ticket #' . $this->ticket->id)
                    ->greeting('Bonjour,')
                    ->line('Le ticket suivant approche de sa date limite de résolution :')
                    ->line('Titre : ' . $this->ticket->title)
                    ->action('Voir le Ticket', $url)
                    ->line('Veuillez le traiter dès que possible pour respecter les délais de service.');
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
            'message' => 'Ce ticket approche de sa date limite de résolution.',
        ];
    }
}
