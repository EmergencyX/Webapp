<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

use EmergencyExplorer\Invitation;

class InvitationController extends Controller
{
    function __construct() {
        //view()->share('active', 'projects');
    }
    
    function index() {

    }
    
    function create(Request $request) {
        //todo: validation
        // - check if user can add to a project / ...
        //   - is in project / ...
        //   - has privilegies
        // - check the user who is about to be invited is not already in this project / ...
        $invitation = Invitation::firstOrNew([
            'from_user_id' => $user,
            'for_user_id' => ,
            'invitation_target_id' =>,
            'invitation_type' => ,
        ]);

        if ($invitation->exists()) {
            return;
        }

        $invitation->save();
    }

    function update(Request $request) {
        $invitation = Invitation::firstOrFail($request->invitation_id);
        //todo: validiation
        if ($request->status === Invitation::INVITATION_STATE_REJECT) {
            $invitation->invitation_state = Invitation::INVITATION_STATE_REJECT;
        } else {
            //todo: actually add to project or whatever
            $invitation->delete();
        }
    }
}
