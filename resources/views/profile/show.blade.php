@extends('layouts.app')

@section('content')
    <h1>{{ trans('profile.show_header') }}</h1>

    {{ var_dump($profile) }}
@endsection