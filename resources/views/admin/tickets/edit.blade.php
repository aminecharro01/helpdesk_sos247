<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Modifier le ticket') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Titre -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $ticket->title) }}"
                            class="w-full rounded border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                            required>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full rounded border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                            required>{{ old('description', $ticket->description) }}</textarea>
                    </div>

                    <!-- Statut -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select name="status" id="status"
                            class="w-full rounded border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                            required>
                            <option value="ouvert" {{ $ticket->status == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                            <option value="en_cours" {{ $ticket->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="resolu" {{ $ticket->status == 'resolu' ? 'selected' : '' }}>Résolu</option>
                            <option value="ferme" {{ $ticket->status == 'ferme' ? 'selected' : '' }}>Fermé</option>
                        </select>
                    </div>

                    <!-- Priorité -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priorité</label>
                        <select name="priority" id="priority"
                            class="w-full rounded border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                            required>
                            <option value="basse" {{ $ticket->priority == 'basse' ? 'selected' : '' }}>Basse</option>
                            <option value="moyenne" {{ $ticket->priority == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                            <option value="haute" {{ $ticket->priority == 'haute' ? 'selected' : '' }}>Haute</option>
                        </select>
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                        <input type="text" id="category" name="category" value="{{ old('category', $ticket->category) }}"
                            class="w-full rounded border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
                            required>
                    </div>

                    <!-- Soumettre -->
                    <div>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition">
                            Mettre à jour le ticket
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
