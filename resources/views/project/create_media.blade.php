@extends('layouts.app')

@section('content')
<h1>L10N Media hinzufügen {{ $project->name }}</h1>

{!! Form::open(['action'=>['ProjectController@storeMedia', $project->id], 'method'=>'post', 'files'=>true]) !!}
<div class="row">
<div class="col-md-4">
    <fieldset>
    {!! Form::label('name', trans('media.title')) !!}
    {!! Form::text('name', 'Name',['class'=>'form-control']) !!}
    <small class="text-muted">{{ trans('media.title') }}</small>
    </fieldset>   
</div>
<div class="col-md-4">
    <fieldset>
    {!! Form::label('description', trans('media.description')) !!}
    {!! Form::text('description', 'Beschreibung', ['class'=>'form-control']) !!}
    <small class="text-muted">{{ trans('media.description') }}</small>
    </fieldset>
</div>
<div class="col-md-4">
    <fieldset>
    {!! Form::label('provider', trans('media.provider')) !!}
    {!! Form::select('provider', 
    ['local' => 'EmergencyX', 'em-upload' => 'Emergency Forum Image Upload'],
    'local',
    ['class' => 'c-select form-control']
    ) !!}
    <small class="text-muted">{{ trans('media.provider') }}</small>
    </fieldset>
</div>
</div>
    
{!! Form::file('media') !!}
{!! Form::submit('Hochladen', ['class'=>'form-control btn btn-primary']) !!}
{!! Form::close() !!}
@endsection