<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


use App\Notifications\TicketUpdated;
use Carbon\Carbon;

class AgentController extends Controller
{
    public function index(Request $request)
{
    $tickets = Ticket::where('agent_id', Auth::id())
        ->when($request->has('status'), function ($query) use ($request) {
            return $query->where('status', $request->status);
        })
        ->when($request->has('priority'), function ($query) use ($request) {
            return $query->where('priority', $request->priority);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Notifications non lues pour l'utilisateur connecté
    /** @var \App\Models\User $authUser */
    $authUser = Auth::user();
    $notifications = $authUser->unreadNotifications()->paginate(5);

    // Historique des actions récentes (les commentaires faits par l'agent connecté)
    $recentComments = Comment::where('user_id', Auth::id())
    ->with('ticket')
    ->latest('created_at')
    ->take(5)
    ->get();

    // Nombre de tickets résolus
    $todayResolvedTickets = Ticket::where('agent_id', Auth::id())
        ->where('status', 'resolu')
        ->whereDate('updated_at', Carbon::today())
        ->count();

    // Prochaines échéances (tickets assignés à l'agent avec une date d'échéance)
    $upcomingDeadlines = Ticket::where('agent_id', Auth::id())
        ->whereNotNull('due_date')
        ->whereDate('due_date', '>=', now())
        ->orderBy('due_date')
        ->take(5)
        ->get();

    // Historique des modifications de statut récentes
    $recentStatusChanges = Ticket::where('agent_id', Auth::id())
    ->whereNotNull('status')
    ->orderBy('updated_at', 'desc')
    ->take(5)
    ->get();

    return view('agent.dashboard', compact(
        'tickets', 
        'notifications', 
        'recentComments', 
        'todayResolvedTickets', 
        'upcomingDeadlines',
        'recentStatusChanges'
    ));
}

    public function show($id)
    {
        $ticket = Ticket::with(['comments.user', 'attachments'])->findOrFail($id);

        return view('agent.tickets.show', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
{
    $validated = $request->validate([
        'status' => 'required|string|in:ouvert,en_cours,resolu,ferme',
    ]);

    $ticket->update([
        'status' => $validated['status'],
    ]);

    if ($ticket->client) {
        $ticket->client->notify(new TicketUpdated($ticket, 'Le statut de votre ticket " ' . $ticket->title .' " a été changé par un agent a "' . $ticket->status . '".'));
    }

    return redirect()->route('agent.dashboard')->with('success', 'Ticket mis à jour avec succès.');
}

public function comment(Request $request, Ticket $ticket)
{
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $ticket->comments()->create([
        'user_id' => Auth::id(),
        'content' => $request->content,
    ]);

    if ($ticket->client) {
        $ticket->client->notify(new TicketUpdated($ticket, 'Un agent a répondu à votre ticket " ' . $ticket->title .' ".'));
    }

    return redirect()->route('agent.tickets.show', $ticket->id)->with('success', 'Commentaire ajouté avec succès.');
}


}
