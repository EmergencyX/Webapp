<?php

namespace EmergencyExplorer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use EmergencyExplorer\User;
use EmergencyExplorer\Invitation;

class InvitationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Determine if the given invitation can be updated by the user.
     *
     * @param  \EmergencyExplorer\User  $user
     * @param  \EmergencyExplorer\Intivation  $invitation
     * @return bool
     */
    public function update(User $user, Invitation $invitation)
    {
       return ($invitation->for_user_id == $user->id) ||
       ($invitation->from_user_id == $user->id);
    }
}
