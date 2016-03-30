<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

use EmergencyExplorer\Project;

class HomeController extends Controller
{
    function index() {
        $projects = Project::with('media')->orderBy('updated_at','desc')->limit(5)->get();
        
        return view('home.index', compact('projects'));
    }
}
