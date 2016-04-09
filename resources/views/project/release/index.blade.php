@extends('layouts.app')

@section('content')
    <h1>Releases
        <br>
        <small>für {{ $project->name }}</small>
    </h1>           
    @foreach($project->repositories as $repository)
        <h3>{{ $repository->name }}</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Ansehen</th>
            </tr>
            </thead>
            <tbody>

            @foreach($repository->releases as $release)
                <tr>
                    <th scope="row">{{ $release->id }}
                        @if($release->beta)
                            <span class="label label-primary">Beta</span>
                        @endif
                    </th>
                    <td>{{ $release->name }}</td>
                    <td><a href="{{ action('ReleaseController@show', [$project->id, $release->id]) }}">Release
                                                                                                       ansehen</a>
                    </td>
                </tr>
                       @endforeach
            </tbody>
        </table>
    @endforeach

@endsection