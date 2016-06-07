@extends('layouts.app')

@section('content')
    <h1>L10N Neues Release erstellen
        <br>
        <small>für {{ $project->name }} / {{ $repository->name }}</small>
    </h1>

    @if(\EmergencyExplorer\Util\ProjectRepositoryUtil::canBeBuild($repository))
        <form method="post" action="{{ action('ReleaseController@store', compact('project', 'repository')) }}">
            {!! Form::token() !!}
            {!! Form::hidden('visible', 0) !!}
            {!! Form::hidden('beta', 0) !!}

            <fieldset class="form-group">
                <label for="name">Name für das neue Release</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Releasename">
            </fieldset>

            <label class="c-input c-checkbox">
                <input type="checkbox" id="visible" name="visible" value="1" checked="checked">
                <span class="c-indicator"></span>
                Release nur innerhalb des Teams freigeben
            </label>

            <label class="c-input c-checkbox">
                <input type="checkbox" id="beta" name="beta" value="1">
                <span class="c-indicator"></span>
                Release als <label class="label label-primary">Beta</label> markieren
            </label>

            <fieldset class="form-group">
                <label for="game_version_id">Spielversion von {{ $project->game->name }}</label>
                <select class="c-select form-control" id="game_version_id" name="game_version_id">
                    @foreach($project->game->versions as $gameVersion)
                        <option value="{{ $gameVersion->id }}">{{ $gameVersion->semver }}</option>
                    @endforeach
                </select>
            </fieldset>

            <p>
                <button type="submit" class="btn btn-primary">
                    Release erstellen
                </button>
            </p>
        </form>
    @else
        <p>L10N Bitte installiere EMX um ein Release für {{ $repository->name }} anzulegen oder
           initialisere ein
           Repository, welches den Releasevorgang unterstützt. Aha, so geht das (link)</p>
    @endif

@endsection