@extends('layouts.app')

@section('content')
    <h1>{{ trans('user.profile_of') }} {{ $user->name }}</h1>
    {{--
    @can('edit', $user)
        <a href="{{ action('UserController@edit', $user->id) }}" class="btn btn-primary">{{ trans('user.edit') }}</a>
    @endcan
    --}}
    <h3>{{ trans('user.projects_of') }} {{ $user->name }}</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Role</th>
            <th>Check it out</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <th scope="row">{{ $project->id }}</th>
                <td>{{ $project->name }}</td>
                <td>{{ trans('project.role.' . $projectRoles[$project->id]) }}</td>
                <td>{{ \EmergencyExplorer\Util\ProjectUtil::getProjectAction($project) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection