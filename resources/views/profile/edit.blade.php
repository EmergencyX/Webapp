@extends('layouts.app')

@section('content')
    <h1>{{ trans('profile.edit_header') }}</h1>

    {!! Form::open(['action'=>['ProfileController@update', $profile->id], 'method'=>'patch']) !!}
        @include('profile.component.editor', compact('games', 'projects', 'profile'))
    {!! Form::close() !!}
@endsection