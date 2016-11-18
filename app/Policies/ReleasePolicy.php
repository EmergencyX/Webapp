<?php

namespace EmergencyExplorer\Policies;

use EmergencyExplorer\Models\Release;
use EmergencyExplorer\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReleasePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Release $release
     *
     * @return bool
     */
    public function download(User $user, Release $release)
    {
        if (! $release->relationLoaded('repository.project.usersWithoutWatchers')) {
            $release->load('repository.project.usersWithoutWatchers');
        }

        if ($release->repository->project->usersWithoutWatchers->contains($user)) {
            //User is tester or member -> always grant access
            return true;
        }

        if ($release->visible && $release->repository->visible && $release->repository->project->visible) {
            //Check if everything is visible -> public
            return true;
        }
        
        return false;
    }
}
