<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Détails du ticket') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6 space-y-6">

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

                <!-- Informations principales -->
                <div>
                    <h3 class="text-3xl font-semibold text-gray-800">{{ $ticket->title }}</h3>
                    <p class="text-gray-700 mt-2">{{ $ticket->description }}</p>
                    
                    <div class="mt-4 space-y-2">
                        <p>
                            <strong>Statut:</strong>
                            @php
                                $statusColors = [
                                    'ouvert' => 'bg-blue-100 text-blue-700',
                                    'en cours' => 'bg-yellow-100 text-yellow-700',
                                    'resolu' => 'bg-green-100 text-green-700',
                                    'ferme' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="inline-block px-2 py-1 rounded-full text-sm font-semibold {{ $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </p>
                        <p>
                            <strong>Priorité:</strong>
                            @php
                                $priorityColors = [
                                    'haute' => 'bg-red-100 text-red-700',
                                    'moyenne' => 'bg-yellow-100 text-yellow-700',
                                    'basse' => 'bg-blue-100 text-blue-700',
                                ];
                            @endphp
                            <span class="inline-block px-2 py-1 rounded-full text-sm font-semibold {{ $priorityColors[$ticket->priority] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </p>
                        <p><strong>Catégorie:</strong> {{ $ticket->category }}</p>
                    </div>
                </div>

                <!-- Date d'échéance -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-800 mb-2">Date d'échéance</h4>
                    @if ($ticket->due_date)
                        <span class="text-red-600 font-semibold">{{ $ticket->due_date }}</span>
                    @else
                        <span class="text-gray-500">Aucune date d'échéance définie.</span>
                    @endif
                </div>

                <!-- Agent assigné -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-800 mb-2">Agent assigné</h4>
                    @if ($ticket->agent)
                        <p class="text-gray-700">{{ $ticket->agent->name }}</p>
                    @else
                        <p class="text-gray-500">Aucun agent assigné.</p>
                    @endif
                </div>

                <!-- Formulaire assignation -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-800 mb-2">Assigner un agent</h4>
                    <form action="{{ route('admin.tickets.assignAgent', $ticket->id) }}" method="POST" class="flex flex-col sm:flex-row items-center sm:space-x-4 space-y-2 sm:space-y-0">
                        @csrf
                        <select name="agent_id" class="border-gray-300 rounded px-3 py-2 w-full sm:w-auto">
                            <option value="">Sélectionner un agent</option>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}" {{ $ticket->agent_id == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Assigner
                        </button>
                    </form>
                </div>

                <!-- Commentaires -->
                <div>
                    <h4 class="font-medium text-gray-800 mb-2">Commentaires</h4>
                    <ul class="space-y-2">
                        @forelse ($ticket->comments as $comment)
                            <li class="bg-gray-100 p-3 rounded shadow-sm">
                                <span class="font-semibold text-gray-700">{{ $comment->user->name }}:</span>
                                <span class="text-gray-600">{{ $comment->content }}</span>
                            </li>
                        @empty
                            <li class="text-gray-500">Aucun commentaire.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Pièces jointes -->
                <div>
                    <h4 class="font-medium text-gray-800 mb-2">Pièces jointes</h4>
                    <ul class="list-disc list-inside space-y-1 text-blue-600">
                        @forelse ($ticket->attachments as $attachment)
                            <li>
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="hover:underline transition">
                                    {{ basename($attachment->file_path) }}
                                </a>
                            </li>
                        @empty
                            <li class="text-gray-500">Aucune pièce jointe.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-2 sm:space-y-0">
                    <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition shadow">
                            Supprimer le ticket
                        </button>
                    </form>
                    <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition shadow text-center">
                        Modifier ce ticket
                    </a>
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
