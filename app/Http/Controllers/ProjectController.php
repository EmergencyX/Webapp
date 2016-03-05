<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

use EmergencyExplorer\Project;

class ProjectController extends Controller
{
    function __construct() {
        view()->share('active', 'projects');
    }
    
    function index() {
        $projects = Project::with('game')->get();
    
        return view('project.index', ['projects' => $projects, 'active' => 'projects']);
    }
    
    function show($id, $seo = null) {
        $project = Project::findOrFail($id);
        
        $slug = str_slug($project->name);
        if ($seo != $slug) {
            return redirect(action('ProjectController@show', ['id' => $id, 'seo' => $slug]));
        }

        $members = $project->users;

        return view('project.show', ['project' => $project, 'members' => $members]);
    }
}
