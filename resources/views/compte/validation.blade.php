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
    <div class="container">
        <h2>Validation des comptes en attente</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>Numéro de compte</th>
                <th>Type de compte</th>
                <th>Solde</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($comptes as $compte)
                <tr>
                    <td>{{ $compte->numero_compte }}</td>
                    <td>{{ $compte->type_compte }}</td>
                    <td>{{ $compte->solde }}</td>
                    <td>
                        <!-- Formulaire de validation -->
                        <form action="{{ route('compte.valider', $compte->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Valider</button>
                        </form>

                        <!-- Formulaire de rejet -->
                        <form action="{{ route('compte.rejeter', $compte->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <div class="form-group">
                                <label for="justification">Justification :</label>
                                <input type="text" name="justification" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-danger">Rejeter</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
