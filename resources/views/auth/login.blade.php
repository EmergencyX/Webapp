@extends('layouts.app')

@section('content')
    <h1>{{ trans('auth.join_the_force') }}</h1>
    {!! Form::open(['action' => 'Auth\LoginController@login', 'class' => 'mb-3']) !!}
    <div class="row">
        <fieldset class="form-group col-md-6">
            <label for="name">{{ trans('auth.name') }}</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('auth.name') }}">
        </fieldset>
        <fieldset class="form-group col-md-6">
            <label for="password">{{ trans('auth.password') }}</label>
            <input type="password" class="form-control" name="password" id="password"
                   placeholder="{{ trans('auth.password') }}">
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">{{ trans('auth.join_the_force') }}</button>
    <div class="form-check d-inline ml-3">
        <label class="form-check-label">
            <input type="checkbox" name="remember" class="form-check-input">
            {{ trans('auth.remember_me') }}
        </label>
    </div>
    {!! Form::close() !!}

    <p>Noch nicht dabei? <a href="{{ action('Auth\RegisterController@createForm') }}" class="">Zur Registrierung</a></p>
@endsection