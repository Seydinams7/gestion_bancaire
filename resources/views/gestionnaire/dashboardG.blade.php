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
    <h2 class="mb-4">Tableau de bord - Gestionnaire</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Actions disponibles</div>
        <div class="card-body">
            <p>Bienvenue {{ Auth::user()->name }}, vous pouvez :</p>
            <ul>
                <li>Voir les comptes bancaires en attente de validation</li>
                <li>Valider ou rejeter des comptes</li>
                <li>Gérer les informations des clients</li>
            </ul>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('gestionnaire.comptes') }}" class="btn btn-primary">
            Gérer les comptes bancaires
        </a>
    </div>
</div>

<script>
    document.querySelectorAll('.mark-as-read').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            // Récupère l'ID de la notification
            var notificationId = button.getAttribute('data-id');

            // Envoi de la requête AJAX
            fetch('/notifications/' + notificationId + '/mark-as-read', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Change le texte du bouton pour indiquer que la notification est lue
                        button.textContent = 'Marquée comme lue';

                        // Optionnel : Ajoute une classe ou un autre effet visuel
                        button.classList.add('read'); // Par exemple, ajouter une classe 'read' au bouton

                        // Si la notification est dans une liste, tu peux aussi la masquer ou la marquer d'une autre manière
                        // button.closest('.notification-item').classList.add('read');
                    } else {
                        alert('Une erreur est survenue');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
