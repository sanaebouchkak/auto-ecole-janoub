<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Séances – Auto-École</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #fff;
        }
        .header {
            background: #0f172a;
            color: #fff;
            padding: 24px 30px;
            margin-bottom: 24px;
        }
        .header h1 { font-size: 20px; font-weight: 700; letter-spacing: 1px; }
        .header p  { font-size: 11px; color: #94a3b8; margin-top: 4px; }
        .badge {
            display: inline-block;
            background: #10b981;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 3px 8px;
            border-radius: 999px;
        }
        .badge.blue   { background: #3b82f6; }
        .badge.gray   { background: #64748b; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 30px;
            width: calc(100% - 60px);
        }
        thead tr {
            background: #f1f5f9;
        }
        thead th {
            padding: 10px 12px;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }
        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 9px 12px; }
        .footer {
            margin: 24px 30px 0;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚗 Auto-École – Liste des Séances</h1>
        <p>Généré le {{ \Carbon\Carbon::now()->translatedFormat('d F Y à H:i') }} | Total : {{ $seances->count() }} séance(s)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Horaire</th>
                <th>Formation</th>
                <th>Moniteur</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($seances as $i => $seance)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($seance->date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($seance->heure_debut)->format('H:i') }} – {{ \Carbon\Carbon::parse($seance->heure_fin)->format('H:i') }}</td>
                <td>{{ optional($seance->formation)->nom ?? 'N/A' }}</td>
                <td>{{ optional(optional($seance->moniteur)->user)->name ?? 'N/A' }}</td>
                <td>
                    @if($seance->statut === 'disponible')
                        <span class="badge">Disponible</span>
                    @elseif($seance->statut === 'reservee')
                        <span class="badge blue">Réservée</span>
                    @else
                        <span class="badge gray">Terminée</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; color:#94a3b8; padding:20px;">Aucune séance enregistrée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <span>Auto-École App – Document confidentiel</span>
        <span>Page 1</span>
    </div>
</body>
</html>
