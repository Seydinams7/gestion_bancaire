<!-- resources/views/compte/deposer.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déposer de l'Argent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header text-center">Déposer de l'Argent</div>
        <div class="card-body">
            <!-- Affichage du message de succès si disponible -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulaire de dépôt d'argent -->
            <form action="{{ route('bank.deposer') }}" method="POST">
                @csrf

                <!-- Sélection du compte bancaire -->
                <div class="mb-3">
                    <label for="compte_id" class="form-label">Sélectionner un compte</label>
                    <select name="compte_id" id="compte_id" class="form-control" required>
                        @foreach($comptes as $compte)
                            <option value="{{ $compte->id }}">{{ $compte->numero_compte }} - Solde: {{ $compte->solde }} FCFA</option>
                        @endforeach
                    </select>
                </div>

                <!-- Montant à déposer -->
                <div class="mb-3">
                    <label for="montant" class="form-label">Montant</label>
                    <input type="number" name="montant" id="montant" class="form-control" required min="1">
                </div>

                <!-- Bouton pour soumettre le formulaire -->
                <button type="submit" class="btn btn-primary w-100">Déposer</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
