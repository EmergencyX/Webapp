@extends('layouts.app')

@section('content')
    @if(auth()->check())
        <pre>
            sudo rm -rf /
        </pre>
        <p>Sorry, anscheinend fehlt dir die Berechtigung für diese Aktion</p>
    @else
        <p><a href="{{ action('Auth\LoginController@showLoginForm') }}">Bitte melde dich an</a> und probiere es dann nochmal</p>
    @endif
@endsection