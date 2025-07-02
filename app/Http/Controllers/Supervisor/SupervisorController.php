<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SupervisorController extends Controller
{
    /**
     * Display the supervisor's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Card Stats
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 'ouvert')->count();
        $closedTickets = Ticket::where('status', 'fermé')->count();
        $agentCount = User::where('role', 'agent')->count();
        $clientCount = User::where('role', 'client')->count();

        // Latest Tickets
        $latestTickets = Ticket::with(['client', 'agent'])->latest()->take(5)->get();

        // SLA: Average Resolution Time
        $closedTicketsForSla = Ticket::where('status', 'fermé')->whereNotNull('updated_at')->get();
        $resolvedTicketsCount = $closedTicketsForSla->count();
        $averageResolutionTimeInSeconds = 0;
        if ($resolvedTicketsCount > 0) {
            $totalResolutionTime = $closedTicketsForSla->sum(function ($ticket) {
                return Carbon::parse($ticket->updated_at)->diffInSeconds(Carbon::parse($ticket->created_at));
            });
            $averageResolutionTimeInSeconds = $totalResolutionTime / $resolvedTicketsCount;
        }

        // Chart Data: Tickets created vs closed (last 7 days)
        $days = collect([]);
        for ($i = 6; $i >= 0; $i--) {
            $days->put(now()->subDays($i)->format('Y-m-d'), now()->subDays($i)->format('M d'));
        }
        $createdTicketsData = Ticket::selectRaw('DATE(created_at) as date, COUNT(*) as count')->where('created_at', '>=', now()->subDays(7))->groupBy('date')->pluck('count', 'date');
        $closedTicketsData = Ticket::selectRaw('DATE(updated_at) as date, COUNT(*) as count')->where('status', 'fermé')->where('updated_at', '>=', now()->subDays(7))->groupBy('date')->pluck('count', 'date');
        $chartLabels = $days->values()->toJson();
        $createdTicketsChart = $days->keys()->map(fn ($date) => $createdTicketsData[$date] ?? 0)->values()->toJson();
        $closedTicketsChart = $days->keys()->map(fn ($date) => $closedTicketsData[$date] ?? 0)->values()->toJson();

        // Pie Chart: Tickets by Priority
        $priorityData = Ticket::select('priority', \DB::raw('count(*) as total'))
            ->groupBy('priority')
            ->pluck('total', 'priority');
        $priorityLabels = $priorityData->keys()->map(fn($p) => ucfirst($p));
        $priorityValues = $priorityData->values();

        // Pie Chart: Tickets by Status
        $statusData = Ticket::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
        $statusLabels = $statusData->keys()->map(fn($s) => ucfirst($s));
        $statusValues = $statusData->values();

        // Agent Workload
        $agentWorkload = User::where('role', 'agent')
            ->withCount(['assignedTickets' => function ($query) {
                $query->where('status', 'ouvert');
            }])
            ->get();

        return view('supervisor.dashboard', compact(
            'totalTickets',
            'openTickets',
            'closedTickets',
            'agentCount',
            'clientCount',
            'latestTickets',
            'averageResolutionTimeInSeconds',
            'chartLabels',
            'createdTicketsChart',
            'closedTicketsChart',
            'priorityLabels',
            'priorityValues',
            'statusLabels',
            'statusValues',
            'agentWorkload'
        ));
    }

    /**
     * Display a listing of the tickets.
     *
     * @return \Illuminate\View\View
     */
    public function ticketsIndex(Request $request)
    {
        $query = Ticket::with(['client', 'agent']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%$q%")
                    ->orWhereHas('client', function($c) use ($q) {
                        $c->where('name', 'like', "%$q%");
                    });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->agent_id);
        }
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }
        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }

        $tickets = $query->latest()->paginate(15)->appends($request->all());
        $agents = User::where('role', 'agent')->get();
        return view('supervisor.tickets.index', compact('tickets', 'agents'));
    }

    /**
     * Export filtered tickets as PDF
     */
    public function exportTicketsPdf(Request $request)
    {
        $query = Ticket::with(['client', 'agent']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%$q%")
                    ->orWhereHas('client', function($c) use ($q) {
                        $c->where('name', 'like', "%$q%");
                    });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->agent_id);
        }
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }
        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }

        $tickets = $query->latest()->get();

        $pdf = \PDF::loadView('supervisor.tickets.pdf', compact('tickets'));
        return $pdf->download('tickets-filtrés-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Assign a ticket to an agent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignTicket(Request $request, Ticket $ticket)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
        ]);

        $agent = User::find($request->agent_id);

        if (!$agent || $agent->role !== 'agent') {
            return back()->with('error', 'L\'utilisateur sélectionné n\'est pas un agent valide.');
        }

        $ticket->agent_id = $agent->id;
        $ticket->save();

        // Notifier l'agent de l'assignation
        $supervisor = auth()->user();
        $agent->notify(new \App\Notifications\TicketAssignedToAgent($ticket, $supervisor));

        return back()->with('success', 'Ticket assigné avec succès à ' . $agent->name);
    }

    /**
     * Export tickets to a CSV file.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportTicketsCsv()
{
    $tickets = Ticket::with(['client', 'agent'])->get();

    $fileName = 'tickets-' . now()->format('Y-m-d_H-i') . '.xls';
    $headers = [
        'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
        'Content-Disposition' => "attachment; filename=\"$fileName\"",
        'Pragma'              => 'no-cache',
        'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
        'Expires'             => '0',
    ];

    $html = view('supervisor.tickets.csv_export', compact('tickets'))->render();
    $callback = function () use ($html) {
        echo chr(0xEF) . chr(0xBB) . chr(0xBF); // BOM UTF-8 pour Excel
        echo $html;
    };

    return response()->stream($callback, 200, $headers);
}


    

}
