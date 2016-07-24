@extends('layouts.app')

@section('content')
    <h1>L10N Neue Verabredung erstellen</h1>

    {!! Form::open(['action'=>'AppointmentController@store', 'method'=>'post']) !!}
        @include('appointment.component.editor', compact('profiles'))
    {!! Form::close() !!}
@endsection