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

<div class="container mt-4">
    <div class="row">
        <!-- Colonne 1: Informations utilisateur -->
        @if($compte && $compte->type_compte === 'epargne')
            <form method="POST" action="{{ route('appliquer.interets') }}">
                @csrf
                <button type="submit" class="btn btn-success mt-2">Appliquer 3% d’intérêts</button>
            </form>
        @endif

        @if ($compte)
            <form method="POST" action="{{ route('demanderFermeture', $compte->id) }}">
                @csrf
                <button class="btn btn-danger" onclick="return confirm('Confirmer la demande de fermeture ?')">
                    Demander la fermeture
                </button>
            </form>
        @else
            <p>Aucun compte bancaire trouvé.</p>
        @endif




        <div class="col-md-4">
            <div class="card">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Déconnexion</button>
                </form>
```````
                <div class="card-header">Mon Compte</div>
                <div class="card-body">
                    <a href="{{ route('carte.pdf') }}" class="btn btn-success">💳 Télécharger carte bancaire</a>
                    <p>Nom : {{ $user->name }}</p>
                    <p>Email : {{ $user->email }}</p>
                    <p>Numéro de téléphone: {{ $user->numero_telephone }}</p>
                    @if($compte)
                        <p>Numéro de Compte : {{ $compte->numero_compte }}</p> <!-- Affichage du numéro de compte -->
                        <p>Solde du Compte : <strong>{{ number_format($compte->solde, 2) }} FCFA</strong></p>
                        <!-- Bouton pour modifier les informations du compte -->
                        <a href="{{ route('compte.edit') }}" class="btn btn-warning">Modifier les informations du compte</a>


                    @else
                        <p>Vous n'avez pas encore de compte bancaire. <a href="{{ route('compte.create') }}">Ouvrir un compte</a></p>
                    @endif
                </div>
            </div>
        </div>
        <!-- Colonne 2: Historique des transactions -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Historique des Transactions</div>
                <div class="card-body">
                    <a href="{{ route('transactions.pdf') }}" class="btn btn-primary">📄 Télécharger l'historique des transactions en PDF</a>
                @if($compte && $transactions->count())
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Montant</th>
                                <th>Compte</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $transaction->type }}</td>
                                    <td>{{ number_format($transaction->montant, 2) }} FCFA</td>
                                    <td>
                                        @if($transaction->compte_dest_id)
                                            Compte {{ $transaction->compte_dest_id }}
                                        @else
                                            Compte {{ $transaction->compte_source_id }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Aucune transaction disponible. Vous devez d'abord effectuer une opération.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Section pour effectuer une opération bancaire -->
    @if($compte)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Effectuer une Opération</div>
                    <div class="card-body">
                        <a href="{{ route('depot') }}" class="btn btn-success">Déposer de l'Argent</a>
                        <a href="{{ route('retrait.form') }}" class="btn btn-danger">Retirer de l'Argent</a>
                        <a href="{{ route('virement') }}" class="btn btn-primary">Effectuer un Virement</a>
                        @if($compte->type_compte === 'epargne')
                            <div class="alert alert-info mt-3">
                                Retraits restants ce mois: {{ max(0, 2 - $compte->retraits_mois) }} / 2
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Section pour les messages de retrait -->
    @if(session('message_retrait'))
        <div class="alert alert-success">
            <p>{{ session('message_retrait') }}</p>
        </div>
    @endif

    <!-- Section pour les notifications récentes -->
    @if(isset($notifications))
        @foreach ($notifications as $notification)
            <li>{{ $notification }}</li>
        @endforeach
    @else
        <p>Aucune notification pour le moment.</p>
    @endif

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
