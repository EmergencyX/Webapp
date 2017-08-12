@extends('layouts.app')
@section('content')
    <h1>{{ $game->name }} Serverbrowser</h1>
    <p>Der Browser wird in Echtzeit aktualisiert</p>
    <ul class="list-inline">
        <li class="list-inline-item"><i class="fa fa-lock fa-fw"></i> Dieses Spiel erfordert ein Passwort</li>
        <li class="list-inline-item"><i class="fa fa-play fa-fw"></i> Dieses Spiel ist bereits gestartet</li>
    </ul>
    <div id="serverbrowser"></div>

    <script type="application/javascript">
        var centrifugo = JSON.parse('{!! json_encode($config) !!}');
    </script>
    <script src="{{ asset("browser.js") }}"></script>
@endsection