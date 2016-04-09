@extends('layouts.app')

@section('content')
    <h1>Repository {{ $repository->name }} <small><a href="{{ action('ProjectRepositoryController@index', compact('project')) }}">Alle Repositories von {{ $project->name }}</a></small></h1>
    <a href="{{ action('ReleaseController@create', [$project->id, $repository->id]) }}">Release
                                                                                        erstellen</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Release ansehen</th>
        </tr>
        </thead>
        <tbody>
              @foreach($repository->releases as $release)
            <tr>
                <th scope="row">{{ $release->id }}</th>
                <td>{{ $release->name }}</td>
                <td><a href="{{ action('ReleaseController@show', [$project->id, $release->id]) }}">Release
                                                                                                   ansehen</a>
                </td>
            </tr>
               @endforeach
        </tbody>
    </table>

@endsection