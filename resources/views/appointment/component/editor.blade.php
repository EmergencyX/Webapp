<fieldset>
    {!! Form::label('name', trans('appointment.name')) !!}
    {!! Form::text('name', isset($appointment->name) ? $appointment->name : trans('appointment.name'), ['class'=>'form-control']) !!}
</fieldset>

<fieldset>
    {!! Form::label('description', trans('appointment.description')) !!}
    {!! Form::text('description', isset($appointment->description) ? $appointment->description : trans('appointment.description'), ['class'=>'form-control']) !!}
</fieldset>

<fieldset>
    {!! Form::label('voicechat', trans('appointment.voicechat')) !!}
    {!! Form::text('voicechat', isset($appointment->voicechat) ? $appointment->voicechat : trans('appointment.voicechat'), ['class'=>'form-control']) !!}
</fieldset>

<fieldset>
    {!! Form::label('profile', trans('appointment.profile')) !!}
    {!! Form::select('profile',
    $profiles,
    isset($appointment->profile_id) ? $project->visible : '1',
    ['class'=>'c-select form-control']) !!}
    <small class="text-muted">{{ trans('project.visibility_description') }}</small>
</fieldset>

{!! Form::submit(isset($project) ? trans('project.update') : trans('project.create'),
['class'=>'btn btn-primary']) !!}