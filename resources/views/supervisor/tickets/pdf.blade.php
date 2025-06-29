<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Export PDF Tickets</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #888; padding: 6px 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Liste des Tickets (Export PDF)</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Client</th>
                <th>Agent</th>
                <th>Priorité</th>
                <th>Statut</th>
                <th>Créé le</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->client->name }}</td>
                    <td>{{ $ticket->agent ? $ticket->agent->name : 'Non assigné' }}</td>
                    <td>{{ ucfirst($ticket->priority) }}</td>
                    <td>{{ ucfirst($ticket->status) }}</td>
                    <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
