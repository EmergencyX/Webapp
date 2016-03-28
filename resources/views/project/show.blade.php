@extends('layouts.app')

@section('content')
    <h1>{{ trans('project.project_short') }} {{ $project->name }}</h1>
@can('edit', $project)
    <a href="{{ action('ProjectController@edit', $project->id) }}" class="btn btn-primary">{{ trans('project.edit') }}</a>
@endcan
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
    <table class="table table-inverse">
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
          <td><a href="{{ \EmergencyExplorer\Util\ReleaseUtil::getDownloadLink($release) }}" class="btn btn-secondary">Download</a></td>
        </tr>
       @endforeach
      </tbody>
    </table>


@endsection