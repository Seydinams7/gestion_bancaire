@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Demandes de fermeture de comptes</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Client</th>
                <th>Type</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($comptes as $compte)
                <tr>
                    <td>{{ $compte->user->name }}</td>
                    <td>{{ ucfirst($compte->type) }}</td>
                    <td>{{ ucfirst($compte->statut) }}</td>
                    <td>
                        @if ($compte->statut == 'fermeture_en_attente')
                            <form method="POST" action="{{ route('admin.approuver.fermeture', $compte->id) }}">
                                @csrf
                                <button class="btn btn-danger btn-sm">Confirmer la fermeture</button>
                            </form>
                        @else
                            Fermé
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
