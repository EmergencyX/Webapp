<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

use EmergencyExplorer\Game;
use EmergencyExplorer\Project;

use EmergencyExplorer\Util\MediaUtil;

class ProjectController extends Controller
{
    function __construct() {
        view()->share('active', 'projects');
    }
    
    function index() {
        $projects = Project::with(['game', 'media'])->get();
    
        return view('project.index', compact('projects'));
    }
    
    function show($id, $seo = null) {
        $project = Project::findOrFail($id);
        
        $slug = str_slug($project->name);
        if ($seo != $slug) {
            return redirect(action('ProjectController@show', ['id' => $id, 'seo' => $slug]));
        }
        
        $project->load('members', 'releases', 'game', 'media');
        
        return view('project.show', compact('project'));
    }
    
    function create() {
        $games = Game::all()->pluck('name','id');
        
        return view('project.create', compact('games'));
    }
    
    function store(Request $request) {
        $project = Project::create($request->only(['name','description','status','game_id','visible']));
        $project->users()->save($request->user(), ['role' => Project::PROJECT_ROLE_ADMIN]);
        
        return redirect(action('ProjectController@show', ['id' => $project->id, 'seo' => str_slug($project->name)]));
    }
    
    function edit($id) {
        $project = Project::findOrFail($id);
        $games = Game::all()->pluck('name','id');

        return view('project.edit', compact('project', 'games'));
    }
    
    function update(Request $request, $id) {
        $project = Project::findOrFail($id);
        $project->update($request->only(['name','description','status','visible']));
        $project->save();
        
        return redirect(action('ProjectController@show', ['id' => $project->id, 'seo' => str_slug($project->name)]));
    }
  
    function createMedia($id) {
        //Todo: Check permission
        $project = Project::findOrFail($id);
        return view('project.create_media', compact('project'));
    }
    
    function storeMedia(Request $request, $id) {
        //Todo: Check permission
        $user = $request->user();
        $project = Project::findOrFail($id);
        if ($request->hasFile('media') && ($file = $request->file('media'))->isValid()) {
            $media = MediaUtil::createMedia($request->only('name','description'), $file);
            $project->media()->save($media);
        }
        
        return redirect(action('ProjectController@show', ['id' => $project->id, 'seo' => str_slug($project->name)]));
    }
}