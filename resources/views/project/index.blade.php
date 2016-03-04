@extends('layouts.app')

@section('content')
<h1>{{ trans('project.all_projects') }}</h1>
<table class="table table-inverse">
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
      <th scope="row">{{ $project->id }}</th>
      <td>{{ $project->name }}</td>
      <td>{{ $project->game->name }}</td>
      <td><a href="{{ action('ProjectController@show', ['id'=>$project->id, 'seo'=>str_slug($project->name)]) }}">Link</a></td>
    </tr>
   @endforeach
  </tbody>
</table>
<pre>{{ var_dump($projects) }}</pre>

@endsection