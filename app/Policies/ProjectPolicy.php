<?php

namespace EmergencyExplorer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use EmergencyExplorer\User;
use EmergencyExplorer\Project;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Check if user may add a new user
     *
     * @param User $user
     * @param Project $project
     *
     * @return bool
     */
    public function addUser(User $user, Project $project)
    {
        if (! $project->relationLoaded('admins')) {
            $project->load('admins');
        }

        return $project->admins->contains($user);
    }

    public function edit(User $user, Project $project)
    {
        $auth = $project->admins->contains($user);

        return $auth;
    }

    /**
     * Check if user may delete project
     *
     * @param User $user
     * @param Project $project
     *
     * @return bool
     */
    public function remove(User $user, Project $project)
    {
        return $this->edit($user, $project);
    }
}
