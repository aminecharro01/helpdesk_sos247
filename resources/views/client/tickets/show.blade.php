<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails du ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 space-y-6 transition duration-300 ease-in-out hover:scale-105">

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

                <!-- Titre et description -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $ticket->title }}</h3>
                    <p class="text-gray-600">{{ $ticket->description }}</p>
                </div>

                <!-- Statut, Priorité, Catégorie -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
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

                    <div class="transition duration-300 hover:scale-105">
                        <span class="block text-sm font-medium text-gray-500">Statut</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-semibold {{ $statusBg[$ticket->status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </div>

                    <div class="transition duration-300 hover:scale-105">
                        <span class="block text-sm font-medium text-gray-500">Priorité</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-semibold {{ $priorityBg[$ticket->priority] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </div>


                    <div class="transition duration-300 hover:scale-105">
                        <span class="block text-sm font-medium text-gray-500">Catégorie</span>
                        <span class="text-gray-800">{{ ucfirst($ticket->category) }}</span>
                    </div>
                </div>

                <!-- Agent assigné -->
                <div>
                    <span class="block text-sm font-medium text-gray-500">Agent assigné</span>
                    @if ($ticket->agent)
                        <span class="text-gray-800">{{ $ticket->agent->name }}</span>
                    @else
                        <span class="italic text-gray-400">Aucun agent assigné</span>
                    @endif
                </div>

                <!-- Pièces jointes -->
                <div class="transition duration-300 hover:translate-x-1">
                    <span class="block text-sm font-medium text-gray-500">Pièces jointes</span>
                    @if ($ticket->attachments->count())
                        <ul class="mt-2 space-y-1">
                            @foreach ($ticket->attachments as $attachment)
                                <li>
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" download aria-label="Télécharger {{ basename($attachment->file_path) }}" class="inline-flex items-center text-indigo-600 hover:underline transition duration-300">
                                        <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Télécharger {{ basename($attachment->file_path) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Aucune pièce jointe disponible.</p>
                    @endif
                </div>

                <!-- Commentaires -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Commentaires</h4>
                    @if($ticket->comments->count())
                        <ul class="space-y-4">
                            @foreach ($ticket->comments as $comment)
                                <li class="flex items-start bg-gray-50 border border-gray-200 rounded-xl p-4 transition duration-300 hover:shadow hover:translate-y-1">
                                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center font-bold text-lg">
                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4 w-full">
                                        <div class="flex justify-between items-center">
                                            <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mt-2 text-gray-700 leading-relaxed">
                                            {{ $comment->content }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Aucun commentaire pour l'instant.</p>
                    @endif
                </div>

                <!-- Ajouter un commentaire -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Ajouter un commentaire</h4>
                    <form method="POST" action="{{ route('client.tickets.addComment', $ticket->id) }}">
                        @csrf
                        <textarea name="content" required class="w-full border rounded p-2 mb-2 focus:ring focus:ring-indigo-300 transition duration-300" rows="4" placeholder="Écrivez votre commentaire..."></textarea>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow transition duration-300 hover:scale-105">
                            Poster le commentaire
                        </button>
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
