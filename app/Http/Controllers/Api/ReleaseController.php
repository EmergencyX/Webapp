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
     * @param Request $request
     * @param ProjectModel $project
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProjectModel $project)
    {
        $this->authorizeForUser($this->getCaller(), 'edit', $project);

        $attributes = $request->only(['name', 'beta', 'visible', 'game_version_id', 'provider']);

        $processor = $this->releaseUtil->getLocalProcessor();
        $release   = $processor->store($request->file('release'));
        $release->update($attributes);
        $project->releases()->save($release);

        return response()->json($release);
    }

    /**
     * @param ProjectModel $project
     *
     * @return mixed
     */
    public function index(ProjectModel $project)
    {
        $this->authorizeForUser($this->getCaller(), 'show-releases', $project);

        return $this->releaseUtil->forProject($project);
    }

    /**
     * @param ProjectModel $project
     * @param Release $release
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(ProjectModel $project, Release $release)
    {
        abort_unless($project->id === $release->project_id, 403);
        $this->authorizeForUser($this->getCaller(), 'edit', $project);

        $this->releaseUtil->remove($release);
        $release->delete();

        return response()->make();
    }
}
