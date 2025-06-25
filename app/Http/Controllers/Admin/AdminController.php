<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketUpdated;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Statistiques principales
        $totalUsers     = User::count();
        $totalTickets   = Ticket::count();
        $openTickets    = Ticket::where('status', 'ouvert')->count();
        $inProgressTickets = Ticket::where('status', 'en_cours')->count();
        $resolvedTickets   = Ticket::where('status', 'resolu')->count();
        $closedTickets     = Ticket::where('status', 'ferme')->count();

        $adminCount    = User::where('role', 'admin')->count();
        $agentCount    = User::where('role', 'agent')->count();
        $clientCount   = User::where('role', 'client')->count();

        // Variables pour les cartes de statistiques (alias pour la clarté de la vue)
        $activeAgents  = $agentCount;
        $activeClients = $clientCount;

        // Listes pour les tableaux
        $latestUsers   = User::latest()->take(5)->get();
        $latestTickets = Ticket::with('client')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'closedTickets',
            'totalUsers',
            'adminCount',
            'agentCount',
            'clientCount',
            'activeAgents',
            'activeClients',
            'latestUsers',
            'latestTickets'
        ));
    }

    public function ticketsIndex()
    {
        $tickets = Ticket::with(['client', 'agent'])->latest()->paginate(15);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function assignAgent(Request $request, Ticket $ticket)
{
    $request->validate([
        'agent_id' => 'required|exists:users,id',
    ]);

    $ticket->agent_id = $request->agent_id;

    // Charger l'agent assigné
    $agent = User::where('id', $request->agent_id)->firstOrFail();

    // Définir la date d'échéance si elle est vide
    if (is_null($ticket->due_date)) {
        $ticket->due_date = now()->addWeek();
    }

    $ticket->save();

    return redirect()->route('admin.dashboard', $ticket->id)
                     ->with('success', 'Agent assigné avec succès');
}

    public function show($id)
    {
        $ticket = Ticket::with(['attachments', 'comments.user', 'agent'])->findOrFail($id);
        $agents = User::where('role', 'agent')->get();

        return view('admin.tickets.show', compact('ticket', 'agents'));
    }

    public function edit(Ticket $ticket)
    {
        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:ouvert,en_cours,resolu,ferme',
            'priority' => 'required|string|in:basse,moyenne,haute',
            'category' => 'required|string|max:255',
        ]);

        $ticket->update($validated);

        $message = 'Le statut de votre ticket "' . $ticket->title . '" a été mis à jour par un administrateur à "' . $ticket->status . '".';

        // Notifier le client
        if ($ticket->client) {
            $ticket->client->notify(new TicketUpdated($ticket, $message));
        }

        // Notifier l'agent
        if ($ticket->agent) {
            $ticket->agent->notify(new TicketUpdated($ticket, $message));
        }

        return redirect()->route('admin.tickets.show', $ticket->id)
            ->with('success', 'Ticket mis à jour avec succès.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Ticket supprimé avec succès.');
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function usersIndex()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:client,agent,admin',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès!');
    }
}
