<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Listing Utilisateurs – Auto-École JANOUB</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #333; }
        .header { background: #0f172a; color: #fff; padding: 20px; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f1f5f9; font-weight: bold; }
        .badge { padding: 2px 6px; border-radius: 4px; color: #fff; font-size: 8px; text-transform: uppercase; }
        .role-admin { background: #ef4444; }
        .role-assistante { background: #f59e0b; }
        .role-moniteur { background: #3b82f6; }
        .role-candidat { background: #10b981; }
        .status-active { color: #10b981; }
        .status-inactive { color: #ef4444; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚗 Auto-École JABOUB – Liste des Utilisateurs</h1>
        <p>Généré le {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Créé le</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    <span class="badge role-{{ $user->role->value }}">
                        {{ $user->role->value }}
                    </span>
                </td>
                <td class="status-{{ $user->is_active ? 'active' : 'inactive' }}">
                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                </td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
