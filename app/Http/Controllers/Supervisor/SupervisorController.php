<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    /**
     * Tableau de bord superviseur.
     */
    public function index()
    {
        // Statistiques tickets
        $totalTickets     = Ticket::count();
        $openTickets      = Ticket::where('status', 'ouvert')->count();
        $inProgressTickets= Ticket::where('status', 'en_cours')->count();
        $resolvedTickets  = Ticket::where('status', 'resolu')->count();
        $closedTickets    = Ticket::where('status', 'ferme')->count();

        // Comptes utilisateurs
        $agentCount   = User::where('role', 'agent')->count();
        $clientCount  = User::where('role', 'client')->count();

        // Derniers tickets
        $latestTickets = Ticket::with(['client','agent'])->latest()->take(5)->get();

        return view('supervisor.dashboard', compact(
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'closedTickets',
            'agentCount',
            'clientCount',
            'latestTickets'
        ));
    }

    /**
     * Liste complète des tickets pour supervision.
     */
    public function ticketsIndex(Request $request)
    {
        $tickets = Ticket::with(['client','agent'])
            ->when($request->filled('status'), fn($q)=>$q->where('status',$request->status))
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('supervisor.tickets.index', compact('tickets'));
    }
}
