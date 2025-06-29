<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\SlaWarningNotification;
use App\Notifications\SlaBreachedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckSlaBreaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-sla-breaches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for SLA breaches and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des violations de SLA...');

        // Define SLA rules in hours based on priority
        $slaRules = [
            'faible' => 7 * 24,   // 7 days
            'moyenne' => 3 * 24,  // 3 days
            'haute' => 24,        // 24 hours
            'urgente' => 4,       // 4 hours
        ];
        $warningThreshold = 0.75; // 75% of SLA time

        $openTickets = Ticket::with('agent')->where('status', 'ouvert')->get();

        foreach ($openTickets as $ticket) {
            if (!isset($slaRules[$ticket->priority])) {
                continue; // Skip if priority is not defined in rules
            }

            $slaLimitInHours = $slaRules[$ticket->priority];
            $ticketAgeInHours = Carbon::now()->diffInHours($ticket->created_at);

            // Check for SLA breach
            if ($ticketAgeInHours >= $slaLimitInHours) {
                if (!$ticket->sla_breached_sent) {
                    $this->sendSlaBreachedNotification($ticket);
                    $ticket->sla_breached_sent = true;
                    $ticket->save();
                    $this->line('Violation de SLA détectée pour le ticket #' . $ticket->id);
                }
            } 
            // Check for SLA warning
            elseif ($ticketAgeInHours >= ($slaLimitInHours * $warningThreshold)) {
                if (!$ticket->sla_warning_sent) {
                    $this->sendSlaWarningNotification($ticket);
                    $ticket->sla_warning_sent = true;
                    $ticket->save();
                    $this->line('Avertissement de SLA envoyé pour le ticket #' . $ticket->id);
                }
            }
        }

        $this->info('Vérification terminée.');
        return 0;
    }

    private function sendSlaWarningNotification(Ticket $ticket)
    {
        if ($ticket->agent) {
            $ticket->agent->notify(new SlaWarningNotification($ticket));
            // Also notify supervisor(s)
            $supervisors = User::where('role', 'superviseur')->get();
            foreach ($supervisors as $supervisor) {
                $supervisor->notify(new SlaWarningNotification($ticket));
            }
        }
    }

    private function sendSlaBreachedNotification(Ticket $ticket)
    {
        // Notify all supervisors and admins
        $recipients = User::whereIn('role', ['superviseur', 'admin'])->get();
        foreach ($recipients as $recipient) {
            $recipient->notify(new SlaBreachedNotification($ticket));
        }
    }
}
