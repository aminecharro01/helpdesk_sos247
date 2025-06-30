<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h3 mb-0 text-primary">
                <i class="bi bi-list-task me-2"></i>Mes Tickets
            </h2>
            <a href="{{ route('client.tickets.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Nouveau Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-primary">Liste de vos tickets</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div><strong>Succès :</strong> {{ session('success') }}</div>
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger d-flex align-items-center mb-4">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <div><strong>Erreur :</strong> {{ session('error') }}</div>
                        </div>
                    @endif

                    <!-- Filtres -->
                    <form method="GET" action="{{ route('client.tickets.index') }}" class="row g-3 align-items-end mb-4">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Statut</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Tous</option>
                                <option value="ouvert" {{ request('status') == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                                <option value="en_cours" {{ request('status') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="resolu" {{ request('status') == 'resolu' ? 'selected' : '' }}>Résolu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="priority" class="form-label">Priorité</label>
                            <select name="priority" id="priority" class="form-select">
                                <option value="">Toutes</option>
                                <option value="basse" {{ request('priority') == 'basse' ? 'selected' : '' }}>Basse</option>
                                <option value="moyenne" {{ request('priority') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                <option value="haute" {{ request('priority') == 'haute' ? 'selected' : '' }}>Haute</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Catégorie</label>
                            <select name="category" id="category" class="form-select">
                                <option value="" selected>Toutes</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="bi bi-funnel me-1"></i>Filtrer
                            </button>
                        </div>
                    </form>

                    <!-- Tableau des tickets -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Statut</th>
                                    <th>Priorité</th>
                                    <th>Catégorie</th>
                                    <th class="text-center">Fichiers</th>
                                    <th>Agent</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($tickets as $ticket)
                                    <tr>
                                        <td>{{ Str::limit($ticket->title, 30) }}</td>
                                        <td>
                                            <span class="badge bg-{{ match($ticket->status) {
                                                'ouvert' => 'success',
                                                'en_cours' => 'info',
                                                'resolu' => 'primary',
                                                'ferme' => 'secondary',
                                                default => 'secondary'
                                            } }}">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->status ?? 'Inconnu')) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ match($ticket->priority) {
                                                'basse' => 'secondary',
                                                'moyenne' => 'warning',
                                                'haute' => 'danger',
                                                default => 'secondary'
                                            } }}">
                                                {{ ucfirst($ticket->priority ?? 'Inconnue') }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst($ticket->category) }}</td>
                                        <td class="text-center">
                                            @if($ticket->attachments->count())
                                                <i class="bi bi-paperclip text-primary"></i>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($ticket->agent)
                                                <span class="text-muted">{{ $ticket->agent->name }}</span>
                                            @else
                                                <span class="fst-italic text-secondary">Non assigné</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('client.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i> Voir
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-danger fst-italic">Aucun ticket disponible</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $tickets->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
                                    
    <style>
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>

    <!-- JS pour auto-disparition des messages -->
    <script>
        window.onload = function() {
            setTimeout(function() {
                ['success-message', 'error-message'].forEach(function(id) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.style.transition = "opacity 2s";
                        el.style.opacity = 0;
                        setTimeout(() => el.style.display = 'none', 2000);
                    }
                });
            }, 2000);
        };
    </script>
</x-app-layout>
