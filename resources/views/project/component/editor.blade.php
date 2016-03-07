<fieldset>
{!! Form::label('name', trans('project.name')) !!}
{!! Form::text('name', isset($project->name) ? $project->name : trans('project.name'), ['class'=>'form-control']) !!}
</fieldset>

<fieldset>
{!! Form::label('description', trans('project.description')) !!}
{!! Form::text('description', isset($project->description) ? $project->description : trans('project.description'), ['class'=>'form-control']) !!}
</fieldset>

<div class="row">
  <div class="col-md-4">
    <fieldset>
    {!! Form::label('status', trans('project.status')) !!}
    {!! Form::select('status', 
    ['1' => 'Alpha', '2' => 'Beta', '3' => 'Aktiv', '4' => 'Aufgegeben'],
    isset($project->status) ? $project->status : '3',
    ['class'=>'c-select form-control']) !!}
    <small class="text-muted">{{ trans('project.automatic_abandon_description') }}</small>
    </fieldset>
  </div>
  <div class="col-md-4">
    <fieldset>
    {!! Form::label('visible', trans('project.status')) !!}
    {!! Form::select('visible', 
    ['1' => 'Öffentlich', '2' => 'Nur mit Einladung'],
    isset($project->visible) ? $project->visible : '1',
    ['class'=>'c-select form-control']) !!}
    <small class="text-muted">{{ trans('project.visibility_description') }}</small>
    </fieldset>
  </div>
  <div class="col-md-4">
    <fieldset>
    {!! Form::label('game_id', trans('project.game')) !!}
    {!! Form::select('game_id', 
    $games,
    isset($project->game_id) ? $project->game_id : null,
    ['class'=>'c-select form-control']) !!}
    <small class="text-muted">{{ trans('project.game_description') }}</small>
    </fieldset>
  </div>
</div>

{!! Form::submit(isset($project) ? trans('project.update') : trans('project.create'),
['class'=>'btn btn-primary']) !!}