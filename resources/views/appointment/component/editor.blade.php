<fieldset>
    {!! Form::label('name', trans('appointment.name')) !!}
    {!! Form::text('name', isset($appointment->name) ? $appointment->name : trans('appointment.name'), ['class'=>'form-control']) !!}
</fieldset>
<br>
<br>

<div class="row">
    <div class="col-md-8">
        <fieldset>
            {!! Form::label('description', trans('appointment.description')) !!}
            {!! Form::textarea('description', isset($appointment->description) ? $appointment->description : trans('appointment.description'), ['class'=>'form-control']) !!}
        </fieldset>
        <br><br>
        <div class="row">
            <fieldset class="col-md-4">
                {!! Form::label('gameVersion', trans('appointment.game_version')) !!}
                {!! Form::select('gameVersion',
                ['Emergency5 - 2.1.0'],
                0,
                ['class'=>'c-select form-control']) !!}
                <small class="text-muted">{{ trans('appointment.game_version_description') }}</small>
            </fieldset>

            <fieldset class="col-md-4">
                {!! Form::label('profile', trans('appointment.project')) !!}
                {!! Form::select('profile',
                ['Testmodifikation'],
                0,
                ['class'=>'c-select form-control']) !!}
                <small class="text-muted">{{ trans('appointment.profile_description') }}</small>
            </fieldset>

            <fieldset class="col-md-4">
                {!! Form::label('profile', trans('appointment.profile')) !!}
                {!! Form::select('profile',
                $profiles->pluck('name', 'id'),
                isset($appointment->profile_id) ? $appointment->profile_id : trans('appointment.profile_id'),
                ['class'=>'c-select form-control']) !!}
                <small class="text-muted">{{ trans('appointment.profile_description') }}</small>
            </fieldset>
        </div>
        <br><br>
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="min-width: 128px;">Vorschau</th>
                <th>Name</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                    <th scope="row">
                        @if($project->media->count() > 0)
                            <div class="embed-responsive embed-responsive-16by9">
                                <img class="embed-responsive-item" src="{{  $project->media->first()->getImageLink('sm') }}" alt="{{ $project->name }}"/>
                            </div>
                        @endif
                    </th>
                    <td>
                        <a href="{{ \EmergencyExplorer\Util\ProjectUtil::getProjectAction($project) }}" class="h4">
                            {{ $project->name }}
                        </a>
                        <p>{{ $project->description }}</p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <div class="col-md-4">
        <fieldset>
            {!! Form::label('date_at', trans('appointment.date_at')) !!}
            {!! Form::datetimeLocal('date_at', isset($appointment->date_at) ? $appointment->date_at->format('yyyy-MM-ddThh:mm') : null, ['class'=>'form-control']) !!}
        </fieldset>
        <br>
        <fieldset>
            {!! Form::label('voicechat', trans('appointment.voicechat')) !!}
            <div class="input-group">
                {!! Form::text('voicechat', isset($appointment->voicechat) ? $appointment->voicechat : trans('appointment.voicechat'), ['class'=>'form-control']) !!}
                <div class="input-group-btn">
                    <button type="button" class="btn btn-secondary">
                        EM-TS3
                    </button>
                </div>
            </div>
        </fieldset>
        <br>
        <div>
            {!! Form::label('visible', trans('appointment.visible')) !!}
            <div class="input-group">
                {!! Form::select('visible',
                [0=>'Nur mit Einladung', 1=>'Öffentlich'],
                isset($appointment->visible) ? $appointment->visible : trans('appointment.visible'),
                ['class'=>'c-select form-control']) !!}
                <div class="input-group-btn">
                    <button type="button" class="btn btn-secondary">
                        Einladen
                    </button>
                </div>
            </div>
            <small class=" text-muted">{{ trans('appointment.visible_description') }}</small>
        </div>
    </div>
</div>

{!! Form::submit(isset($appointment) ? trans('appointment.update') : trans('appointment.create'),
['class'=>'btn btn-primary']) !!}