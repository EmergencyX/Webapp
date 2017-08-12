<!DOCTYPE html>
<html lang="de">

<head>
    <title>EmergencyX</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <link rel="stylesheet" href="{{ "/css/bootstrap.min.css" }}"/>
    <link rel="stylesheet" href="{{ "/css/app.css" }}"/>
    <link rel="stylesheet" href="{{ "/css/font-awesome.min.css" }}"/>

    @include('layouts.favicon')
</head>

<body>
{{--@include('layouts.header')--}}
@include('layouts.navigation')
<div class="container">
    @yield('content')    
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link active" href="{{ action('HomeController@contact') }}">Kontakt</a>
        </li>
    </ul>
</div>

<script src="{{ asset("bootstrap.js") }}"></script>
</body>

</html>