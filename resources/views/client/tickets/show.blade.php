<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 mb-0 fw-bold text-primary">
            <i class="bi bi-ticket-detailed me-2"></i>{{ __('Détails du ticket') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white fw-bold">
                            <i class="bi bi-ticket-detailed me-2"></i> Ticket #{{ $ticket->id }}
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

                            <!-- Title & Description -->
                            <h3 class="fw-bold mb-2 text-primary">{{ $ticket->title }}</h3>
                            <p class="mb-4">{{ $ticket->description }}</p>

                            <!-- Status, Priority, Category -->
                            <div class="row mb-4 gy-2">
                                <div class="col-12 col-md-4">
                                    <span class="text-muted small">Statut</span><br>
                                    @php
                                        $statusBadge = match($ticket->status) {
                                            'ouvert' => 'bg-info',
                                            'en_cours' => 'bg-warning',
                                            'resolu' => 'bg-success',
                                            'ferme' => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusBadge }} text-white px-3 py-2">{{ ucfirst($ticket->status) }}</span>
                                </div>
                                <div class="col-12 col-md-4">
                                    <span class="text-muted small">Priorité</span><br>
                                    @php
                                        $priorityBadge = match($ticket->priority) {
                                            'basse' => 'bg-success',
                                            'moyenne' => 'bg-warning',
                                            'haute' => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $priorityBadge }} text-white px-3 py-2">{{ ucfirst($ticket->priority) }}</span>
                                </div>
                                <div class="col-12 col-md-4">
                                    <span class="text-muted small">Catégorie</span><br>
                                    <span class="badge bg-secondary text-white px-3 py-2">{{ $ticket->category->name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Attachments -->
                            <div class="mb-4">
                                <span class="text-muted small">Pièces jointes</span><br>
                                @if ($ticket->attachments->count())
                                    <ul class="list-group list-group-flush mt-2 mb-0">
                                        @foreach ($ticket->attachments as $attachment)
                                            <li class="list-group-item d-flex align-items-center">
                                                <i class="bi bi-paperclip me-2"></i>
                                                @php
    $ext = strtolower(pathinfo($attachment->file_path, PATHINFO_EXTENSION));
@endphp
@if (in_array($ext, ['png', 'jpg', 'jpeg']))
    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
        <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="{{ $attachment->filename }}" style="max-height: 100px; max-width: 120px; margin-right: 10px; border-radius: 4px; border: 1px solid #ddd;">
        {{ $attachment->filename }}
    </a>
@else
    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">{{ $attachment->filename }}</a>
@endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Aucune pièce jointe.</span>
                                @endif
                            </div>

                            <!-- Comments -->
                            <div class="mb-4">
                                <span class="text-muted small">Commentaires</span><br>
                                @if ($ticket->comments->count())
                                    <div class="mt-2">
                                        @foreach($ticket->comments as $comment)
    <div class="p-3 {{ $loop->index % 2 == 0 ? 'bg-light' : 'bg-white' }} border rounded mb-2">
        <strong>{{ $comment->user->name ?? 'Utilisateur' }}</strong> <span class="text-muted">({{ $comment->created_at->diffForHumans() }})</span>
        <p class="mb-0">{{ $comment->content }}</p>
    </div>
@endforeach
                                    </div>
                                @else
                                    <span class="text-muted">Aucun commentaire pour ce ticket.</span>
                                @endif
                            </div>

                            <!-- Add Comment Form (if allowed) -->
                            @if (auth()->check())
                                <form action="{{ route('client.tickets.addComment', $ticket->id) }}" method="POST" class="mt-3">
    @csrf
    <div class="mb-3">
        <label for="content" class="form-label">Ajouter un commentaire</label>
        <textarea name="content" id="content" rows="3" class="form-control" required>{{ old('content') }}</textarea>
        @error('content')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-chat-dots me-1"></i>Envoyer
        </button>
    </div>
</form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
