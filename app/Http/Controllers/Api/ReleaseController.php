<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Models\Project as ProjectModel;
use EmergencyExplorer\Models\Release;
use EmergencyExplorer\Util\Project\ReleaseUtil;
use Illuminate\Http\Request;

class ReleaseController extends ApiController
{
    /**
     * @var ReleaseUtil
     */
    protected $releaseUtil;

    /**
     * ReleaseController constructor.
     *
     * @param ReleaseUtil $releaseUtil
     */
    public function __construct(ReleaseUtil $releaseUtil)
    {
        $this->releaseUtil = $releaseUtil;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ProjectModel $project
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProjectModel $project)
    {
        $file       = $request->release;
        $attributes = $request->only(['name', 'beta', 'visible', 'game_version_id', 'provider']);

        $release = $this->releaseRepository->store($project, $attributes, $file);

        return $release;
    }

    public function index(ProjectModel $project)
    {
        $this->authorizeForUser($this->getCaller(), 'show-releases', $project);
        return $this->releaseUtil->forProject($project);
    }

    public function remove(ProjectModel $project, Release $release)
    {
        abort_unless($project->id === $release->project_id, 403);
        $this->authorizeForUser($this->getCaller(), 'edit', $project);

        $this->releaseUtil->remove($release);

        return response()->make();
    }
}
