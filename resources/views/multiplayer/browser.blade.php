@extends('layouts.app')
@section('content')
    <h1>{{ $game->name }} Multiplayer spielen</h1>
    <server-browser :servers="list"></server-browser>
@endsection