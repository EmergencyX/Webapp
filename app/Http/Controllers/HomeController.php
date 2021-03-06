<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use EmergencyExplorer\Repositories\Project as ProjectRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $projects = $this->projectRepository->recentProjects($request->user());

        return view('home.index', compact('projects'));
    }

    /**
     * @return View
     */
    public function contact()
    {
        return view('home.contact');
    }


    public function download()
    {
        $view = view('home.download');

        if ($projectId = session('want_to_play_project')) {
            $view->with('project', $this->projectRepository->find($projectId));
        }

        return $view;
    }
}
