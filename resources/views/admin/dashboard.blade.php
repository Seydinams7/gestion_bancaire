<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card { margin-bottom: 20px; }
        .card-header { font-weight: bold; }
        .card-body { font-size: 18px; }
        .alert { margin-top: 20px; }
    </style>
</head>


<body class="bg-light">
    <div class="container">
        <h2 class="mb-4">Tableau de bord Admin</h2>
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('admin.ouvertures') }}">Demandes d'ouverture de comptes</a></li>
            <li class="list-group-item"><a href="{{ route('admin.fermetures') }}">Demandes de fermeture de comptes</a></li>
            <li class="list-group-item"><a href="{{ route('admin.transactions') }}">Transactions</a></li>
        </ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
