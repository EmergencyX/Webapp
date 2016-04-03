<?php

namespace EmergencyExplorer\Policies;

use EmergencyExplorer\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param \EmergencyExplorer\User $caller
     * @param \EmergencyExplorer\User $target
     *
     * @return bool
     */
    public function edit(User $caller, User $target)
    {
        if ($caller->id === $target->id) {
            return true;
        }

        return $this->admin($caller);
    }

    /**
     * @param \EmergencyExplorer\User $user
     *
     * @return bool
     */
    public function admin(User $user)
    {
        return true; // (/^-^)/
    }
}
