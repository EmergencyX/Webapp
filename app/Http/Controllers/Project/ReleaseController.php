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
        $this->authorize('edit', $project);

        return view('project.release.create', compact('project'));
    }

    public function download(ProjectModel $project, Release $toRelease)
    {
        $fromRelease = Release::find(request('from'));
        //$this->authorize('download', $project);
        return redirect($this->releaseUtil->url($toRelease, $fromRelease));
    }

    public function store(ProjectModel $project, Request $request)
    {
        $this->authorize('edit', $project);

        $processor = $this->releaseUtil->getProcessorByName($request->get('processor'));

        $release                  = $processor->store($request->file('release'));
        $release->name            = $request->get('name', 'Unbenannt');
        $release->beta            = intval($request->get('beta', 0));
        $release->visible         = intval($request->get('visible', 0));
        $release->game_version_id = intval($request->get('game_version_id', 0));

        $project->releases()->save($release);

        return redirect($this->projectUtil->url($project));
    }

    public function remove(ProjectModel $project, Release $release)
    {
        $this->authorize('edit', $project);

        $this->releaseUtil->getLocalProcessor()->remove($release);

        return redirect()->action('Project\ReleaseController@index', [$project]);
    }

    public function show(ProjectModel $project, Release $release)
    {
        $this->authorize('show', $project);

        return var_dump($release);
    }

    public function index(ProjectModel $project)
    {
        $this->authorize('show', $project);

        $releases = $project->releases;

        return view('project.release.index', compact('project', 'releases'));
    }



    public function updateCheck(Request $request)
    {
        $releases = $request->get('mods', []); //['release_id']
        //Todo Auth
        return \Response::json($this->releaseUtil->checkUpdates($releases));
    }

}
