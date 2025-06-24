<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Mes Tickets') }}
            </h2>
            <a href="{{ route('client.tickets.create') }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:scale-105 transform transition">
                + Nouveau Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl p-6 space-y-6">

                @if (session('success'))
                    <div id="success-message" class="flex items-center gap-2 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 animate-slide-down">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span><strong>Succès :</strong> {{ session('success') }}</span>
                    </div>
                @elseif (session('error'))
                    <div id="error-message" class="flex items-center gap-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 animate-slide-down">
                        <i class="fas fa-times-circle text-red-500"></i>
                        <span><strong>Erreur :</strong> {{ session('error') }}</span>
                    </div>
                @endif

                <!-- Filtres -->
                <form method="GET" action="{{ route('client.tickets.index') }}" class="mb-6 flex flex-wrap gap-4 items-end">
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700">Statut</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            <option value="">Tous</option>
                            <option value="ouvert" {{ request('status') == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                            <option value="en_cours" {{ request('status') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="resolu" {{ request('status') == 'resolu' ? 'selected' : '' }}>Résolu</option>
                        </select>
                    </div>
                    <div>
                        <label for="priority" class="block text-sm font-semibold text-gray-700">Priorité</label>
                        <select name="priority" id="priority" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            <option value="">Toutes</option>
                            <option value="basse" {{ request('priority') == 'basse' ? 'selected' : '' }}>Basse</option>
                            <option value="moyenne" {{ request('priority') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                            <option value="haute" {{ request('priority') == 'haute' ? 'selected' : '' }}>Haute</option>
                        </select>
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700">Catégorie</label>
                        <select name="category" id="category" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            <option value="" selected>Toutes</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:scale-105 transition">
                            Filtrer
                        </button>
                    </div>
                </form>

                <!-- Tableau des tickets -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Titre</th>
                                <th class="px-4 py-2 text-left">Statut</th>
                                <th class="px-4 py-2 text-left">Priorité</th>
                                <th class="px-4 py-2 text-left">Catégorie</th>
                                <th class="px-4 py-2 text-center">Fichiers</th>
                                <th class="px-4 py-2 text-left">Agent</th>
                                <th class="px-4 py-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2">{{ $ticket->title }}</td>
                                    <td class="px-4 py-2">
                                        @php
                                            $statusBg = [
                                                'ouvert' => 'bg-blue-100 text-blue-700',
                                                'en_cours' => 'bg-yellow-100 text-yellow-700',
                                                'resolu' => 'bg-green-100 text-green-700',
                                                'ferme' => 'bg-red-100 text-red-700',
                                            ];
                                            $priorityBg = [
                                                'basse' => 'bg-green-100 text-green-700',
                                                'moyenne' => 'bg-yellow-100 text-yellow-700',
                                                'haute' => 'bg-red-100 text-red-700',
                                            ];
                                        @endphp
                                    
                                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $statusBg[$ticket->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-4 py-2">
                                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $priorityBg[$ticket->priority] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ ucfirst($ticket->category) }}</td>
                                    <td class="px-4 py-2 text-center">
                                        @if($ticket->attachments->count())
                                        ✅
                                        @else
                                        —
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($ticket->agent)
                                            <span class="text-sm text-gray-700">{{ $ticket->agent->name }}</span>
                                        @else
                                            <span class="italic text-gray-400">Non assigné</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('client.tickets.show', $ticket->id) }}" class="text-indigo-600 hover:underline">Voir</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-red-500 italic">Aucun ticket disponible</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $tickets->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Animations CSS -->
    <style>
        .animate-slide-down {
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>

    <!-- JS pour auto-disparition -->
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
