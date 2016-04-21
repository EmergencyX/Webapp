<?php

namespace EmergencyExplorer\Repositories;

use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\User;
use Illuminate\Database\Eloquent\Collection;

class Project
{
    /**
     * @param \EmergencyExplorer\User $user
     *
     * @return Collection
     */
    public function recentProjects(User $user = null)
    {
        $query = $this->visibleProjects($user);
        $query->orderBy('updated_at', 'desc')->limit(9);

        return $query->get();
    }

    /**
     * @param \EmergencyExplorer\User $user
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginated(User $user = null)
    {
        $query = $this->visibleProjects($user);

        return $query->paginate(25);
    }

    protected function visibleProjects(User $user = null)
    {
        $query = ProjectModel::with('media')->where('visible', 1);

        if ($user) {
            $query->orWhereHas('users', function ($query) use ($user) {
                $query->where('project_user.user_id', $user->id);
            });
        }

        return $query;
    }
}