<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

use EmergencyExplorer\Invitation;
use EmergencyExplorer\Http\Requests\UpdateInvitationRequest;

use EmergencyExplorer\Util\InvitationUtil;

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
       /* $invitation = Invitation::firstOrNew([
            'from_user_id' => $user,
            'for_user_id' => ,
            'invitation_target_id' =>,
            'invitation_type' => ,
        ]);*/

        if ($invitation->exists()) {
            return;
        }

        $invitation->save();
    }

    function update(UpdateInvitationRequest $updateInvitationRequest) {
        $invitation = $updateInvitationRequest->getInvitation();

        if ($updateInvitationRequest->reject) {
            $invitation->invitation_state = Invitation::INVITATION_STATE_REJECTED;
            $invitation->save();
            logger()->notice('rejected the invite');
        } else {
            if ($invitation->for_user_id != auth()->user()->id) {
               abort(403); //While the requester (from) may cancel, he may not accept for the other person 
            }

            if (InvitationUtil::execute($invitation)) {
                $invitation->delete();
                logger()->notice('deleted the invite');
            }
            //well, this should not happen. Maybe just return?
        }
        
        return back();
    }
    
    function resetRejected() {
        Invitation::where('for_user_id', auth()->user()->id)
        ->where('invitation_state', Invitation::INVITATION_STATE_REJECTED)
        ->delete();
    }
}
