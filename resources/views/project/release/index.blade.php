@extends('layouts.app')

@section('content')
    <h1>Releases
        <br>
        <small>für {{ $project->name }}</small>
    </h1>           

    <div class="row">
        <div class="col-md-12">
                <a class="pull-right" href="{{ action('Project\ReleaseController@create', $project) }}">
                   Neues Release hochladen <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </a>

            <p>
                Ein neues Release kann als Archiv importiert werden.
                Lade dazu einfach das gewünschte Archiv hoch.
                Es sollte im Format .zip vorliegen.
            </p>
        </div>
    </div>
    <br>


        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Ansehen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($releases as $release)
                <tr>
                    <td>
                        @if ($release->beta)
                            <span class="label label-primary">Beta</span>
                        @endif
                        {{ $release->name }}
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ action('Project\ReleaseController@show', [$project, $release]) }}">
                            Release ansehen
                        </a>
                        <a class="btn btn-primary" href="{{ action('Project\ReleaseController@download', [$project, $release]) }}">
                            Download
                        </a>
                        <a class="btn btn-danger" href="{{ action('Project\ReleaseController@remove', [$project, $release]) }}">
                            Entfernen
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection