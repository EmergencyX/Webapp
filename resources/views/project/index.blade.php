@extends('layouts.app')

@section('content')
<h1>{{ trans('project.all_projects') }} <a class="btn btn-primary pull-xs-right" href="{{ action('ProjectController@create') }}">{{ trans('project.create') }}</a></h1>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Game</th>
      <th>Link</th>
    </tr>
  </thead>
  <tbody>
  @foreach($projects as $project)
    <tr>
      <th scope="row">
          @if($project->media->count() > 0)
          <img src="{{  $project->media->first()->getThumbnail() }}" alt="{{ $project->name }}"/>
          @endif 
        </th>
      <td>{{ $project->name }}</td>
      <td>{{ $project->game->name }}</td>
      <td><a href="{{ \EmergencyExplorer\Util\ProjectUtil::getProjectAction($project) }}">Link</a></td>
    </tr>
   @endforeach
  </tbody>
</table>
@endsection