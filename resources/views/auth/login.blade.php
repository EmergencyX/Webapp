@extends('layouts.app')

@section('content')
    <h1>{{ trans('auth.join_the_force') }}</h1>
    {!! Form::open(['action' => 'Auth\LoginController@login']) !!}
    {!! Form::token() !!}
    <fieldset class="form-group">
        <label for="name">{{ trans('auth.name') }}</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('auth.name') }}">
    </fieldset>
    <fieldset class="form-group">
        <label for="password">{{ trans('auth.password') }}</label>
        <input type="password" class="form-control" name="password" id="password"
               placeholder="{{ trans('auth.password') }}">
    </fieldset>
    <div class="form-check">
        <label class="form-check-label">
            <input type="checkbox" name="remember" class="form-check-input">
            {{ trans('auth.remember_me') }}
        </label>
    </div>

    <button type="submit" class="btn btn-primary">{{ trans('auth.join_the_force') }}</button>
    {!! Form::close() !!}
@endsection