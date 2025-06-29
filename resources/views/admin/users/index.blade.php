<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h3 mb-0 text-primary">
                <i class="bi bi-people me-2"></i> Gestion des utilisateurs
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour au tableau de bord
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-primary">Liste des utilisateurs</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div id="success-message" class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span><strong>Succès :</strong> {{ session('success') }}</span>
                        </div>
                    @elseif (session('error'))
                        <div id="error-message" class="alert alert-danger d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <span><strong>Erreur :</strong> {{ session('error') }}</span>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : ($user->role === 'agent' ? 'info' : 'secondary') }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="d-flex gap-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-success">
                                                <i class="bi bi-pencil-square me-1"></i> Modifier
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash me-1"></i> Supprimer
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
