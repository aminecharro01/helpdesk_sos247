<?php

namespace App\Http\Controllers\User;

use App\Events\TicketCreated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::with('attachments')
            ->where('user_id', Auth::id())
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->priority, fn($q) => $q->where('priority', $request->priority))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->latest()
            ->paginate(10);

        $categories = Ticket::where('user_id', Auth::id())->distinct()->pluck('category');

        return view('client.tickets.index', compact('tickets', 'categories'));
    }

    public function create()
    {
        return view('client.tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:2048',
        ]);

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'ouvert',
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');

                $ticket->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'user_id' => Auth::id(),
                ]);
            }
        }

        event(new TicketCreated($ticket));

        return redirect()->route('client.tickets.index')->with('success', 'Ticket créé avec succès!');
    }

    public function show($id)
    {
        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($id);
        return view('client.tickets.show', compact('ticket'));
    }

    public function addComment(Request $request, $ticketId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($ticketId);

        $comment = Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('client.tickets.show', $ticket->id)->with('success', 'Commentaire ajouté avec succès!');
    }
}
