{{-- 
HEADS UP
This file is meant to be included by notification.index 
--}}
<h1>{{ trans('invitation.all_pending_invitations') }}</h1>
<table class="table table-inverse">
  <thead>
    <tr>
      <th>Id</th>
      <th>Von</th>
      <th>Update</th>
    </tr>
  </thead>
  <tbody>
  @foreach($invitations as $invitation)
    <tr>
      <th scope="row">{{ $invitation->id }}</th>
      <td>{{ $invitation->fromUser->name }}</td>
      <td>
      {!! Form::open(['action'=>'InvitationController@update']) !!}
        {!! Form::token() !!}
        {!! Form::hidden('invitation_id', $invitation->id) !!}
        {!! Form::submit('L10N accept', ['name'=>'accept','class'=>'btn btn-primary']) !!}
        {!! Form::submit('L10N reject', ['name'=>'reject','class'=>'btn btn-secondary']) !!}
      {!! Form::close() !!}
      </td>
    </tr>
   @endforeach
  </tbody>
</table>


{!! Form::open(['action'=>'InvitationController@resetRejected', 'method'=>'delete']) !!}
    {!! Form::token() !!}
    {!! Form::label('reset-reject-list', 'Manchmal ist es an der Zeit zu vergeben') !!}
    {!! Form::submit('L10N Banliste zurücksetzen', ['class'=>'btn btn-secondary', 'name'=>'reset-reject-list']) !!}
{!! Form::close() !!}