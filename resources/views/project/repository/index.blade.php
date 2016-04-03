@extends('layouts.app')

@section('content')
    <h1>Repositories
        <br>
        <small>für {{ $project->name }}</small>
    </h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Release erstellen</th>
        </tr>
        </thead>
        <tbody>
              @foreach($project->repositories as $repository)
            <tr>
                <th scope="row">{{ $repository->id }}</th>
                <td>{{ $repository->name }}</td>
                <td><a href="{{ action('ReleaseController@create', [$project->id, $repository->id]) }}">Release
                                                                                                        erstellen</a>
                </td>
            </tr>
               @endforeach
        </tbody>
    </table>

@endsection