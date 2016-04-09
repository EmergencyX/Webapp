@extends('layouts.app')

@section('content')
    <h1>L10N Neues Repository erstellen
        <br>
        <small>für {{ $project->name }}</small>
    </h1>
    <form method="post" action="{{ action('ProjectRepositoryController@store', compact('project')) }}">
        {!! Form::token() !!}
        <fieldset class="form-group">
            <label for="name">{{ trans('repository.create.name') }}</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="{{ trans('repository.create.placeholder_name') }}">
        </fieldset>

        <label class="c-input c-checkbox">
            <input type="checkbox" id="visible" name="visible" value="1">
            <span class="c-indicator"></span>
            {{ trans('repository.create.visible') }}
        </label>

        <fieldset class="form-group">
            <label for="repository_type">{{ trans('repository.create.repository_type') }}</label>
            <select class="c-select form-control" id="repository_type" name="repository_type">
                @foreach($repositoryTypes as $repositoryType)
                    <option value="{{ $repositoryType }}">{{ trans("repository.type.$repositoryType") }}</option>
                @endforeach
            </select>
        </fieldset>

        <p>
            <button type="submit" class="btn btn-primary">
                Repository erstellen
            </button>
        </p>
    </form>
@endsection