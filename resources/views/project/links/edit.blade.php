@extends('layouts.app')

@section('content')
    <h1>{{ trans('link.edit') }}
        <br>
        <small>für <a href="{{ \EmergencyExplorer\Util\ProjectUtil::getProjectAction($project) }}">{{ $project->name }}</a></small>
    </h1>
    {!! Form::open(['action'=>['LinkController@update', $project], 'method'=>'patch']) !!}
    {!! Form::token() !!}

    <table class="table">
        <thead class="thead-inverse">
        <tr>
            <th>Titel</th>
            <th>Url</th>
            <th>Typ</th>
            <th>Löschen</th>
        </tr>
        </thead>
        <tbody>
        @forelse($links as $link)
            <tr>
                <td>{!! Form::text("links[$link->id][name]", $link->name, ['class'=>'form-control']) !!}</td>
                <td>{!! Form::text("links[$link->id][url]", $link->url, ['class'=>'form-control']) !!}</td>
                <td>{!! Form::select("links[$link->id][type]",
                        ['support' => 'Seitenleiste', 'aggregator' => 'Aktivitätsquelle'],
                        $link->type,
                        ['class'=>'c-select form-control']) !!}
                </td>
                <td><a href="{{ action('LinkController@delete', [$project, $link]) }}" class="btn btn-danger">Löschen</a>
                </td>
            </tr>
        @empty
            <td colspan="4">Keine Links</td>
        @endforelse
        </tbody>
    </table>

    {!! Form::submit('Speichern', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}

    {!! Form::open(['action'=>['LinkController@store', $project], 'method'=>'post']) !!}
    {!! Form::token() !!}
    <h2 class="m-t-3">Neuen Link hinzufügen</h2>
    <div class="row">
        <fieldset class="form-group  col-md-4">
            {!! Form::label('name', trans('link.name')) !!}
            {!! Form::text("name", '', ['class'=>'form-control']) !!}
        </fieldset>
        <fieldset class="form-group col-md-4">
            {!! Form::label('url', trans('link.url')) !!}
            {!! Form::text('url', '', ['class'=>'form-control']) !!}
        </fieldset>
        <fieldset class="form-group  col-md-4">
            {!! Form::label('type', trans('link.type')) !!}
            {!! Form::select('type',
                ['support' => 'Seitenleiste', 'aggregator' => 'Aktivitätsquelle'],
                'support',
                ['class'=>'c-select form-control']) !!}
        </fieldset>
    </div>

    {!! Form::submit('Speichern', ['class'=>'btn btn-primary']) !!}

    {!! Form::close() !!}

@endsection
