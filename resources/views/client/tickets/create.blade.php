<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 mb-0 fw-bold text-primary">
            <i class="bi bi-plus-circle me-2"></i>{{ __('Créer un nouveau ticket') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white fw-bold">
                            <i class="bi bi-ticket-detailed me-2"></i> Nouveau Ticket
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Oups !</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('client.tickets.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Titre</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="attachments" class="form-label">Pièces jointes</label>
                                    <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                                </div>
                                <div class="d-grid pt-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-send me-1"></i>Créer le ticket
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
