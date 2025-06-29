<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-semibold text-primary">
            {{ __('Détails du ticket') }}
        </h2>
    </x-slot>

    <div class="py-4 bg-light min-vh-100">
        <div class="container">
            <div class="card shadow-lg p-4">

                {{-- Success/Error Messages --}}
                @if (session('success'))
                    <div id="success-message" class="alert alert-success d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div><strong>Succès :</strong> {{ session('success') }}</div>
                    </div>
                @elseif (session('error'))
                    <div id="error-message" class="alert alert-danger d-flex align-items-center">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <div><strong>Erreur :</strong> {{ session('error') }}</div>
                    </div>
                @endif

                {{-- Ticket Title and Description --}}
                <div class="mb-4">
                    <h3 class="h3 fw-bold text-dark">{{ $ticket->title }}</h3>
                    <p class="text-muted mt-2">{{ $ticket->description }}</p>
                </div>

                {{-- Ticket Details --}}
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item">
                        <strong>Statut :</strong>
                        @php
                            $statusClass = [
                                'ouvert' => 'badge bg-success',
                                'en cours' => 'badge bg-warning text-dark',
                                'resolu' => 'badge bg-primary',
                                'ferme' => 'badge bg-secondary'
                            ];
                        @endphp
                        <span class="{{ $statusClass[$ticket->status] ?? 'badge bg-light text-dark' }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </li>
                    <li class="list-group-item">
                        <strong>Priorité :</strong>
                        @php
                            $priorityClass = [
                                'haute' => 'badge bg-danger',
                                'moyenne' => 'badge bg-warning text-dark',
                                'basse' => 'badge bg-info text-dark'
                            ];
                        @endphp
                        <span class="{{ $priorityClass[$ticket->priority] ?? 'badge bg-light text-dark' }}">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </li>
                    <li class="list-group-item">
                        <strong>Catégorie :</strong> {{ $ticket->category }}
                    </li>
                </ul>

                {{-- Due Date --}}
                <div class="bg-light p-3 rounded mb-4 border">
                    <h5 class="mb-2">Date d'échéance</h5>
                    @if ($ticket->due_date)
                        <span class="text-danger fw-semibold">{{ $ticket->due_date }}</span>
                    @else
                        <span class="text-muted">Aucune date d'échéance définie.</span>
                    @endif
                </div>

                {{-- Assigned Agent --}}
                <div class="bg-light p-3 rounded mb-4 border">
                    <h5 class="mb-2">Agent assigné</h5>
                    @if ($ticket->agent)
                        <p class="text-body">{{ $ticket->agent->name }}</p>
                    @else
                        <p class="text-muted">Aucun agent assigné.</p>
                    @endif
                </div>

                {{-- Assign Agent Form --}}
                <div class="bg-light p-3 rounded mb-4 border">
                    <h5 class="mb-3">Assigner un agent</h5>
                    <form action="{{ route('admin.tickets.assignAgent', $ticket->id) }}" method="POST" class="row g-2">
                        @csrf
                        <div class="col-sm-8">
                            <select name="agent_id" class="form-select">
                                <option value="">Sélectionner un agent</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ $ticket->agent_id == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary w-100">Assigner</button>
                        </div>
                    </form>
                </div>

                {{-- Comments --}}
                <div class="mb-4">
                    <h5 class="mb-3">Commentaires</h5>
                    <ul class="list-group">
                        @forelse ($ticket->comments as $comment)
                            <li class="list-group-item">
                                <strong>{{ $comment->user->name }} :</strong> {{ $comment->content }}
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Aucun commentaire.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Attachments --}}
                <div class="mb-4">
                    <h5 class="mb-3">Pièces jointes</h5>
                    <ul class="list-unstyled">
                        @forelse ($ticket->attachments as $attachment)
                            <li>
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="text-primary text-decoration-none">
                                    <i class="bi bi-paperclip me-1"></i>{{ basename($attachment->file_path) }}
                                </a>
                            </li>
                        @empty
                            <li class="text-muted">Aucune pièce jointe.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Actions --}}
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            Supprimer le ticket
                        </button>
                    </form>
                    <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-success w-100">
                        Modifier ce ticket
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        window.onload = function () {
            setTimeout(() => {
                ['success-message', 'error-message'].forEach(id => {
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
