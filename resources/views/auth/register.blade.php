@extends('layouts.app')

@section('content')
    <h1>{{ trans('auth.register') }}</h1>
    {!! Form::open(['action' => 'Auth\RegisterController@register', 'class' => 'mb-3']) !!}
    <div class="row">
        <fieldset class="form-group col-md-6">
            <label for="name">{{ trans('auth.name') }}</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('auth.name') }}">
        </fieldset>
        <fieldset class="form-group col-md-6">
            <label for="email">{{ trans('auth.email') }}</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="{{ trans('auth.email') }}">
        </fieldset>
    </div>

    <div class="row">
        <fieldset class="form-group col-md-6">
            <label for="password">{{ trans('auth.password') }}</label>
            <input type="password" class="form-control" name="password" id="password"
                   placeholder="{{ trans('auth.password') }}">
        </fieldset>
        <fieldset class="form-group col-md-6">
            <label for="password_confirmation">{{ trans('auth.password') }}</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                   placeholder="{{ trans('auth.password') }}">
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">{{ trans('auth.register') }}</button>
    {!! Form::close() !!}
@endsection