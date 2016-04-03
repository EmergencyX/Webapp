<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Project;
use EmergencyExplorer\ProjectRepository;
use EmergencyExplorer\Release;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @param $project_repository_id
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $project_repository_id)
    {
        $project           = Project::findOrFail($id);
        $projectRepository = ProjectRepository::findOrFail($project_repository_id);

        return view('project.release.create', compact('project', 'projectRepository'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
