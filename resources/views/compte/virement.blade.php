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
        <div class="card-header">Virement d'Argent</div>
        <div class="card-body">
            <form action="{{ route('virement') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="num_compte_destinataire">Numéro du compte destinataire</label>
                    <input type="text" name="num_compte_destinataire" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="montant">Montant</label>
                    <input type="number" name="montant" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Effectuer le virement</button>
            </form>



        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
