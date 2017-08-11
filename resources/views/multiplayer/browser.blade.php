@extends('layouts.app')
@section('content')
    <h1>{{ $game->name }} Multiplayer spielen</h1>
    <div id="serverbrowser"></div>

    <script type="application/javascript">
        var centrifugo = JSON.parse('{!! json_encode($config) !!}');
    </script>
    <script src="{{ asset("browser.js") }}"></script>
@endsection