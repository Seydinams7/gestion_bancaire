@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Demandes d’ouverture de comptes</h2>
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
                        @if ($compte->statut == 'en_attente')
                            <form method="POST" action="{{ route('admin.approuver.ouverture', $compte->id) }}">
                                @csrf
                                <button class="btn btn-success btn-sm">Approuver</button>
                            </form>
                        @else
                            Approuvé
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
