<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-3 text-primary">Gestion des Tickets - Superviseur</h2>
    </x-slot>

    <div class="container py-5">
        <div class="card shadow">
            <div class="card-body">
                
                <!-- Filtres -->
                <form method="GET" action="{{ route('superviseur.tickets.index') }}" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label class="form-label">Mot-clé</label>
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Titre ou client">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select">
                                <option value="">Tous</option>
                                <option value="ouvert" {{ request('status') == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                                <option value="fermé" {{ request('status') == 'fermé' ? 'selected' : '' }}>Fermé</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Priorité</label>
                            <select name="priority" class="form-select">
                                <option value="">Toutes</option>
                                <option value="urgente" {{ request('priority') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                <option value="haute" {{ request('priority') == 'haute' ? 'selected' : '' }}>Haute</option>
                                <option value="moyenne" {{ request('priority') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                <option value="faible" {{ request('priority') == 'faible' ? 'selected' : '' }}>Faible</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Agent</label>
                            <select name="agent_id" class="form-select">
                                <option value="">Tous</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date min</label>
                            <input type="date" name="created_from" value="{{ request('created_from') }}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date max</label>
                            <input type="date" name="created_to" value="{{ request('created_to') }}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('superviseur.tickets.export.csv', request()->all()) }}" class="btn btn-success me-2">Exporter CSV</a>
                            <a href="{{ route('superviseur.tickets.export.pdf', request()->all()) }}" class="btn btn-danger">Exporter PDF</a>
                        </div>
                    </div>
                </form>

                <!-- Messages de session -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Table des tickets -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Titre</th>
                                <th>Client</th>
                                <th>Agent actuel</th>
                                <th>Statut</th>
                                <th>Assigner à</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->title }}</td>
                                    <td>{{ $ticket->client->name }}</td>
                                    <td>{{ $ticket->agent->name ?? 'Non assigné' }}</td>
                                    <td>
                                        <span class="badge {{ $ticket->status === 'ouvert' ? 'bg-warning text-dark' : 'bg-success' }}">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('superviseur.tickets.assign', $ticket) }}" method="POST" class="d-flex">
                                            @csrf
                                            <select name="agent_id" class="form-select me-2">
                                                <option value="">Choisir un agent</option>
                                                @foreach ($agents as $agent)
                                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-outline-primary">Assigner</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Aucun ticket à afficher.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $tickets->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
