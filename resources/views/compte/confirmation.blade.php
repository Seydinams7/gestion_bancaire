<!-- resources/views/compte/confirmation.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Dépôt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header text-center">Confirmation du Dépôt</div>
        <div class="card-body">
            <p class="text-center">
                Votre dépôt a été effectué avec succès ! Souhaitez-vous déposer plus d'argent ou retourner au tableau de bord ?
            </p>

            <div class="d-flex justify-content-center">
                <a href="{{ route('bank.deposer.form') }}" class="btn btn-primary me-3">Oui, continuer à déposer</a>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Non, retourner au tableau de bord</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
