<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

use EmergencyExplorer\Project;

class HomeController extends Controller
{
    function index() {
        $projects = Project::orderBy('updated_at','desc')->limit(4)->get();
        
        return view('home.index', compact('projects'));
    }
}
