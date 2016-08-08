<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Project;
use EmergencyExplorer\Repositories\Project as ProjectRepository;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;
use EmergencyExplorer\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ProjectController extends Controller
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
        $this->authorize($project);

        return \Response::json($project);
    }

    public function create(Request $request)
    {
        $this->authorize(Project::class);

        return \Response::json($request->all());
    }
}
