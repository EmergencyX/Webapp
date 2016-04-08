@extends('layouts.app')

@section('content')
    <h1>L10N Neues Release erstellen
        <br>
        <small>für {{ $project->name }} / {{ $repository->name }}</small>
    </h1>

    @if(\EmergencyExplorer\Util\ProjectRepositoryUtil::canBeBuild($repository))
        <form method="post" action="{{ action('ReleaseController@store', compact('project', 'repository')) }}">
            {!! Form::token() !!}
            <fieldset class="form-group">
                <label for="name">Name für das neue Release</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Releasename">
            </fieldset>

            <label class="c-input c-checkbox">
                <input type="checkbox" id="beta" name="beta">
                <span class="c-indicator"></span>
                Release nur für Betatester freigeben
            </label>

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