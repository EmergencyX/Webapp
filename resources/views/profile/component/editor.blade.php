<fieldset>
    {!! Form::label('name', trans('profile.name')) !!}
    {!! Form::text('name', isset($profile->name) ? $profile->name : trans('profile.name'), ['class'=>'form-control']) !!}
</fieldset>

<fieldset>
    {!! Form::label('description', trans('profile.description')) !!}
    {!! Form::text('description', isset($profile->description) ? $profile->description : trans('profile.description'), ['class'=>'form-control']) !!}
</fieldset>

{!! Form::submit(isset($profile) ? trans('profile.update') : trans('profile.create'), ['class'=>'btn btn-primary']) !!}