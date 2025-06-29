<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\UnassignedTicketAlert;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendUnassignedTicketAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send-unassigned-ticket-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scans for unassigned tickets older than 30 minutes and sends alerts to supervisors.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for unassigned tickets...');

        $threshold = Carbon::now()->subMinutes(30);

        $unassignedTickets = Ticket::where('status', 'ouvert')
            ->whereNull('agent_id')
            ->where('created_at', '<=', $threshold)
            ->where('unassigned_notification_sent', false)
            ->get();

        if ($unassignedTickets->isEmpty()) {
            $this->info('No unassigned tickets require notification.');
            return 0;
        }

        $supervisors = User::where('role', 'superviseur')->get();

        if ($supervisors->isEmpty()) {
            $this->warn('No supervisors found to notify.');
            return 1;
        }

        $this->info("Found {$unassignedTickets->count()} tickets to notify about. Notifying {$supervisors->count()} supervisors.");

        foreach ($unassignedTickets as $ticket) {
            Notification::send($supervisors, new UnassignedTicketAlert($ticket));
            
            $ticket->update(['unassigned_notification_sent' => true]);
        }

        $this->info('Successfully sent all notifications.');
        return 0;
    }
}
