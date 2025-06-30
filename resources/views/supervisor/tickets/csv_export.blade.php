<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Export CSV – Liste des Tickets</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .logo img {
            height: 45px;
        }
        .date-export {
            font-size: 13px;
            text-align: right;
        }
        h2 {
            text-align: center;
            margin-bottom: 18px;
            color: #222;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #000;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .small-text {
            font-size: 10.5px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ public_path('logo.png') }}" alt="Logo" style="height:28px;max-height:28px;width:auto;object-fit:contain;display:inline-block;">
        </div>
        <div class="date-export">
            Exporté le : {{ now()->format('d/m/Y H:i') }}
        </div>
    </header>
    <h2>Liste des Tickets – Export CSV</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Client</th>
                <th>Agent Assigné</th>
                <th>Priorité</th>
                <th>Statut</th>
                <th>Créé le</th>
                <th>Mis à jour le</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->client->name ?? 'Inconnu' }}</td>
                    <td>{{ $ticket->agent->name ?? 'Non assigné' }}</td>
                    <td>{{ ucfirst($ticket->priority ?? '—') }}</td>
                    <td>{{ ucfirst($ticket->status ?? '—') }}</td>
                    <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $ticket->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
