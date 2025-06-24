<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center" data-aos="fade-up">
            <h2 class="h3 mb-0 text-primary">
                <i class="bi bi-person-badge me-2"></i> {{ __('Agent Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4" data-aos="fade-up">
        <div class="container-fluid">
            <!-- Statistics -->
            <div class="row g-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-top border-top-4 border-primary">
                        <div class="card-body text-center">
                            <h3 class="text-muted mb-2">Total</h3>
                            <p class="h2 fw-bold text-primary mb-0">{{ $total }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-top border-top-4 border-info">
                        <div class="card-body text-center">
                            <h3 class="text-muted mb-2">Open</h3>
                            <p class="h2 fw-bold text-info mb-0">{{ $opened }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-top border-top-4 border-success">
                        <div class="card-body text-center">
                            <h3 class="text-muted mb-2">Resolved</h3>
                            <p class="h2 fw-bold text-success mb-0">{{ $resolved }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-top border-top-4 border-warning">
                        <div class="card-body text-center">
                            <h3 class="text-muted mb-2">In Progress</h3>
                            <p class="h2 fw-bold text-warning mb-0">{{ $inProgress }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Chart -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-primary">
                        <i class="bi bi-pie-chart me-2"></i> Ticket Status Distribution
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="ticketStatusChart" class="mx-auto" style="max-width: 300px;"></canvas>
                </div>
            </div>

            <!-- Latest Tickets -->
            <div class="card" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-primary">
                        <i class="bi bi-ticket-detailed me-2"></i> Latest Tickets
                    </h3>
                </div>
                <div class="card-body">
                    @if ($latestTickets->isEmpty())
                        <p class="text-muted mb-0">No tickets yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Client</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestTickets as $ticket)
                                        <tr>
                                            <td>{{ $ticket->title }}</td>
                                            <td>{{ $ticket->client->name }}</td>
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
                                                <a href="{{ route('agent.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
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
        window.opened = {{ $opened }};
        window.resolved = {{ $resolved }};
        window.inProgress = {{ $inProgress }};
        window.close = {{ $close }};
    </script>

    <!-- Chart.js Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('ticketStatusChart');
            if (ctx && window.Chart) {
                new window.Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Open', 'Resolved', 'In Progress', 'Closed'],
                        datasets: [{
                            data: [window.opened, window.resolved, window.inProgress, window.close],
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
