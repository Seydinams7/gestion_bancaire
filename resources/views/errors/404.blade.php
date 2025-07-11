@extends('layouts.app')

@section('content')
    <script>
        window.location.href = '{{ route('login') }}'; // Redirige vers la page de login
    </script>
@endsection
