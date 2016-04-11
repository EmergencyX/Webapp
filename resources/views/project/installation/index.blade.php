@extends('layouts.app')

@section('content')
    <h1><a href="{{ \EmergencyExplorer\Util\ProjectUtil::getProjectAction($project)  }}">{{ $project->name }}</a>
        spielen</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Erfordert</th>
            <th>Status</th>
            <th>Aktion</th>
        </tr>
        </thead>
        <tbody>
        @foreach($project->releases->sortByDesc('updated_at') as $release)
            <tr>
                <th scope="row">{{ $release->id }}</th>
                <td>@if($release->beta)
                        <span class="label label-primary">Beta</span>
                    @endif
                    {{ $release->name }}</td>
                {{-- Could be a bug, but it's more likely me. Can't access using ->semver or ->game->name --}}
                <td>{{ $release->gameVersion['semver'] }} von {{ $release->gameVersion['game']['name'] }}</td>
                @if(($installedRelease = $installedReleases->get($release->id, null)))
                    @if($installedRelease->pivot->progress == 100)
                        <td>
                            <em class="small">
                                <i class="fa fa-space-shuttle"></i>
                                Installiert
                            </em>
                        </td>
                        <td>
                            <a href="{{ action('ReleaseInstallationController@postPlay',$release) }}" class="btn btn-success">Diese
                                                                                                                              Version
                                                                                                                              spielen</a>
                            <a href="{{ action('ReleaseInstallationController@postUninstall',$release) }}" class="btn btn-danger">Deinstallieren</a>
                        </td>
                    @else
                        <td>
                            <em class="small">
                                <i class="fa fa-circle-o-notch fa-spin"></i>
                                Wird installiert ({{$installedReleases->get($release->id)->pivot->progress}}%)
                            </em>
                        </td>
                        <td>
                            <a href="{{ action('ReleaseInstallationController@postCancel', $release) }}" class="btn btn-danger">Abbrechen</a>
                        </td>
                    @endif
                @else
                    <td>
                        <em class="small">Nicht installiert</em>
                    </td>
                    <td>
                        <a href="{{ action('ReleaseInstallationController@postInstall',$release) }}" class="btn btn-success">Installieren</a>
                        <a href="" class="btn btn-secondary">Archiv herunterladen</a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection