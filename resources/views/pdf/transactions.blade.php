<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des Transactions</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        h2 { text-align: center; }
    </style>
</head>
<body>
<h2>Historique des Transactions</h2>
<p><strong>Nom :</strong> {{ $user->name }}</p>
<p><strong>Numéro de compte :</strong> {{ $compte->numero_compte }}</p>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Type</th>
        <th>Montant (FCFA)</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($transactions as $index => $transaction)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ ucfirst($transaction->type) }}</td>
            <td>{{ number_format($transaction->montant, 0, ',', ' ') }}</td>
            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4">Aucune transaction trouvée.</td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>
</html>
