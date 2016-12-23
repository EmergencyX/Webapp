<?php

namespace EmergencyExplorer\Http\Controllers\Project;

use EmergencyExplorer\Http\Controllers\Controller;
use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use EmergencyExplorer\Repositories\Project as ProjectRepository;

use EmergencyExplorer\Util\Project\ProjectUtil;
use Illuminate\Http\Request;

use EmergencyExplorer\Models\Game;
use EmergencyExplorer\Models\Project;

class ProjectController extends Controller
{
    /**
     * @var ProjectRepository
     */
    protected $projectRepository;
    /**
     * @var ProjectUtil
     */
    protected $projectUtil;

    /**
     * ProjectController constructor.
     *
     * @param NavigationHelper $navigationHelper
     * @param ProjectUtil $projectUtil
     * @param ProjectRepository $projectRepository
     */
    public function __construct(
        NavigationHelper $navigationHelper,
        ProjectUtil $projectUtil,
        ProjectRepository $projectRepository
    ) {
        $navigationHelper->setSection(NavigationHelper::PROJECTS);
        $this->projectUtil       = $projectUtil;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    function index(Request $request)
    {
        $projects = $this->projectRepository->paginated($request->user());

        return view('project.index', compact('projects'));
    }

    function show(Project $project, $seo = null)
    {
        $this->authorize('show', $project);

        $slug = $this->projectUtil->slug($project);

        if (urldecode($seo) != urldecode($slug)) {

            dd([urldecode($seo), urldecode($slug)]);

            return redirect($this->projectUtil->url($project));
        }

        $project->load('members', 'releases', 'game');

        return view('project.show', compact('project'));
    }

    function create()
    {
        $this->authorize('create', Project::class);

        $games = Game::all()->pluck('name', 'id');

        return view('project.create', compact('games'));
    }

    function store(Request $request)
    {
        $this->authorize('create', Project::class);

        try {
            $project = $this->projectRepository->createProject($request->only([
                'name',
                'description',
                'status',
                'game_id',
                'visible',
            ]));
            $project->users()->save($request->user(), ['role' => Project::PROJECT_ROLE_ADMIN]);

             return redirect($this->projectUtil->url($project));
        } catch (\Exception $e) {
            //Should wrap a transaction here
            return 'Somebody please wrap this thing into a transaction asap';
        }
    }

    function edit(Project $project)
    {
        $this->authorize('edit', $project);
        $games = Game::all()->pluck('name', 'id');

        return view('project.edit', compact('project', 'games'));
    }

    function update(Project $project, Request $request)
    {
        $this->authorize('edit', $project);

        $project->update($request->only(['name', 'description', 'status', 'visible']));
        if ($request->has('visible')) {
            //we should fail if this is not given. Whatever...
            $this->projectRepository->updateVisibility($project, $request->get('visible'));
        }

        $project->save();

        return redirect($this->projectUtil->url($project));
    }

    public function delete(Request $request, Project $project)
    {
        $this->authorize('remove', $project);

        $project->media()->get()->each(function ($media) {
            MediaUtil::deleteMedia($media);
        });

        $project->members()->detach();
        $project->releases()->delete();
        $project->repositories()->delete();
        //delete some more here
        $project->delete();

        return redirect()->action('HomeController@index');
    }

    public function toggleFollow(Request $request, Project $project)
    {
        $this->projectUtil->toggleFollow($project, $request->user());
    }
}