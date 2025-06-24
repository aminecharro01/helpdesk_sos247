<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Gestion des utilisateurs') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
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

                <!-- Tableau des utilisateurs -->
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="px-4 py-3 border-b">Nom</th>
                                <th class="px-4 py-3 border-b">Email</th>
                                <th class="px-4 py-3 border-b">Rôle</th>
                                <th class="px-4 py-3 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                                    <td class="px-4 py-2 border-b">{{ $user->email }}</td>
                                    <td class="px-4 py-2 border-b">{{ ucfirst($user->role) }}</td>
                                    <td class="px-4 py-2 border-b flex space-x-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                            Modifier
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
