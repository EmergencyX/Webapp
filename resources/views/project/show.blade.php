@extends('layouts.app')

@section('content')
    @unless($project->media->isEmpty())
        <img class="figure-img img-fluid" src="{{ $project->media->first()->getThumbnail('md') }}" style="width:100%;max-height:300px;object-fit: cover;" alt="{{ $project->name }}">
    @endunless
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $project->name }}</h1>

            <p>{{ $project->description }}</p>


            <br>
            <a href="{{ action('ReleaseInstallationController@index', $project) }}" class="btn btn-primary">
                <i class="fa fa-play"></i> Spielen
            </a>
            <a href="{{ '#' }}" class="btn btn-danger"><i class="fa fa-fire-extinguisher"></i> Beobachten</a>

            {{--
            <div class="card">
                <div class="card-block">
                    <p class="card-title m-b-0">Neues Release veröffentlicht</p>
                    <p class="card-text">Upgraden (/^-^)/</p>
                    <p class="card-text">
                        <small class="text-muted">Irgendwann, irgendwie, irgendwo</small>
                    </p>
                </div>
            </div>

            @forelse($activities as $activity)
                <div class="card">
                    <div class="card-block">
                        <p class="card-title m-b-0">{{ trans('activity.' .$activity['topic'], $activity['meta']) }}</p>
                        @if(isset($activity['meta']['description']))
                            <p class="card-text">{{ $activity['meta']['description']}}</p>
                        @endif

                        @if(isset($activity['meta']['url']))
                            <div class="row">
                                <div class="col-md-3">
                                    <img class="img-fluid img-rounded" src="{{ $activity['meta']['url'] }}">
                                </div>
                            </div>
                        @endif

                        <p class="card-text">
                            <small class="text-muted">{{ $activity['timestamp']->diffForHumans() }}</small>
                        </p>
                    </div>
                </div>
            @empty
                <p>Keine Aktivitäten verfügbar.</p>
            @endforelse
            --}}
        </div>
        <div class="col-md-4">
            <div class="m-t-1">

            </div>

            {{-- See you in a later version
            <div class="card card-block m-t-1">
                <p class="card-title">Multiplayer
                    <br/><span class="text-muted">Keine aktive Spiele. <a href="#" class="btn btn-sm btn-secondary">Erstellen</a></span>
                </p>
            </div>
            --}}

            @can('edit', $project)
            <div class="list-group" style="margin-bottom:0.75rem">
                <a href="{{ action('ProjectController@edit', $project->id) }}" class="list-group-item">{{ trans('project.edit') }}</a>

                <a href="{{ action('ProjectController@createMedia', $project->id) }}" class="list-group-item">{{ trans('project.create_media') }}</a>

                <a href="{{ action('ReleaseController@create', $project->id) }}" class="list-group-item">{{ trans('project.create_release') }}</a>
            </div>
            @endcan

            <ul class="list-group" style="margin-bottom:0.75rem">
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
                        @foreach($project->media->sortByDesc('updated_at')->take(4) as $media)
                            <div class="col-md-3 col-xs-3">
                                <img class="figure-img img-fluid img-rounded" src="{{ $media->getThumbnail() }}" alt="{{ $media->name }}">
                            </div>
                        @endforeach
                    </div>
                </li>
            </ul>
            {{--
            <div class="card card-block">
                <p class="card-text">
                    Repositories
                    <a class="pull-xs-right" href="{{ action('ProjectRepositoryController@index', $project) }}">
                        Alle <i class="fa fa-chevron-right"></i>
                    </a>
                </p>
                <ul class="list-inline">
                    @foreach($project->repositories->sortByDesc('updated_at')->take(2) as $repository)
                        <li class="list-inline-item">
                            <a href="{{ action('ProjectRepositoryController@show', [$project, $repository]) }}">
                                {{ $repository->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            --}}
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
@endsection
