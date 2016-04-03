@extends('layouts.app')

@section('content')
    <h1>{{ $release->name }}
        <br>
        <small>ist ein Release von {{ $project->name }}</small>
    </h1>
@endsection