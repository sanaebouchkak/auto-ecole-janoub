<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Export Paiements – Auto-École</title>
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
        .summary-bar {
            display: flex;
            gap: 20px;
            margin: 0 30px 20px;
            padding: 14px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }
        .summary-bar .item { flex: 1; text-align: center; }
        .summary-bar .item .val { font-size: 16px; font-weight: 700; color: #10b981; }
        .summary-bar .item .lbl { font-size: 9px; color: #64748b; text-transform: uppercase; margin-top: 2px; }
        .badge {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 3px 8px;
            border-radius: 999px;
            color: #fff;
        }
        .badge.paye    { background: #10b981; }
        .badge.partiel { background: #f59e0b; }
        .badge.non_paye{ background: #ef4444; }
        table {
            width: calc(100% - 60px);
            margin: 0 30px;
            border-collapse: collapse;
        }
        thead tr { background: #f1f5f9; }
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
        .total-row td { font-weight: 700; background: #f0fdf4; border-top: 2px solid #10b981; }
        .footer {
            margin: 24px 30px 0;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>💰 Auto-École – Rapport des Paiements</h1>
        <p>Généré le {{ \Carbon\Carbon::now()->translatedFormat('d F Y à H:i') }} | Total : {{ $paiements->count() }} paiement(s)</p>
    </div>

    <div class="summary-bar">
        <div class="item">
            <div class="val">{{ number_format($paiements->sum('montant'), 0, ',', ' ') }} DH</div>
            <div class="lbl">Total encaissé</div>
        </div>
        <div class="item">
            <div class="val">{{ $paiements->where('statut', 'paye')->count() }}</div>
            <div class="lbl">Payés</div>
        </div>
        <div class="item">
            <div class="val">{{ $paiements->where('statut', 'partiel')->count() }}</div>
            <div class="lbl">Partiels</div>
        </div>
        <div class="item">
            <div class="val">{{ $paiements->where('statut', 'non_paye')->count() }}</div>
            <div class="lbl">Non payés</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Candidat</th>
                <th>Formation</th>
                <th>Montant</th>
                <th>Méthode</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($paiements as $i => $paiement)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</td>
                <td>{{ optional(optional($paiement->candidat)->user)->name ?? 'N/A' }}</td>
                <td>{{ optional($paiement->formation)->nom ?? 'N/A' }}</td>
                <td><strong>{{ number_format($paiement->montant, 0, ',', ' ') }} DH</strong></td>
                <td>{{ ucfirst($paiement->methode_paiement) }}</td>
                <td>
                    <span class="badge {{ $paiement->statut }}">{{ str_replace('_', ' ', $paiement->statut) }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; color:#94a3b8; padding:20px;">Aucun paiement enregistré.</td>
            </tr>
            @endforelse
            @if($paiements->count() > 0)
            <tr class="total-row">
                <td colspan="4" style="text-align:right;">TOTAL</td>
                <td>{{ number_format($paiements->sum('montant'), 0, ',', ' ') }} DH</td>
                <td colspan="2"></td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Auto-École App – Document confidentiel – Généré automatiquement</p>
    </div>
</body>
</html>
