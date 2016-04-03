@extends('layouts.app')

@section('content')
    <h1>Profil bearbeiten</h1>

    {!! Form::open(['action'=>['UserController@update', $user->id], 'method'=>'patch', 'files'=>true]) !!}
    {!! Form::file('media') !!}
    {!! Form::submit('Hochladen', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection