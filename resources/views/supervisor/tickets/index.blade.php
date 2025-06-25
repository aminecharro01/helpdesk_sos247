<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h3 mb-0 text-primary"><i class="bi bi-ticket-detailed me-2"></i> Tous les tickets</h2>
            <a href="{{ route('supervisor.dashboard') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Retour</a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th><th>Titre</th><th>Client</th><th>Agent</th><th>Statut</th><th>Priorité</th><th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ Str::limit($ticket->title,30) }}</td>
                                    <td>{{ $ticket->client->name ?? 'N/A' }}</td>
                                    <td>{{ $ticket->agent->name ?? '—' }}</td>
                                    <td>{{ ucfirst($ticket->status) }}</td>
                                    <td>{{ ucfirst($ticket->priority) }}</td>
                                    <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $tickets->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
