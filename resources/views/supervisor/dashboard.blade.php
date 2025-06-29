<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-3 text-primary">Tableau de Bord Superviseur</h2>
    </x-slot>

    <div class="container py-5">
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-primary h-100 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Tickets Total</h5>
                        <p class="display-6 fw-bold">{{ $totalTickets }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-warning h-100 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Tickets Ouverts</h5>
                        <p class="display-6 fw-bold">{{ $openTickets }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-success h-100 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Tickets Fermés</h5>
                        <p class="display-6 fw-bold">{{ $closedTickets }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-info h-100 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Agents</h5>
                        <p class="display-6 fw-bold">{{ $agentCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="card text-white bg-secondary h-100 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Clients</h5>
                        <p class="display-6 fw-bold">{{ $clientCount }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card text-white bg-danger shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title">Temps de Résolution Moyen (SLA)</h5>
                        <p class="display-6 fw-semibold mt-3">
                            @php
                                $seconds = $averageResolutionTimeInSeconds;
                                if ($seconds > 0) {
                                    $days = floor($seconds / (3600*24)); $seconds -= $days * 3600 * 24;
                                    $hours = floor($seconds / 3600); $seconds -= $hours * 3600;
                                    $minutes = floor($seconds / 60); $seconds -= $minutes * 60;
                                    echo "{$days}j {$hours}h {$minutes}m {$seconds}s";
                                } else { echo "N/A"; }
                            @endphp
                        </p>
                    </div>
                </div>
            </div>
        </div>


    

        <!-- Charts -->
        <div class="row g-4 mb-4">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Activité des Tickets (7 derniers jours)</h5>
                        <canvas id="ticketActivityChart" height="120"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row g-4 mb-4">
        <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Répartition par Priorité</h5>
                        <canvas id="priorityPieChart"></canvas>
                    </div>
                </div>
        
            </div>
            <div class="col-lg-6">
            <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Répartition par Statut</h5>
                        <canvas id="statusPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Agent Workload and Latest Tickets -->
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Charge de Travail des Agents</h5>
                        <table class="table table-sm table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Agent</th>
                                    <th class="text-end">Tickets Ouverts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($agentWorkload as $agent)
                                    <tr>
                                        <td>{{ $agent->name }}</td>
                                        <td class="text-end">{{ $agent->assigned_tickets_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Aucun agent trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Derniers Tickets</h5>
                        <table class="table table-hover mt-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Titre</th>
                                    <th>Client</th>
                                    <th>Agent</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestTickets as $ticket)
                                    <tr>
                                        <td>{{ Str::limit($ticket->title, 25) }}</td>
                                        <td>{{ $ticket->client->name }}</td>
                                        <td>{{ $ticket->agent->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge {{ $ticket->status === 'ouvert' ? 'bg-warning text-dark' : 'bg-success' }}">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Aucun ticket récent.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Activity Line Chart
            new Chart(document.getElementById('ticketActivityChart'), {
                type: 'line',
                data: {
                    labels: {!! $chartLabels !!},
                    datasets: [
                        {
                            label: 'Tickets Créés',
                            data: {!! $createdTicketsChart !!},
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Tickets Fermés',
                            data: {!! $closedTicketsChart !!},
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });

            // Priority Pie Chart
            new Chart(document.getElementById('priorityPieChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($priorityLabels) !!},
                    datasets: [{
                        data: {!! json_encode($priorityValues) !!},
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
                    }]
                },
                options: { responsive: true }
            });

            // Status Pie Chart
            new Chart(document.getElementById('statusPieChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($statusLabels) !!},
                    datasets: [{
                        data: {!! json_encode($statusValues) !!},
                        backgroundColor: ['#FFCD56', '#4BC0C0']
                    }]
                },
                options: { responsive: true }
            });
        });
    </script>
</x-app-layout>
