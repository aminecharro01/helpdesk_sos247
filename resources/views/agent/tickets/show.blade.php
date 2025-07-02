<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-semibold text-primary">
            {{ __('Détails du ticket') }}
        </h2>
    </x-slot>

    <div class="py-4 bg-light min-vh-100">
        <div class="container">
            <div class="card shadow-lg p-4">
                @if (session('success'))
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div><strong>Succès :</strong> {{ session('success') }}</div>
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <div><strong>Erreur :</strong> {{ session('error') }}</div>
                    </div>
                @endif
                <div class="mb-4">
                    <h3 class="h3 fw-bold text-dark">{{ $ticket->title }}</h3>
                    <p class="text-muted mt-2">{{ $ticket->description }}</p>
                </div>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item">
                        <strong>Statut :</strong>
                        @php
                            $statusClass = [
                                'ouvert' => 'badge bg-success',
                                'en_cours' => 'badge bg-warning text-dark',
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
                    <li class="list-group-item"><strong>Catégorie :</strong> {{ $ticket->category ?? '-' }}</li>
                    <li class="list-group-item"><strong>Créé le :</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</li>
                </ul>
                <div class="mb-4">
                    <h5 class="mb-3">Commentaires</h5>
                    <ul class="list-unstyled">
                        @forelse($ticket->comments as $comment)
                            <li class="d-flex align-items-start bg-light border border-secondary-subtle rounded p-3 mb-3">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold text-dark">{{ $comment->user->name }}</span>
                                        <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="mt-2 mb-0 text-body">{{ $comment->content }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="text-muted">Aucun commentaire.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="mb-4">
                    <h5 class="mb-3">Pièces jointes</h5>
                    <ul class="list-unstyled">
                        @forelse($ticket->attachments as $attachment)
                            <li>
                                @php
    $ext = strtolower(pathinfo($attachment->file_path, PATHINFO_EXTENSION));
@endphp
@if (in_array($ext, ['png', 'jpg', 'jpeg']))
    <a href="{{ Storage::url($attachment->file_path) }}" target="_blank">
        <img src="{{ Storage::url($attachment->file_path) }}" alt="{{ basename($attachment->file_path) }}" style="max-height: 100px; max-width: 120px; margin-right: 10px; border-radius: 4px; border: 1px solid #ddd;">
        {{ basename($attachment->file_path) }}
    </a>
@else
    <a href="{{ Storage::url($attachment->file_path) }}" class="text-primary text-decoration-none" download>
        <i class="bi bi-paperclip me-1"></i>{{ basename($attachment->file_path) }}
    </a>
@endif                                </a>
                            </li>
                        @empty
                            <li class="text-muted">Aucune pièce jointe.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="mb-4">
                    <form method="POST" action="{{ route('agent.tickets.comment', $ticket->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="content" class="form-label">Ajouter un commentaire</label>
                            <textarea name="content" id="content" rows="3" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter le commentaire</button>
                    </form>
                </div>
                <div class="mb-4">
                    <form method="POST" action="{{ route('agent.tickets.update', $ticket->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label">Statut</label>
                            <select name="status" id="status" class="form-select">
                                <option value="en_cours" {{ $ticket->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="resolu" {{ $ticket->status == 'resolu' ? 'selected' : '' }}>Résolu</option>
                                <option value="ouvert" {{ $ticket->status == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                                <option value="ferme" {{ $ticket->status == 'ferme' ? 'selected' : '' }}>Fermé</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Mettre à jour le statut</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
