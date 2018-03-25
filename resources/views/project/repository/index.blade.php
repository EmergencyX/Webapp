@extends('layouts.app')

@section('content')
    <h1>Repositories
        <br>
        <small>für <a href="{{ \EmergencyExplorer\Util\ProjectUtil::getProjectAction($project)  }}">{{ $project->name }}</a>
        <a href="{{ action('ProjectRepositoryController@create', $project) }}">Neues Repository erstellen</a></small>
    </h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
              @foreach($project->repositories as $repository)
            <tr>
                <th scope="row">{{ $repository->id }}</th>
                <td>{{ $repository->name }}</td>
                <td><a href="{{ action('ProjectRepositoryController@show', [$project, $repository]) }}">Repository
                                                                                                        ansehen</a>
                    <a href="{{ action('OldReleaseController', [$project->id, $repository->id]) }}">Release
                                                                                                        erstellen</a>
                </td>
            </tr>
               @endforeach
        </tbody>
    </table>

@endsection