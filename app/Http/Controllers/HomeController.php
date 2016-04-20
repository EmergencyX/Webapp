<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use EmergencyExplorer\Repositories\Project as ProjectRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

class HomeController extends Controller
{
    /**
     * @var \EmergencyExplorer\Repositories\Project
     */
    protected $projectRepository;

    /**
     * HomeController constructor.
     *
     * @param \EmergencyExplorer\Http\View\Helper\NavigationHelper $navigationHelper
     */
    public function __construct(NavigationHelper $navigationHelper, ProjectRepository $projectRepository)
    {
        $navigationHelper->setSection(NavigationHelper::HOME);
        $this->projectRepository = $projectRepository;
    }

    /**
     * @return View
     */
    function index(Request $request) {
        $projects = $this->projectRepository->recentProjects($request->user());
        
        return view('home.index', compact('projects'));
    }
}
