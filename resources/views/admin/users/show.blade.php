<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-semibold text-primary">
                <i class="bi bi-person-badge me-2"></i> Détails utilisateur : {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste des utilisateurs
            </a>
        </div>
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
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item"><strong>ID :</strong> {{ $user->id }}</li>
                    <li class="list-group-item"><strong>Nom :</strong> {{ $user->name }}</li>
                    <li class="list-group-item"><strong>Email :</strong> {{ $user->email }}</li>
                    <li class="list-group-item">
                        <strong>Rôle :</strong>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'agent' ? 'info' : 'success') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </li>
                    <li class="list-group-item"><strong>Inscription :</strong> {{ $user->created_at->format('d/m/Y H:i') }}</li>
                    <li class="list-group-item"><strong>Dernière mise à jour :</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</li>
                </ul>
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-success">
                        <i class="bi bi-pencil-square me-1"></i> Modifier l'utilisateur
                    </a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i> Supprimer l'utilisateur
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
