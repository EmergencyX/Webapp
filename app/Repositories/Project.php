<?php

namespace EmergencyExplorer\Repositories;

use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\User as UserModel;
use EmergencyExplorer\Util\ProjectRepositoryUtil;
use Illuminate\Database\Eloquent\Collection;

class Project
{
    /**
     * @var ProjectModel
     */
    protected $project;

    /**
     * Project constructor.
     *
     * @param \EmergencyExplorer\Project $project
     */
    public function __construct(ProjectModel $project)
    {
        $this->project = $project;
    }

    /**
     * @param integer $projectId
     *
     * @return ProjectModel|null
     */
    public function find(integer $projectId)
    {
        return $this->project->findOrFail($projectId);
    }

    /**
     * @param UserModel $user
     *
     * @return Collection
     */
    public function recentProjects(UserModel $user = null)
    {
        $query = $this->visibleProjects($user);
        $query->orderBy('updated_at', 'desc')->limit(9);
        $query->with(['users']);
        return $query->get();
    }

    /**
     * @param UserModel $user
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginated(UserModel $user = null)
    {
        $query = $this->visibleProjects($user);

        return $query->paginate(25);
    }

    /**
     * @param UserModel|null $user
     *
     * @return mixed
     */
    protected function visibleProjects(UserModel $user = null)
    {
        $query = $this->project->with(['media', 'releases'])->where('visible', 1);

        if ($user) {
            $query->orWhereHas('users', function ($query) use ($user) {
                $query->where('project_user.user_id', $user->id);
            });
        }

        return $query;
    }

    /**
     * @param array $parameters
     *
     * @return ProjectModel
     */
    public function createProject(array $parameters)
    {
        $project = $this->project->create($parameters);
        $project->repositories()->save(ProjectRepositoryUtil::newMainRepository($project));

        return $project;
    }

    /**
     * Ensure project followers are removed when the project is marked as private
     *
     * @param ProjectModel $project
     * @param bool $visible
     */
    public function updateVisibility(ProjectModel $project, bool $visible = true)
    {
        if (! $visible) {
            $project->watchers()->detach();
        }
    }
}