@extends('layouts.app')

@section('content')
<h1>L10N Neues Projekt erstellen</h1>

{!! Form::open(['action'=>'Project\ProjectController@store', 'method'=>'post']) !!}
    @include('project.component.editor', compact('games'))
{!! Form::close() !!}
@endsection