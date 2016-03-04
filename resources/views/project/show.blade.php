@extends('layouts.app')

@section('content')
    <h1><small>{{ trans('project.project_short') }}</small> {{ $project->name }}</h1>
    <pre>{{ var_dump($project) }}</pre>
@endsection