<!DOCTYPE html>
<html lang="de">

<head>
    <title>EmergencyX</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <link rel="stylesheet" href="{{ "/css/bootstrap.min.css" }}"/>

    @include('layouts.favicon')
</head>

<body>
{{--@include('layouts.header')--}}
@include('layouts.navigation')
<div class="container">
    @yield('content')    
</div>

<script src="{{ asset("bootstrap.js") }}"></script>
</body>

</html>