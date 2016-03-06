@extends('layouts.app')

@section('content')
<h1>L10N Neues Projekt erstellen</h1>

{!! Form::open(['action'=>'ProjectController@create']) !!}
    @include('project.component.editor')
{!! Form::close() !!}
@endsection