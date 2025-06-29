<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 text-dark">
            Modifier l'utilisateur
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

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Rôle</label>
                            <select name="role" id="role" class="form-select">
                                <option value="client" {{ $user->role === 'client' ? 'selected' : '' }}>Client</option>
                                <option value="agent" {{ $user->role === 'agent' ? 'selected' : '' }}>Agent</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div class="mt-4 d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-50">Annuler</a>
                            <button type="submit" class="btn btn-success w-50">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
