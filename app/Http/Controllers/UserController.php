<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

use EmergencyExplorer\User;
use EmergencyExplorer\Project;

class UserController extends Controller
{
    function __construct() {
        view()->share('active', 'users');
    }
    
    function index() {
        $users = User::all(); //Todo: Pagination
    
        return view('user.index', compact('users'));
    }
    
    function show($id, $seo = null) {
        $user = User::findOrFail($id);
        
        $slug = str_slug($user->name);
        if ($seo != $slug) {
            return redirect(action('UserController@show', ['id' => $id, 'seo' => $slug]));
        }
        
        //Todo: Order by fame
        $projects = $user->projects->take(5);
      
        //Todo: Optimize or move into a Util Class?
        $projectRoles = [];
        foreach($projects as $project) {
           $projectRoles[$project->id] = $project->users->find($user)->pivot->role;
        }

        return view('user.show', compact('user', 'projects', 'projectRoles'));
    }
}
