@extends('layouts.app')
@section('content')
    <h1>{{ $game->name }} Multiplayer spielen</h1>
    <server-browser></server-browser>

    <script type="application/javascript">
        var  data = {
            centrifugo: JSON.parse('{!! json_encode($config) !!}')
        }
    </script>
@endsection