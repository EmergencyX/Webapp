@extends('layouts.app')

@section('content')
    <h1>{{ trans('appointment.create_header') }}</h1>

    {!! Form::open(['action'=>'AppointmentController@store', 'method'=>'post']) !!}
        @include('appointment.component.editor', compact('profiles'))
    {!! Form::close() !!}
@endsection