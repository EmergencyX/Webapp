@extends('layouts.app')

@section('content')
    <h1>{{ trans('project.project_short') }} {{ $project->name }}</h1>
    @can('edit', $project)
    <a href="{{ action('ProjectController@edit', $project->id) }}" class="btn btn-primary">{{ trans('project.edit') }}</a>
    <a href="{{ action('ProjectController@createMedia', $project->id) }}" class="btn btn-secondary">{{ trans('project.create_media') }}</a>
    <a href="{{ action('ProjectController@delete', $project->id) }}" class="btn btn-danger">{{ trans('project.delete') }}</a>
    @endcan

    <p>{{ $project->description }}</p>
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
                <td>{{ $member->name }}</td>
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