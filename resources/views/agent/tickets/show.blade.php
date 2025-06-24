<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails du ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

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

                <!-- Titre et Description -->
                <div class="mb-6">
                    <h3 class="font-semibold text-lg text-gray-900">{{ $ticket->title }}</h3>
                    <p class="text-gray-600 mt-2">{{ $ticket->description }}</p>
                </div>

                <!-- Commentaires -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">Commentaires :</h4>
                    <ul class="space-y-4 mt-2">
                        @foreach($ticket->comments as $comment)
                            <li class="bg-gray-100 p-4 rounded-lg shadow-sm transition duration-300 hover:bg-gray-200">
                                <strong class="text-sm text-blue-600">{{ $comment->user->name }} :</strong>
                                <p class="mt-1 text-gray-700">{{ $comment->content }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Pièces jointes -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">Pièces jointes :</h4>
                    <ul class="space-y-2 mt-2">
                        @foreach($ticket->attachments as $attachment)
                            <li>
                                <a href="{{ Storage::url($attachment->file_path) }}" class="text-blue-600 hover:text-blue-800 transition duration-300" download>
                                    📎 {{ basename($attachment->file_path) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Formulaire de commentaire -->
                <div class="mb-6">
                    <form method="POST" action="{{ route('agent.tickets.comment', $ticket->id) }}">
                        @csrf
                        <div class="mt-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Ajouter un commentaire</label>
                            <textarea name="content" id="content" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required></textarea>
                        </div>
                        <button type="submit" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">Ajouter le commentaire</button>
                    </form>
                </div>

                <!-- Formulaire de mise à jour du statut -->
                <div class="mb-6">
                    <form method="POST" action="{{ route('agent.tickets.update', $ticket->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mt-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="en_cours" {{ $ticket->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="resolu" {{ $ticket->status == 'resolu' ? 'selected' : '' }}>Résolu</option>
                                <option value="ouvert" {{ $ticket->status == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                                <option value="ferme" {{ $ticket->status == 'ferme' ? 'selected' : '' }}>Fermé</option>
                            </select>
                        </div>
                        <button type="submit" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">Mettre à jour le statut</button>
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
