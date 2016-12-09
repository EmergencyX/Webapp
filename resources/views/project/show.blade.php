@extends('layouts.app')

@section('content')
    <img class="figure-img img-fluid" src="{{ $projectUtil->cover($project) }}" style="width:100%;max-height:300px;object-fit: cover;" alt="{{ $project->name }}">

    <div class="row">
        <div class="col-md-8">
            <h1>
                {{ $project->name }}
                @if($project->visible == 0)
                    <i class="fa fa-lock" aria-hidden="true"></i>
                @endif
            </h1>

            <p>{{ $project->description }}</p>

            <br>
            <a href="{{ action('ReleaseInstallationController@index', $project) }}"
                    class="btn btn-primary @if($project->releases->isEmpty()) disabled @endif">
                <i class="fa fa-play"></i> {{ trans('project.play') }}
            </a>
            @if (Auth::check())
                <a href="{{ action('ProjectController@toggleFollow', $project) }}" class="btn btn-danger">
                    {{--
                    @if (Auth::user()->isFollowingProject($project))
                        <i class="fa fa-fire-extinguisher"></i> {{ $project->users()->count() }}
                        {{ trans('project.stop_following') }}
                    @else
                        <i class="fa fa-fire-extinguisher"></i> {{ $project->users()->count() }}
                        {{ trans('project.start_following') }}
                    @endif
                    --}}
                </a>
            @endif

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

            <a href="{{ action('Project\ImageController@create', $project) }}" class="list-group-item">{{ trans('project.create_media') }}</a>


        @can('edit', $project)
                <div class="list-group" style="margin-bottom:0.75rem">
                    <a href="{{ action('ProjectController@edit', $project->id) }}" class="list-group-item">{{ trans('project.edit') }}</a>

                    <a href="{{ action('Project\ImageController@create', $project) }}" class="list-group-item">{{ trans('project.create_media') }}</a>

                    <a href="{{ action('ReleaseController@index', $project->id) }}" class="list-group-item">{{ trans('project.releases') }}</a>
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
                                <img class="figure-img img-fluid img-rounded" src="{{ 'todo' }}" alt="{{ $user->name }}">
                            </div>
                        @endforeach
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="clearfix">
                        <p>
                            Bilder
                            {{--
                            @if($project->media->count() > 4)
                                <a class="pull-xs-right" href="#">
                                    Alle <i class="fa fa-chevron-right"></i>
                                </a>
                            @endif
                            @if($project->media->isEmpty())
                                <br/><span class="text-muted">L10n Keine Bilder</span>
                            @endif
                            --}}
                        </p>
                    </div>
                    <div class="row">
                        {{--
                        @foreach($project->media->sortByDesc('updated_at')->take(4) as $media)
                            <div class="col-md-3 col-xs-3">
                                <img class="figure-img img-fluid img-rounded" src="{{ $media->getImageLink() }}" alt="{{ $media->name }}">
                            </div>
                        @endforeach
                            --}}
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

            {{--
            <div class="list-group">
                @foreach($project->supportLinks as $link)
                    <a href="{{ $link->url }}" class="list-group-item">{{ $link->name }}
                        <i class="fa fa-external-link" aria-hidden="true"></i></a>
                @endforeach
                @can('edit', $project)
                    <a href="{{ action('LinkController@edit', $project) }}" class="list-group-item">Links bearbeiten</a>
                @endcan
            </div>
--}}
        </div>
    </div>
@endsection
