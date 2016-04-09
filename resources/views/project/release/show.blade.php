@extends('layouts.app')

@section('content')
    <h1>@if($release->beta)
            <span class="label label-primary">Beta</span>
        @endif
         {{ $release->name }}
        <br>
        <small>ist ein Release von {{ $project->name }}</small>
    </h1>
@endsection