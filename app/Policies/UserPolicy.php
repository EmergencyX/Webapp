<?php

namespace EmergencyExplorer\Policies;

use EmergencyExplorer\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param $caller
     * @param $target
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
     * @param User $user
     *
     * @return bool
     */
    public function admin(User $user)
    {
        return true; // (/^-^)/
    }
}
