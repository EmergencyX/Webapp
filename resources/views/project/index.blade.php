@extends('layouts.app')

@section('content')
    <h1>{{ trans('project.all_projects') }}
        <a class="btn btn-primary pull-xs-right" href="{{ action('ProjectController@create') }}">{{ trans('project.create') }}</a>
    </h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="min-width: 128px;">Vorschau</th>
            <th>Name</th>
            <th>Game</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <th scope="row">
                    @if($project->media->count() > 0)
                        <div class="embed-responsive embed-responsive-16by9">
                            <img class="embed-responsive-item" src="{{  $project->media->first()->getImageLink('sm') }}" alt="{{ $project->name }}"/>
                        </div>
                    @endif
                </th>
                <td>
                    <a href="{{ \EmergencyExplorer\Util\ProjectUtil::getProjectAction($project) }}" class="h4">
                        {{ $project->name }}
                    </a>
                    <p>{{ $project->description }}</p>
                </td>
                <td>{{ $project->game->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <nav>
        {!! $projects->render() !!}
    </nav>
@endsection