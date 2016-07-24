@extends('layouts.app')

@section('content')
    <h1>{{ trans('profile.create_header') }}</h1>

    {!! Form::open(['action'=>'ProfileController@store', 'method'=>'post']) !!}
        @include('profile.component.editor', compact('games', 'projects'))
    {!! Form::close() !!}
@endsection