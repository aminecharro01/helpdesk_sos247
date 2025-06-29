<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center" data-aos="fade-up">
            <h2 class="h3 mb-0 text-primary">
    <i class="bi bi-shield-lock me-2"></i> Tableau de bord administrateur
</h2>
        </div>
    </x-slot>

    <div class="py-4" data-aos="fade-up">
        <div class="container-fluid">
            <!-- Statistics -->
            <div class="row g-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 bg-primary text-white">
                        <div class="card-body text-center">
                            <h3 class="fw-bold mb-2 text-white">Utilisateurs totaux</h3>
                            <p class="display-6 mb-0">{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 bg-info text-white">
                        <div class="card-body text-center">
                            <h3 class="fw-bold mb-2 text-white">Tickets totaux</h3>
                            <p class="display-6 mb-0">{{ $totalTickets }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 bg-success text-white">
                        <div class="card-body text-center">
                            <h3 class="fw-bold mb-2 text-white">Agents actifs</h3>
                            <p class="display-6 mb-0">{{ $activeAgents }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 bg-warning text-white">
                        <div class="card-body text-center">
                            <h3 class="fw-bold mb-2 text-white">Clients actifs</h3>
                            <p class="display-6 mb-0">{{ $activeClients }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Distribution Chart -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-primary">
                        <i class="bi bi-pie-chart me-2"></i> Répartition des utilisateurs
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="userDistributionChart" class="mx-auto" style="max-width: 300px;"></canvas>
                </div>
            </div>

            <!-- Latest Users -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-primary">
    <i class="bi bi-people me-2"></i> Derniers utilisateurs
</h3>
                </div>
                <div class="card-body">
                    @if ($latestUsers->isEmpty())
                        <p class="text-muted mb-0">Aucun utilisateur pour le moment.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
<th>Email</th>
<th>Rôle</th>
<th>Inscrit le</th>
<th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestUsers as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'agent' ? 'info' : 'success') }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                                    Voir
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

            <!-- Derniers tickets -->
            <div class="card" data-aos="fade-up" data-aos-delay="400">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-primary">
    <i class="bi bi-ticket-detailed me-2"></i> Derniers tickets
</h3>
                </div>
                <div class="card-body">
                    @if ($latestTickets->isEmpty())
                        <p class="text-muted mb-0">Aucun ticket pour le moment.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Client</th>
                                        <th>Agent</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestTickets as $ticket)
                                        <tr>
                                            <td>{{ $ticket->title }}</td>
                                            <td>{{ $ticket->client->name }}</td>
                                            <td>{{ $ticket->agent ? $ticket->agent->name : 'Unassigned' }}</td>
                                            @php
                                                $statusClasses = [
                                                    'ouvert' => 'bg-info text-white',
                                                    'en_cours' => 'bg-warning text-white',
                                                    'resolu' => 'bg-success text-white',
                                                    'ferme' => 'bg-danger text-white',
                                                ];
                                            @endphp
                                            <td>
                                                <span class="badge {{ $statusClasses[$ticket->status] ?? 'bg-secondary' }}">
                                                    {{ ucfirst($ticket->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                                    View
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
        window.adminCount = {{ $adminCount }};
        window.agentCount = {{ $agentCount }};
        window.clientCount = {{ $clientCount }};
    </script>

    <!-- Chart.js Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('userDistributionChart');
            if (ctx && window.Chart) {
                new window.Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Administrateurs', 'Agents', 'Clients'],
                        datasets: [{
                            data: [window.adminCount, window.agentCount, window.clientCount],
                            backgroundColor: ['#dc3545', '#0dcaf0', '#198754'],
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
