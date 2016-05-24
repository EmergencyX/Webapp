@extends('layouts.app')

@section('content')
    <h1>Releases
        <br>
        <small>für {{ $project->name }}</small>
    </h1>           

    <div class="row">
        <div class="col-md-4">
            <h3>von Repository
                <a class="pull-right" href="{{ action('ReleaseController@create', $project) }}">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </a>
            </h3>
            <p>
                Das kann dein EMX Repository oder ein externes Repository sein. Du kannst genau den Commit auswählen,
                der hier veröffentlicht werden soll.
            </p>
        </div>
        <div class="col-md-4">
            <h3>Archiv hochladen
                <a class="pull-right" href="#">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </a>
            </h3>
            <p>
                Ein neues Release kann als Archiv importiert werden.
                Lade dazu einfach das gewünschte Archiv hoch.
                Es sollte im Format .zip vorliegen.
                <span class="text-info">Zeit für den Emergency Explorer :)</span>
            </p>
        </div>
        <div class="col-md-4">
            <h3>Externer Link
                <a class="pull-right" href="#">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </a>
            </h3>
            <p>
                Alternativ kannst du hier auch eine URL zu einem Archiv angeben.
                Das Archiv sollte als .zip vorliegen.
                Es wird automatisch in EMX importiert.
            </p>
        </div>
    </div>
    <br>

    @foreach($project->repositories as $repository)
        <h3>{{ $repository->name }}</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Ansehen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($repository->releases as $release)
                <tr>
                    <td>
                        @if ($release->beta)
                            <span class="label label-primary">Beta</span>
                        @endif
                        {{ $release->name }}
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ action('ReleaseController@show', [$project, $release]) }}">
                            Release ansehen
                        </a>
                        <a class="btn btn-danger" href="{{ action('ReleaseController@destroy', [$project, $release]) }}">
                            Entfernen
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach

@endsection