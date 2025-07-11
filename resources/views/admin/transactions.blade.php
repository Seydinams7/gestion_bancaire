@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Liste des transactions</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Client</th>
                <th>Montant</th>
                <th>Type</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->compte->user->name }}</td>
                    <td>{{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
