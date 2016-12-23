<?php

namespace EmergencyExplorer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use EmergencyExplorer\Models\User;
use EmergencyExplorer\Models\Project;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return true;
    }

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
        return $this->edit($user, $project);
    }

    public function edit(User $user, Project $project)
    {
        return $project->admins->contains($user);
    }

    public function showReleases(User $user, Project $project)
    {
        if ($project->visible) {
            return true;
        }

        return $project->usersWithoutWatchers->contains($user);
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

    public function show(User $user, Project $project)
    {
        if ($project->visible) {
            return true;
        }

        return $project->usersWithoutWatchers->contains($user);
    }
}
