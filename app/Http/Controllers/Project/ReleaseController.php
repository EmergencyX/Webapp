<?php

namespace EmergencyExplorer\Http\Controllers\Project;

use EmergencyExplorer\Http\Controllers\Controller;
use EmergencyExplorer\Models\Project as ProjectModel;
use EmergencyExplorer\Models\Release;
use EmergencyExplorer\Util\Project\ProjectUtil;
use EmergencyExplorer\Util\Project\ReleaseUtil;
use Illuminate\Http\Request;

class ReleaseController extends Controller
{
    /**
     * @var ReleaseUtil
     */
    protected $releaseUtil;

    /**
     * @var ProjectUtil
     */
    protected $projectUtil;

    /**
     * ReleaseController constructor.
     *
     * @param ReleaseUtil $releaseUtil
     * @param ProjectUtil $projectUtil
     */
    public function __construct(ReleaseUtil $releaseUtil, ProjectUtil $projectUtil)
    {
        $this->releaseUtil = $releaseUtil;
        $this->projectUtil = $projectUtil;
    }

    public function create(ProjectModel $project)
    {
        return view('project.release.create', compact('project'));
    }

    public function download(ProjectModel $project)
    {

    }

    public function store(ProjectModel $project, Request $request)
    {
        $processor     = $this->releaseUtil->getLocalProcessor();
        $release       = $processor->store($request->file('release'));
        $release->name = $request->get('name', '');

        $project->releases()->save($release);

        return redirect($this->projectUtil->url($project));
    }

    public function remove(ProjectModel $project, Release $release)
    {
        $this->releaseUtil->getLocalProcessor()->remove($release);
    }
}
