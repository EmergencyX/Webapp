<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;
use EmergencyExplorer\Invitation;


class NotificationController extends Controller
{
    public function index() {
        $invitations = Invitation::with(['forUser', 'fromUser'])
        ->where('for_user_id', auth()->user()->id)
        ->where('invitation_state', Invitation::INVITATION_STATE_PENDING)
        ->get();
        
        return view('notification.index', compact('invitations'));
    }
}
