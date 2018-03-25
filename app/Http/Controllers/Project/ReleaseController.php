<?php

namespace EmergencyExplorer\Http\Controllers\Project;

use EmergencyExplorer\Http\Controllers\Controller;
use EmergencyExplorer\Http\Requests\Project\CreateRelease;
use EmergencyExplorer\Models\Release;
use Illuminate\Http\Request;

class ReleaseController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRelease $request
     * @return void
     */
    public function store(CreateRelease $request)
    {
        $request->file()->storeAs($request->project()->name, $request->get('name'));
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
