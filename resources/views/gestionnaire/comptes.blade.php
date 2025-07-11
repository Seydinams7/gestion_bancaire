<!-- resources/views/compte/retrait.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retirer de l'Argent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Gestion des Comptes en Attente</h2>
        @foreach($comptes as $compte)
            <div>
                <p><strong>Numéro Compte:</strong> {{ $compte->numero_compte }}</p>
                <p><strong>Client:</strong> {{ $compte->user->name }} ({{ $compte->user->email }})</p>

                <form action="{{ route('gestionnaire.valider', $compte->id) }}" method="POST">
                    @csrf
                    <button type="submit">Valider</button>
                </form>

                <form action="{{ route('gestionnaire.rejeter', $compte->id) }}" method="POST">
                    @csrf
                    <input type="text" name="motif" placeholder="Motif du rejet">
                    <button type="submit">Rejeter</button>
                </form>
            </div>
            <hr>
        @endforeach
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
