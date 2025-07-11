<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .carte {
            width: 400px;
            height: 220px;
            border-radius: 15px;
            padding: 20px;
            color: white;
            background-color: #1c1c1c;
            position: relative;
        }
        .titre {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .numero {
            font-size: 20px;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }
        .info {
            font-size: 20px;
            margin-bottom: 8px;
        }
        .footer {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }
        .logo {
            width: 60px;
        }
    </style>
</head>
<body>
<div class="carte">
    <div class="titre">CARTE MASTERCARD</div>

    <div class="numero">{{ $compte->numero_carte }}</div>

    <div class="info">Nom : {{ $user->name }}</div>
    <div class="info">Expiration : {{ \Carbon\Carbon::parse($compte->date_expiration)->format('m/Y') }}</div>
    <div class="info">CVV : {{ $compte->cvv }}</div>

    <div class="footer">
        <img class="logo" src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fen.wikipedia.org%2Fwiki%2FFile%3AMastercard-logo.png&psig=AOvVaw3EPUiXBicJ-iyUi0JhWlRJ&ust=1746231545617000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCPCPisnBg40DFQAAAAAdAAAAABAE" alt="Mastercard Logo">

    </div>
</div>
</body>
</html>
