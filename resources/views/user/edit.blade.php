@extends('layouts.app')

@section('content')
    <h1>Profil bearbeiten</h1>

    {!! Form::open(['action'=>['User\UserController@update', $user], 'method'=>'patch', 'files'=>true]) !!}
    {!! Form::file('image') !!}
    {!! Form::submit('Hochladen', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection