<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Repositories\Project as ProjectRepository;
use Illuminate\Http\Request;

class ProjectController extends ApiController
{
    protected $projectRepository;

    /**
     * ProjectController constructor.
     *
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function recent(Request $request)
    {
        //abort_unless($this->getCaller()->tokenCan('access-project'), 401);

        return \Response::json($this->projectRepository->recentProjects($this->getCaller()));
    }

    public function show(Project $project)
    {
        if (! $project->visible) {
            abort_unless($this->getCaller()->tokenCan('access-project'), 401);
            $this->authorizeForUser($this->getCaller(), $project);
        }

        return \Response::json($project);
    }

    public function create(Request $request)
    {
        $this->authorize(Project::class);

        return \Response::json($request->all());
    }
}
