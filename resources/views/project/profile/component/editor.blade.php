<fieldset>
    {!! Form::label('name', trans('project_profile.name')) !!}
    {!! Form::text('name', isset($projectProfile->name) ? $projectProfile->name : trans('project_profile.name'), ['class'=>'form-control']) !!}
</fieldset>

<fieldset>
    {!! Form::label('description', trans('project_profile.description')) !!}
    {!! Form::text('description', isset($projectProfile->description) ? $projectProfile->description : trans('project_profile.description'), ['class'=>'form-control']) !!}
</fieldset>

{!! Form::submit(isset($projectProfile) ? trans('project_profile.update') : trans('project_profile.create'), ['class'=>'btn btn-primary']) !!}