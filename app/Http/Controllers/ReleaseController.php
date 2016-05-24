<?php

namespace EmergencyExplorer\Http\Controllers;

use Gate;

use EmergencyExplorer\Project;
use EmergencyExplorer\ProjectRepository;
use EmergencyExplorer\Release;
use EmergencyExplorer\Util\ProjectUtil;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $project = Project::with(['repositories', 'repositories.releases'])->findOrFail($id);

        return view('project.release.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $project = Project::with([
            'game',
            'game.versions',
            'repositories',
            'repositories.releases',
        ])->findOrFail($id);
        $repository = $project->repositories->first();

        return view('project.release.create', compact('project', 'repository'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Project $project
     * @param \EmergencyExplorer\ProjectRepository $repository
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project, ProjectRepository $repository)
    {
        $release = new Release($request->only(['name', 'beta', 'visible', 'game_version_id']));
        $repository->releases()->save($release);

        return redirect(action('ReleaseController@show', [$project->id, $release->id]));
    }

    public function createFromUpload()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param  int $release_id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id, $release_id)
    {
        $project = Project::findOrFail($id);
        $release = Release::findOrFail($release_id);

        return view('project.release.show', compact('project', 'release'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * @param Project $project
     * @param Release $release
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     * @throws \Exception
     */
    public function destroy(Project $project, Release $release)
    {
        if (Gate::allows('edit', $project)) {
            $release->delete();
        }

        return redirect(ProjectUtil::getProjectAction($project));
    }
}
