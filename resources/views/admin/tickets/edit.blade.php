<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 text-dark">
            {{ __('Modifier le ticket') }}
        </h2>
    </x-slot>

    <div class="py-4 bg-light min-vh-100">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Titre -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $ticket->title) }}"
                                class="form-control" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="form-control" required>{{ old('description', $ticket->description) }}</textarea>
                        </div>

                        <!-- Statut -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Statut</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="ouvert" {{ $ticket->status == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                                <option value="en_cours" {{ $ticket->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="resolu" {{ $ticket->status == 'resolu' ? 'selected' : '' }}>Résolu</option>
                                <option value="ferme" {{ $ticket->status == 'ferme' ? 'selected' : '' }}>Fermé</option>
                            </select>
                        </div>

                        <!-- Priorité -->
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priorité</label>
                            <select name="priority" id="priority" class="form-select" required>
                                <option value="basse" {{ $ticket->priority == 'basse' ? 'selected' : '' }}>Basse</option>
                                <option value="moyenne" {{ $ticket->priority == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                <option value="haute" {{ $ticket->priority == 'haute' ? 'selected' : '' }}>Haute</option>
                            </select>
                        </div>

                        <!-- Catégorie -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Catégorie</label>
                            <input type="text" id="category" name="category" value="{{ old('category', $ticket->category) }}"
                                class="form-control" required>
                        </div>

                        <!-- Soumettre -->
                        <div class="mt-4 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success w-100">Modifier</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
