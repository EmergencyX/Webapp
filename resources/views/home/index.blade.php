@extends('layouts.app') @section('content')
    <h2 class="h4 m-b-0 m-t-1 text-muted">AKTUELLE PROJEKTE</h2>
    <div class="row">
        @foreach($projects as $project)
            <div class="col-md-4">
                <a href="{{ \EmergencyExplorer\Util\ProjectUtil::getProjectAction($project) }}">
                    <div class="card card-inverse">
                        <div class="embed-responsive embed-responsive-16by9">
                            <img class="card-img embed-responsive-item img-fluid"
                                    src="{{ \EmergencyExplorer\Util\View\MediaUtil::getThumbnail($project->media->first(), 'md') }}"
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
                                <i class="fa fa-fire-extinguisher"></i> {{ $project->users()->count() }}
                                <i class="m-l-2 fa fa-play" aria-hidden="true"></i> {{ random_int(30,40) }}
                                {{--
                                May we meet again
                                <i class="m-l-2 fa fa-gamepad" aria-hidden="true"></i> {{ random_int(0,3) }}
                                --}}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection