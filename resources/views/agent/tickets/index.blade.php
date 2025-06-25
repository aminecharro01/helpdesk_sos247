<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h3 mb-0 text-primary">
                <i class="bi bi-ticket-detailed me-2"></i> Tous mes tickets
            </h2>
            <a href="{{ route('agent.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour au tableau de bord
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-primary">Mes tickets</h3>
                </div>
                <div class="card-body">
                    @if ($tickets->isEmpty())
                        <p class="text-muted mb-0">Aucun ticket trouvé.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Titre</th>
                                        <th>Client</th>
                                        <th>Statut</th>
                                        <th>Priorité</th>
                                        <th>Créé le</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $ticket->id }}</td>
                                            <td>{{ Str::limit($ticket->title, 30) }}</td>
                                            <td>{{ $ticket->client->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ match($ticket->status) { 'ouvert' => 'success', 'en_cours' => 'info', 'resolu' => 'primary', 'ferme' => 'secondary' } }}">
                                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ match($ticket->priority) { 'basse' => 'secondary', 'moyenne' => 'warning', 'haute' => 'danger' } }}">
                                                    {{ ucfirst($ticket->priority) }}
                                                </span>
                                            </td>
                                            <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('agent.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $tickets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
