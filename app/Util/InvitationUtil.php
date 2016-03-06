<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\Invitation;
use EmergencyExplorer\Project;

use Gate;

class InvitationUtil {
    //Todo(rs) Move this into an action?
    public static function execute(Invitation $invitation) {
        if ($invitation->invitation_state != Invitation::INVITATION_STATE_PENDING) {
            abort(403); 
        }
        
        switch ($invitation->invitation_type) {
            case Invitation::INVITATION_TYPE_PROJECT: {
                $project = Project::findOrFail($invitation->invitation_target_id);
                
                if (Gate::forUser($invitation->fromUser)->denies('add-user', $project)) {
                    abort(403);
                }
                
                return $project->users()->save($invitation->forUser, ['role' => Project::PROJECT_ROLE_MEMBER]);
            }
        }
    }
}