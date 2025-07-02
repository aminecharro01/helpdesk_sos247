<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center" data-aos="fade-up">
            <h2 class="h3 mb-0 text-primary">
                <i class="bi bi-person-circle me-2"></i> Tableau de bord client
            </h2>
            <a href="{{ route('client.tickets.create') }}" class="btn btn-primary" data-aos="fade-left" title="Créer un nouveau ticket">
                <i class="bi bi-plus-circle me-2"></i> Nouveau Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-4" data-aos="fade-up">
        <div class="container-fluid">
            <!-- Notifications -->
            <div class="card mb-4" data-aos="fade-up">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-primary">
                        <i class="bi bi-bell me-2 text-warning"></i> Notifications
                    </h3>
                </div>
                <div class="card-body">
                    <div id="notifications-list">
                        @if ($notifications->isEmpty())
                            <p class="text-muted mb-0">Aucune notification pour le moment.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($notifications as $notification)
                                    <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center {{ $notification->read_at ? '' : 'fw-bold text-primary' }}">
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link text-decoration-none p-0">
                                                @if(!$notification->read_at)
                                                    <i class="bi bi-circle-fill text-warning me-2"></i>
                                                @else
                                                    <i class="bi bi-circle text-muted me-2"></i>
                                                @endif
                                                {{ $notification->data['message'] ?? 'Notification' }}
                                            </button>
                                        </form>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-4">
    @if ($notifications->hasPages())
        <nav aria-label="Pagination notifications" class="d-flex justify-content-center">
            <ul class="pagination pagination-sm mb-0">
                {{-- Previous Page Link --}}
                @if ($notifications->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $notifications->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                @endif
                
                {{-- Pagination Elements --}}
                @foreach ($notifications->links()->elements[0] as $page => $url)
                    @if ($page == $notifications->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($notifications->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $notifications->nextPageUrl() }}" rel="next">&raquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </ul>
        </nav>
    @endif
</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="row g-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 bg-primary text-white">
                        <div class="card-body text-center">
                            <h3 class="fw-bold mb-2 text-white">Tickets totaux</h3>
                            <p class="display-6 mb-0">{{ $total }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 bg-info text-white">
                        <div class="card-body text-center">
                            <h3 class="fw-bold mb-2 text-white">Ouverts</h3>
                            <p class="display-6 mb-0">{{ $opened }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 bg-success text-white">
                        <div class="card-body text-center">
                            <h3 class="fw-bold mb-2 text-white">Résolus</h3>
                            <p class="display-6 mb-0">{{ $resolved }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 bg-warning text-white">
                        <div class="card-body text-center">
                            <h3 class="fw-bold mb-2 text-white">En cours</h3>
                            <p class="display-6 mb-0">{{ $inProgress }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphique de statut -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-primary">
                        <i class="bi bi-pie-chart me-2"></i> Répartition des statuts des tickets
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="ticketStatusChart" class="mx-auto" style="max-width: 300px;"></canvas>
                </div>
            </div>

            <!-- Conseils -->
            <div class="card mb-4 bg-light" data-aos="fade-up" data-aos-delay="300">
                <div class="card-body">
                    <h3 class="h5 mb-3 text-primary">
                        <i class="bi bi-lightbulb me-2 text-warning"></i> Conseils pour de meilleurs tickets
                    </h3>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Écrivez un titre clair et précis</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Joignez des captures d'écran pour illustrer votre problème</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Vérifiez régulièrement le statut de votre ticket depuis le tableau de bord</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i> Répondez rapidement aux messages des agents pour accélérer la résolution</li>
                    </ul>
                </div>
            </div>

            <!-- Derniers tickets -->
            <div class="card" data-aos="fade-up" data-aos-delay="400">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-primary">
                        <i class="bi bi-ticket-detailed me-2"></i> Derniers tickets
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if ($latestTickets->isEmpty())
                        <p class="text-muted m-4">Aucun ticket pour le moment.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Titre</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestTickets as $ticket)
                                        @php
                                            
                                            $badge = match($ticket->status) {
                                                'ouvert' => 'bg-info',
                                                'en_cours' => 'bg-warning',
                                                'resolu' => 'bg-success',
                                                'ferme' => 'bg-danger',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <tr class=" table-row-hover">
                                            <td class="fw-bold">{{ $ticket->title }}</td>
                                            <td><span class="badge {{ $badge }} text-white px-3 py-2">{{ ucfirst($ticket->status) }}</span></td>
                                            <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('client.tickets.show', $ticket->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-eye"></i> Voir
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])

    <!-- JS Data -->
    <script>
        window.opened = {{ $opened }};
        window.resolved = {{ $resolved }};
        window.inProgress = {{ $inProgress }};
        window.closedCount = {{ $close }}; // safer name than "close"
    </script>

    <!-- Chart.js Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('ticketStatusChart');
            const total = window.opened + window.resolved + window.inProgress + window.closedCount;

            if (ctx && window.Chart && total > 0) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Ouverts', 'Resolus', 'En cours', 'Fermes'],
                        datasets: [{
                            data: [window.opened, window.resolved, window.inProgress, window.closedCount],
                            backgroundColor: ['#0dcaf0', '#198754', '#ffc107', '#dc3545'],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                        }]
                    },
                    options: {
                        maintainAspectRatio: true,
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#6c757d',
                                    font: { size: 14 }
                                }
                            }
                        },
                        cutout: '70%',
                    }
                });
            }
        });
    </script>
</x-app-layout>
