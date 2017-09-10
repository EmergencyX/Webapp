@extends('layouts.app') @section('content')
    <h1>Emergency Explorer</h1>
    @if(env('DEMO', true))
        <p>Mit dem Emergency Explorer wollen wir das Modding für Emergency 5 verbessern.<br>
            Nebenbei betreiben wir einige kleinere Dienste für die Community:</p>

        <h2>Multiplayer für Emergency 4</h2>
        <p>Wir kümmern uns um das Matchmaking für Emergency 4. Eine Übersicht über alle Spiele Echtzeit ist unter
            "Multiplayer" verfügbar. Für Emergency 5 können wir diesen Dienst leider nicht anbieten.
            <a href="http://www.emergency-forum.de/index.php?thread/63678-emergencyx-masterserver">
                Weitere Informationen
            </a>
        </p>

        <h2>FMS für Emergency 4 Bieberfelde Modifikation</h2>
        <p>
            Das FMS für die Bieberfelde Modifikation ist unter "FMS" verfügbar.
            <a href="http://www.emergency-forum.de/index.php?thread/63578-fms-server">
                Weitere Informationen
            </a>
        </p>
    @else
        <h2 class="h4 m-b-0 m-t-1 text-muted">AKTUELLE PROJEKTE</h2>
        <div class="row">
            @foreach($projects as $project)
                <div class="col-md-4">
                    <a href="{{ $projectUtil->url($project) }}">
                        <div class="card card-inverse">
                            <div class="embed-responsive embed-responsive-16by9">
                                <img class="card-img embed-responsive-item img-fluid"
                                     src="{{ $projectUtil->cover($project) }}"
                                     alt="{{ $project->name }}">
                            </div>
                            <div class="card-img-overlay" style="top:initial;bottom:0;background: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0.65) 100%);
background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%);
background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#a6000000',GradientType=0 );
">
                                <h4 class="card-title m-b-0" style="overflow: hidden;text-overflow: ellipsis;">{{ $project->name }}</h4>
                                <p class="card-text">
                                <span style="overflow: hidden;text-overflow: ellipsis; display:block; white-space: nowrap;">
                                    {{ str_limit($project->description) }}
                                </span>
                                    {{--
                                    <i class="fa fa-fire-extinguisher"></i>  $project->users()->count()
                                    <i class="m-l-2 fa fa-play" aria-hidden="true"></i> {{ random_int(30,40) }}
                                    <i class="m-l-2 fa fa-gamepad" aria-hidden="true"></i> {{ random_int(0,3) }}
                                    --}}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection