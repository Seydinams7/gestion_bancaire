<!-- resources/views/auth/register.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Inscription</h2>

    <!-- Formulaire d'inscription -->
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Nom de l'utilisateur -->
        <div class="form-group">
            <label for="name">Nom</label>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        </div>

        <!-- Téléphone -->
        <div class="form-group">
            <label for="numero_telephone">Numéro de téléphone</label>
            <input id="numero_telephone" type="text" class="form-control" name="numero_telephone" value="{{ old('numero_telephone') }}" required>
        </div>


        <!-- Mot de passe -->
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" class="form-control" name="password" required>
        </div>

        <!-- Confirmer le mot de passe -->
        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>


    <!-- Lien vers la page de connexion -->
    <p class="mt-3">Vous avez déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
</div>

</body>
</html>
