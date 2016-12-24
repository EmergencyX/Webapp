<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Repositories\Project as ProjectRepository;
use Illuminate\Http\Request;

class ProjectController extends ApiController
{
    /**
     * @var \EmergencyExplorer\ProjectRepository
     */
    private $projectRepository;

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
        $projects = $this->projectRepository->recentProjects($request->user());

        return \Response::json($projects);
    }

    public function show(Project $project)
    {
        $this->authorizeForUser($this->getCaller(), 'show', $project);

        return \Response::json($project);
    }

    public function create(Request $request)
    {
        $this->authorize(Project::class);

        return \Response::json($request->all());
    }
}
