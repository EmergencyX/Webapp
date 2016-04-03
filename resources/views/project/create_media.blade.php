@extends('layouts.app')

@section('content')
<h1>L10N Media hinzufügen {{ $project->name }}</h1>

{!! Form::open(['action'=>['ProjectController@storeMedia', $project->id], 'method'=>'post', 'files'=>true]) !!}
    {!! Form::text('name') !!}
    {!! Form::text('description') !!}

    {!! Form::file('media') !!}
    {!! Form::submit('Hochladen') !!}
{!! Form::close() !!}
@endsection