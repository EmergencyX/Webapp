@extends('layouts.app')

@section('content')
    <h1><small>{{ trans('project.project_short') }}</small> {{ $project->name }}</h1>
  
    <table class="table table-inverse">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
      @foreach($members as $member)
        <tr>
          <th scope="row">{{ $member->id }}</th>
          <td>{{ $member->name }}</td>
          <td>{{ $member->pivot->role }}</td>
        </tr>
       @endforeach
      </tbody>
    </table>
  
    <pre>{{ var_dump($members) }}</pre>



@endsection