<?php

namespace EmergencyExplorer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use EmergencyExplorer\Models\User as UserModel;
use EmergencyExplorer\Models\Invitation as InvitationModel;

class InvitationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given invitation can be updated by the user.
     *
     * @param UserModel $user
     * @param InvitationModel $invitation
     *
     * @return bool
     */
    public function update(UserModel $user, InvitationModel $invitation)
    {
       return ($invitation->for_user_id == $user->id) ||
       ($invitation->from_user_id == $user->id);
    }
}
