<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Util\ProjectUtil;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

use EmergencyExplorer\Game;
use EmergencyExplorer\Project;

use EmergencyExplorer\Util\MediaUtil;

class ProjectController extends Controller
{
    function __construct()
    {
        view()->share('active', 'projects');
    }

    function index()
    {
        $projects = Project::with(['game', 'media'])->get();

        return view('project.index', compact('projects'));
    }

    function show($id, $seo = null)
    {
        $project = Project::findOrFail($id);
        $slug = ProjectUtil::getProjectSlug($project);

        if (urldecode($seo) != urldecode($slug)) {

            return redirect(ProjectUtil::getProjectAction($project));
        }

        $project->load('members', 'releases', 'game', 'media');

        return view('project.show', compact('project'));
    }

    function create()
    {
        $games = Game::all()->pluck('name', 'id');

        return view('project.create', compact('games'));
    }

    function store(Request $request)
    {
        $project = Project::create($request->only(['name', 'description', 'status', 'game_id', 'visible']));
        $project->users()->save($request->user(), ['role' => Project::PROJECT_ROLE_ADMIN]);

        return redirect(ProjectUtil::getProjectAction($project));
    }

    function edit($id)
    {
        $project = Project::findOrFail($id);
        $games = Game::all()->pluck('name', 'id');

        return view('project.edit', compact('project', 'games'));
    }

    function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->only(['name', 'description', 'status', 'visible']));
        $project->save();

        return redirect(ProjectUtil::getProjectAction($project));
    }

    function createMedia($id)
    {
        //Todo: Check permission
        $project = Project::findOrFail($id);

        return view('project.create_media', compact('project'));
    }

    function storeMedia(Request $request, $id)
    {
        //Todo: Check permission
        $user = $request->user();
        $project = Project::findOrFail($id);
        $file = $request->file('media');
        if ($request->hasFile('media') && $file->isValid()) {
            $media = MediaUtil::createMedia($request->only('name', 'description'), $file);
            $project->media()->save($media);
        }   
        return redirect(ProjectUtil::getProjectAction($project));
    }

    public function delete(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        abort_if($request->user()->cannot('remove', $project), 403);

        $project->media()->get()->each(function ($media) {
            MediaUtil::deleteMedia($media);
        });
        $project->members()->detach();
        //delete some more here
        $project->delete();

        return redirect()->action('HomeController@index');
    }
}