@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Demandes de fermeture de comptes</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($comptes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Email</th>
                                        <th>Type de compte</th>
                                        <th>Numéro de compte</th>
                                        <th>Solde actuel</th>
                                        <th>Date de demande</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($comptes as $compte)
                                        <tr>
                                            <td>{{ $compte->user->name ?? 'N/A' }}</td>
                                            <td>{{ $compte->user->email ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ ucfirst($compte->type_compte) }}
                                                </span>
                                            </td>
                                            <td>{{ $compte->numero_compte }}</td>
                                            <td>
                                                <span class="badge badge-{{ $compte->solde > 0 ? 'success' : 'secondary' }}">
                                                    {{ number_format($compte->solde, 2) }} €
                                                </span>
                                            </td>
                                            <td>{{ $compte->updated_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <span class="badge badge-warning">
                                                    En attente de fermeture
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <!-- Bouton Approuver -->
                                                    <form method="POST" action="{{ route('admin.validerFermeture', $compte->id) }}" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm" 
                                                                onclick="return confirm('Êtes-vous sûr de vouloir approuver la fermeture de ce compte ?')">
                                                            <i class="fas fa-check"></i> Approuver
                                                        </button>
                                                    </form>

                                                    <!-- Bouton Rejeter avec modal -->
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" 
                                                            data-target="#rejetFermetureModal{{ $compte->id }}">
                                                        <i class="fas fa-times"></i> Rejeter
                                                    </button>
                                                </div>

                                                <!-- Modal de rejet de fermeture -->
                                                <div class="modal fade" id="rejetFermetureModal{{ $compte->id }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form method="POST" action="{{ route('admin.rejeterFermeture', $compte->id) }}">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Rejeter la demande de fermeture</h5>
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Client :</strong> {{ $compte->user->name ?? 'N/A' }}</p>
                                                                    <p><strong>Type de compte :</strong> {{ ucfirst($compte->type_compte) }}</p>
                                                                    <p><strong>Solde actuel :</strong> {{ number_format($compte->solde, 2) }} €</p>
                                                                    
                                                                    <div class="form-group">
                                                                        <label for="raison_rejet">Raison du rejet <span class="text-danger">*</span></label>
                                                                        <textarea name="raison_rejet" id="raison_rejet" class="form-control" 
                                                                                rows="4" placeholder="Expliquez pourquoi la fermeture est rejetée..." required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                    <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Aucune demande de fermeture en attente.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

