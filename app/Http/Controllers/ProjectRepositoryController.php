<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Project;
use EmergencyExplorer\ProjectRepository;
use EmergencyExplorer\Util\ProjectRepositoryUtil;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

class ProjectRepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $project->load('repositories');

        return view('project.repository.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $repositoryTypes = ProjectRepositoryUtil::getRepositoryTypes();

        return view('project.repository.create', compact('project', 'repositoryTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $repository = new ProjectRepository($request->only(['name', 'visible', 'repository_type']));
        $project->repositories()->save($repository);
        
        return redirect(action('ProjectRepositoryController@show', compact('project', 'repository')));
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @param ProjectRepository $repository
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, ProjectRepository $repository)
    {
        $repository->load('releases');
        
        return view('project.repository.show', compact('project','repository'));
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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
