@extends('layouts.app') @section('content')
    <h1>Beliebt</h1>
    <div class="row">
        @foreach($projects as $project)
            <div class="col-md-4">
                <a href="{{ action('ProjectController@show', ['id'=>$project->id, 'seo'=>str_slug($project->name)]) }}">
                    <div class="card card-inverse">
                        <img class="card-img img-fluid" src="{{ \EmergencyExplorer\Util\MediaUtil::getThumbnail($project->media->first(), 'md') }}" alt="">
                        <div class="card-img-overlay" style="top:initial;bottom:0;background: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0.65) 100%);
background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%);
background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#a6000000',GradientType=0 );
">
                            <h4 class="card-title m-b-0">{{ $project->name }}</h4>
                            <p class="card-text">{{ $project->description }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection