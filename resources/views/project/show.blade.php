@extends('layouts.app')

@section('content')
    <h1>{{ trans('project.project_short') }} {{ $project->name }}</h1>
    @can('edit', $project)
    <a href="{{ action('ProjectController@edit', $project->id) }}" class="btn btn-primary">{{ trans('project.edit') }}</a>
    <a href="{{ action('ProjectController@delete', $project->id) }}" class="btn btn-danger">{{ trans('project.delete') }}</a>
    @endcan

    <p>{{ $project->description }}</p>

    <div class="row">
        <div class="col-md-8">
            @can('edit', $project)
            <a href="{{ action('ProjectController@createMedia', $project->id) }}" class="btn btn-secondary">{{ trans('project.create_media') }}</a>
            @if($project->repositories->count() > 0)
                <a href="{{ action('ReleaseController@index', $project->id) }}" class="btn btn-secondary">{{ trans('project.create_release') }}</a>
            @endif
            <a href="{{ action('ProjectRepositoryController@create', $project->id) }}" class="btn btn-secondary">{{ trans('project.create_repository') }}</a>
            @endcan

            @forelse($activities as $activity)
                <p>{{ trans('activity.' .$activity['topic'], $activity['meta']) }} <br>
                    <small class="text-muted">{{ $activity['timestamp']->diffForHumans() }}</small>
                </p>
                @if(isset($activity['meta']['url']))
                    <img class="figure-img img-fluid img-rounded" src="{{ $activity['meta']['url'] }}" style="max-width: 64px">
                @endif
            @empty
                <p>Keine Aktivitäten verfügbar.</p>
            @endforelse
        </div>
        <div class="col-md-4">
            <div class="card card-block">
                <h4 class="card-title">Modifikation installieren</h4>
                <a href="#" class="btn btn-primary">Installieren</a>
            </div>

            <ul class="list-group">
                <li class="list-group-item">
                    <div class="clearfix">
                        <p>
                            Versionen
                            @if($project->releases->count() > 4)
                                <a class="pull-xs-right" href="#">
                                    Alle <i class="fa fa-chevron-right"></i>
                                </a>
                            @endif
                            @if($project->releases->isEmpty())
                                <br/><span class="text-muted">L10n Keine Versionen</span>
                            @endif
                        </p>
                    </div>
                    <ul class="list-inline">
                        @foreach($project->releases->take(2) as $release)
                            <li class="list-inline-item">
                                @if($release->beta)
                                    <span class="label label-primary">Beta</span>
                                @endif
                                <a href="{{ action('ReleaseController@show', [$project->id, $release->id]) }}">
                                    {{ $release->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="list-group-item">
                    <div class="clearfix">
                        <p>
                            Mitglieder
                            @if($project->members->count() > 4)
                                <a class="pull-xs-right" href="#">
                                    Alle <i class="fa fa-chevron-right"></i>
                                </a>
                            @endif
                            @if($project->members->isEmpty())
                                <br/><span class="text-muted">L10n Keine Mitglieder</span>
                            @endif
                        </p>
                    </div>
                    <div class="row">
                        @foreach($project->members->take(4) as $user)
                            <div class="col-md-3 col-xs-3">
                                <img class="figure-img img-fluid img-rounded" src="{{ $user->getThumbnail() }}" alt="{{ $user->name }}">
                            </div>
                        @endforeach
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="clearfix">
                        <p>
                            Bilder
                            @if($project->media->count() > 4)
                                <a class="pull-xs-right" href="#">
                                    Alle <i class="fa fa-chevron-right"></i>
                                </a>
                            @endif
                            @if($project->media->isEmpty())
                                <br/><span class="text-muted">L10n Keine Bilder</span>
                            @endif
                        </p>
                    </div>
                    <div class="row">
                        @foreach($project->media->take(4) as $media)
                            <div class="col-md-3 col-xs-3">
                                <img class="figure-img img-fluid img-rounded" src="{{ $media->getThumbnail() }}" alt="{{ $media->name }}">
                            </div>
                        @endforeach
                    </div>
                </li>
            </ul>
            @can('edit', $project)
            <div class="card card-block">
                <p class="card-text">
                    Projekt löschen
                </p>
                <a href="{{ action('ProjectController@delete', $project->id) }}" class="btn btn-danger">{{ trans('project.delete') }}</a>
            </div>
            @endcan
        </div>
    </div>

    <h3>Mitglieder</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Role</th>
        </tr>
        </thead>
        <tbody>
        @foreach($project->members as $member)
            <tr>
                <th scope="row">{{ $member->id }}</th>
                <td><a href="{{ \EmergencyExplorer\Util\UserUtil::getUserAction($member) }}">{{ $member->name }}</a>
                </td>
                <td>{{ trans('project.role.' . $member->pivot->role) }}</td>
            </tr>
        @endforeach     
        </tbody>
    </table>
    <h3>Releases</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Erstellt</th>
            <th>Download</th>
        </tr>
        </thead>
        <tbody>
              @foreach($project->releases as $release)
            <tr>
                <th scope="row">{{ $release->id }}</th>
                <td>{{ $release->name }}</td>
                <td>{{ $release->created_at }}</td>
                <td>
                    <a href="{{ \EmergencyExplorer\Util\ReleaseUtil::getDownloadLink($release) }}" class="btn btn-secondary">Download</a>
                </td>
            </tr>
               @endforeach
        </tbody>
    </table>
    <h3>Bilder</h3>
    @foreach($project->media as $media)
        <figure class="figure">
            <img class="figure-img img-fluid img-rounded" src="{{ $media->getThumbnail() }}" alt="{{ $media->name }}">
            <figcaption class="figure-caption"><strong>{{ $media->name }}</strong>{{ $media->description }}
                <a href="{{ action('MediaController@delete', $media->id) }}" class="text-danger">Löschen</a>
            </figcaption>
        </figure>
    @endforeach
@endsection