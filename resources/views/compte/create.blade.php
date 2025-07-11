<!-- resources/views/compte/create.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Compte Bancaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">Créer un Compte Bancaire</div>
        <div class="card-body">
            <form action="{{ route('compte.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="type_compte" class="form-label">Type de Compte</label>
                    <select name="type_compte" id="type_compte" class="form-control" required>
                        <option value="courant">Compte Courant</option>
                        <option value="epargne">Compte Épargne</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="solde" class="form-label">Solde Initial</label>
                    <input type="number" name="solde" class="form-control" value="100000" required>
                </div>
              
                <div class="mb-3">
                    <label for="code_guichet" class="form-label">Code Guichet</label>
                    <input type="text" name="code_guichet" class="form-control" value="GUICHET001" required>
                </div>
                <div class="mb-3">
                    <label for="cle_rib" class="form-label">Clé RIB</label>
                    <input type="text" name="cle_rib" class="form-control" value="RIB001" required>
                </div>

                <button type="submit" class="btn btn-primary">Créer le Compte</button>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
