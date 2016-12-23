@extends('layouts.app')

@section('content')
<h1>L10N Projekt {{ $project->name }} bearbeiten</h1>

{!! Form::open(['action'=>['Project\ProjectController@update', $project->id], 'method'=>'patch']) !!}
    @include('project.component.editor', compact('games'))
{!! Form::close() !!}
@endsection