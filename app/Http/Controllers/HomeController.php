<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

use EmergencyExplorer\Project;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     *
     * @param \EmergencyExplorer\Http\View\Helper\NavigationHelper $navigationHelper
     */
    public function __construct(NavigationHelper $navigationHelper)
    {
        $navigationHelper->setSection(NavigationHelper::HOME);
    }

    /**
     * @return View
     */
    function index(Request $request) {
        $private  = $request->user() ? $request->user()->projects->pluck('id') : [];
        $projects = Project::with('media')
            ->whereIn('id', $private)
            ->orWhere('visible', 1)
            ->orderBy('updated_at','desc')
            ->limit(9)
            ->get();
        
        return view('home.index', compact('projects'));
    }
}
