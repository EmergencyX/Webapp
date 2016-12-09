<?php

namespace EmergencyExplorer\Http\Controllers\Project;

use EmergencyExplorer\Http\Controllers\Controller;
use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use EmergencyExplorer\Repositories\Project as ProjectRepository;

use EmergencyExplorer\Util\Project\ProjectUtil;
use Illuminate\Auth\Access\Gate;
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
    private $projectUtil;

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
        $games = Game::all()->pluck('name', 'id');

        return view('project.create', compact('games'));
    }

    function store(Request $request)
    {
        try {
            $project = $this->projectRepository->createProject($request->only([
                'name',
                'description',
                'status',
                'game_id',
                'visible',
            ]));
            $project->users()->save($request->user(), ['role' => Project::PROJECT_ROLE_ADMIN]);

            /** @var \EmergencyExplorer\Util\Activity\Project $projectActivityManager */
            $projectActivityManager = app(\EmergencyExplorer\Util\Activity\Project::class);
            $projectActivityManager->projectCreatedActivity($request->user(), $project);

            return redirect(ProjectUtil::getProjectAction($project));
        } catch (\Exception $e) {
            //Should wrap a transaction here
            return 'Somebody please wrap this thing into a transaction asap';
        }
    }

    function edit($id)
    {
        $project = Project::findOrFail($id);
        $games   = Game::all()->pluck('name', 'id');

        return view('project.edit', compact('project', 'games'));
    }

    function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->only(['name', 'description', 'status', 'visible']));
        if ($request->has('visible')) {
            //we should fail if this is not given. Whatever...
            $this->projectRepository->updateVisibility($project, $request->get('visible'));
        }

        $project->save();

        return redirect(ProjectUtil::getProjectAction($project));
    }

    function createMedia($id)
    {
        //Todo: Check permission
        $project = Project::findOrFail($id);

        return view('project.create_media', compact('project'));
    }

    public
    function delete(
        Request $request,
        $id
    ) {
        $project = Project::findOrFail($id);
        abort_if($request->user()->cannot('remove', $project), 403);

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

    public
    function toggleFollow(
        Request $request,
        Project $project
    ) {
        if (! $project->relationLoaded('user')) {
            $project->load('users');
        }

        if ($user = $project->users->where('id', $request->user()->id)->first()) {
            if ($user->pivot->role != Project::PROJECT_ROLE_WATCHER) {
                throw new \Exception('User is a member, not only a watcher. Leave the project instead.');
            }
            $project->users()->detach($user);
            notification('stopped_following_project', ['meta' => ['project' => $project->id]]);

            return back();
        } else {
            if (! $project->visible) {
                throw new \Exception('This is a hidden project. You are either in or out.');
            }

            $project->users()->save($request->user(), ['role' => Project::PROJECT_ROLE_WATCHER]);
            notification('following_project', ['meta' => ['project' => $project->id]]);

            return back();
        }
    }
}