<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 text-primary"><i class="bi bi-speedometer2 me-2"></i> Tableau de bord superviseur</h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-top border-top-4 border-info text-center">
                        <div class="card-body">
                            <h3 class="text-muted">Tickets totaux</h3>
                            <p class="h2 fw-bold text-info mb-0">{{ $totalTickets }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-top border-top-4 border-success text-center">
                        <div class="card-body">
                            <h3 class="text-muted">Agents</h3>
                            <p class="h2 fw-bold text-success mb-0">{{ $agentCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-top border-top-4 border-primary text-center">
                        <div class="card-body">
                            <h3 class="text-muted">Clients</h3>
                            <p class="h2 fw-bold text-primary mb-0">{{ $clientCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h3 class="h5 text-primary mb-0"><i class="bi bi-ticket-detailed me-2"></i> Derniers tickets</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th><th>Titre</th><th>Client</th><th>Agent</th><th>Statut</th><th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestTickets as $t)
                                <tr>
                                    <td>{{ $t->id }}</td>
                                    <td>{{ Str::limit($t->title,30) }}</td>
                                    <td>{{ $t->client->name ?? 'N/A' }}</td>
                                    <td>{{ $t->agent->name ?? '—' }}</td>
                                    <td>{{ ucfirst($t->status) }}</td>
                                    <td>{{ $t->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
