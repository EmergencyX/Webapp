<?php

namespace EmergencyExplorer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use EmergencyExplorer\User;
use EmergencyExplorer\Project;

class ProjectPolicy
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
    
    public function addUser(User $user, Project $project) {
        if (!$project->relationLoaded('admins')) {
            $project->load('admins');
        }
        
        return $project->admins->contains($user);
    }
    
    public function edit(User $user, Project $project) {
        return $project->admins->contains($user);
    }
}
