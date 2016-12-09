<?php

namespace EmergencyExplorer\Policies;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Image $image
     *
     * @return bool
     */
    public function store(User $user, Image $image)
    {
        return $this->admin($user);
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
