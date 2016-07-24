@extends('layouts.app')

@section('content')
    <h1>L10N Verabredung {{ $appointment->name }} bearbeiten</h1>

    {!! Form::open(['action'=>['AppointmentController@update', $appointment], 'method'=>'patch']) !!}
    @include('appointment.component.editor', compact('profiles', 'appointment'))
    {!! Form::close() !!}
@endsection