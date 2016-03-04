@extends('layouts.app')

@section('content')
<h1>{{ trans('auth.join_the_force') }}</h1>
<form method="POST" action="/auth/login">
    {!! csrf_field() !!}

    <fieldset class="form-group">
        <label for="name">{{ trans('auth.name') }}</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('auth.name') }}">
    </fieldset>
    <fieldset class="form-group">
        <label for="password">{{ trans('auth.password') }}</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="{{ trans('auth.password') }}">
    </fieldset>
    <div class="checkbox">
    <label>
        <input type="checkbox" name="remember">{{ trans('auth.remember_me') }}</input>
        </label>
    </div>

        <button type="submit btn btn-primary">{{ trans('auth.join_the_force') }}</button>
</form>
@endsection