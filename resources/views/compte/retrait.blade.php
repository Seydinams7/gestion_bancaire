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


<div class="container mt-4">
    <div class="card">
        <div class="card-header">Retirer de l'Argent</div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

                @if ($errors->has('retrait'))
                    <div class="alert alert-danger">
                        {{ $errors->first('retrait') }}
                    </div>
                @endif

                <form action="{{ route('retrait') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="compte_id" class="form-label">Sélectionner un Compte</label>
                    <select name="compte_id" class="form-control" required>
                        @foreach($comptes as $compte)
                            <option value="{{ $compte->id }}">{{ $compte->numero_compte }} - Solde: {{ $compte->solde }} FCFA</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="montant" class="form-label">Montant à Retirer</label>
                    <input type="number" name="montant" class="form-control" required min="1">
                </div>
                <button type="submit" class="btn btn-danger">Retirer</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
