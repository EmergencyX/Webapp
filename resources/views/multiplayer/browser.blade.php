@extends('layouts.app')
@section('content')
    <h1>{{ $game->name }} Multiplayer spielen</h1>
    <server-browser :servers="list"></server-browser>

    <script type="application/javascript">
        var  data = {
            list: [{
                name: "Testserver",
                mod: "Fuubar",
                players: "noBlubb"
            }],
            centrifugo: JSON.parse('{!! json_encode($config) !!}')
        }
    </script>
@endsection