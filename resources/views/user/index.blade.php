@extends('layouts.app') @section('content')
<h1>{{ trans('user.all_users') }}</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Profil</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td><a class="btn btn-secondary" href="{{ $userUtil->url($user) }}">Profil ansehen</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection