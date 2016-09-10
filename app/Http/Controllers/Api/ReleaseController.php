<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\Release;
use EmergencyExplorer\Repositories\Release as ReleaseRepository;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Controllers\Controller;

class ReleaseController extends Controller
{
    /**
     * @var \EmergencyExplorer\Repositories\Release
     */
    protected $releaseRepository;

    /**
     * ReleaseController constructor.
     */
    public function __construct(ReleaseRepository $releaseRepository)
    {
        $this->releaseRepository = $releaseRepository;
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
        return $project->releases->map(function (Release $release) {
            return [
                'id'              => $release->getKey(),
                'name'            => $release->name,
                'beta'            => $release->beta,
                'game_version_id' => $release->game_version_id,
                'created_at'      => $release->created_at->toDateTimeString(),
                'updated_at'      => $release->updated_at->toDateTimeString(),
            ];
        });
    }

    public function remove(Release $release)
    {
        $this->releaseRepository->remove($release);

        return response()->json(['status' => 'success']);
    }
}
