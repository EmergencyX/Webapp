<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\Repositories\Release as ReleaseRepository;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Controllers\Controller;

class ReleaseController extends Controller
{
    /**
     * @var \EmergencyExplorer\Repositories\Release
     */
    private $releaseRepository;

    /**
     * ReleaseController constructor.
     */
    public function __construct(ReleaseRepository $releaseRepository)
    {
        $this->releaseRepository = $releaseRepository;
    }

    public function store(Request $request, ProjectModel $project)
    {
        $release = $this->releaseRepository->create(
            $request->only(['name', 'beta', 'visible', 'game_version_id']),
            $request->file('release')
        );

        $project->releases()->save($release);
    }
}
