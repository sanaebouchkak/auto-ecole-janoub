<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Listing Formations – Auto-École</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #333; }
        .header { background: #0f172a; color: #fff; padding: 20px; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f1f5f9; font-weight: bold; }
        .price { font-weight: bold; color: #10b981; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 Auto-École – Nos Formations</h1>
        <p>Généré le {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Prix (DH)</th>
                <th>Description</th>
                <th>Durée (est.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($formations as $formation)
            <tr>
                <td>#{{ str_pad($formation->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td><strong>{{ $formation->nom }}</strong></td>
                <td class="price">{{ number_format($formation->prix, 0, ',', ' ') }} DH</td>
                <td>{{ $formation->description }}</td>
                <td>-</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
