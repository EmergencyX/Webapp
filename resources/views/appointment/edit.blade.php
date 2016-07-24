@extends('layouts.app')

@section('content')
    <h1>{{ trans('appointment.edit_header', ['name'=>$appointment->name]) }}</h1>

    {!! Form::open(['action'=>['AppointmentController@update', $appointment], 'method'=>'patch']) !!}
    @include('appointment.component.editor', compact('profiles', 'appointment'))
    {!! Form::close() !!}
@endsection