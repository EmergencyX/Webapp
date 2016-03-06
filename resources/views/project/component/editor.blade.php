<fieldset>
{!! Form::label('project-name', trans('project.name')) !!}
{!! Form::text('project-name', isset($project->name) ? $project->name : trans('project.name')) !!}
</fieldset>

<fieldset>
{!! Form::label('project-description', trans('project.description')) !!}
{!! Form::text('project-description', isset($project->description) ? $project->description : trans('project.description')) !!}
</fieldset>

<fieldset>
{!! Form::label('project-status', trans('project.status')) !!}
{!! Form::select('project-status', 
['1' => 'Alpha', '2' => 'Beta', '3' => 'Aktiv', '4' => 'Aufgegeben'],
isset($project->status) ? $project->status : '3') !!}
</fieldset>