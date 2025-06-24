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
        $tickets = Ticket::all()->sortByDesc('created_at');
        $agents = User::where('role', 'agent')->get();

        $ticketCount = $tickets->count();
        $openTickets = $tickets->where('status', 'ouvert')->count();
        $inProgressTickets = $tickets->where('status', 'en_cours')->count();
        $resolvedTickets = $tickets->where('status', 'resolu')->count();
        $closedTickets = $tickets->where('status', 'ferme')->count();

        return view('admin.dashboard', compact('tickets', 'agents', 'ticketCount', 'openTickets', 'inProgressTickets', 'resolvedTickets', 'closedTickets'));
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
