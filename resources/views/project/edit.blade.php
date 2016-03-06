@extends('layouts.app')

@section('content')
<h1>L10N Projekt {{ $project->name }} bearbeiten</h1>

{!! Form::open(['action'=>['ProjectController@edit', $project->id]]) !!}
    @include('project.component.editor')
{!! Form::close() !!}
@endsection