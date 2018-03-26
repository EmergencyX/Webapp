<?php

namespace EmergencyExplorer\Http\Controllers\Project;

use EmergencyExplorer\Http\Controllers\Controller;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Models\Release;
use EmergencyExplorer\Rules\Semver;
use EmergencyExplorer\Util\TokenUtil;
use Illuminate\Http\Request;

class ReleaseController extends Controller
{
    /**
     * @var TokenUtil
     */
    protected $tokenUtil;

    /**
     * ReleaseController constructor.
     */
    public function __construct(TokenUtil $tokenUtil)
    {
        $this->tokenUtil = $tokenUtil;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tusToken = $this->tokenUtil->generateTusToken(auth()->user());
        return view('project.release.create', compact('project', 'tusToken'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Project $project
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project, Request $request)
    {
        $validator = \Validator::make([
            'name' => $request->input('name'),
            'file' => $request->file('file'),
            'version' => $request->input('version')
        ], [
            'name' => 'required|string|max:255',
            'file' => 'required|file',
            'version' => ['required', new Semver]
        ]);

        abort_unless($project->admins->contains($request->user()), 403);
        abort_unless($validator->passes(), 403);

        $filename = str_random(40);
        $request->file('file')->storeAs('releases/' . $project->id, $filename);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \EmergencyExplorer\Models\Release $release
     * @return \Illuminate\Http\Response
     */
    public function show(Release $release)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \EmergencyExplorer\Models\Release $release
     * @return \Illuminate\Http\Response
     */
    public function edit(Release $release)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \EmergencyExplorer\Models\Release $release
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Release $release)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \EmergencyExplorer\Models\Release $release
     * @return \Illuminate\Http\Response
     */
    public function destroy(Release $release)
    {
        //
    }
}
