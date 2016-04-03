@extends('layouts.app')

@section('content')
@include('invitation.index', ['invitations' => $invitations])


@endsection