@extends('layouts.app')
@section('content')
    <h1>Emergency Explorer herunterladen</h1>
    @if(isset($project))
        <p>Gleich kann es losgehen mit {{ $project->name }}.</p>
    @else
        <p>Gleich kann der Emergency Explorer verwendet werden.</p>
    @endif

    <a href="#" class="btn btn-primary">Emergency Explorer herunterladen</a>
@endsection