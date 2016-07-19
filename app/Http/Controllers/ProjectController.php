<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;
use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use EmergencyExplorer\Repositories\Project as ProjectRepository;
use EmergencyExplorer\Repositories\Media as MediaRepository;
use EmergencyExplorer\Repositories\Activity as ActivityRepository;
use EmergencyExplorer\Util\ProjectActivityUtil;
use EmergencyExplorer\Util\ProjectRepositoryUtil;
use EmergencyExplorer\Util\ProjectUtil;
use Illuminate\Auth\Access\Gate;

use EmergencyExplorer\Game;
use EmergencyExplorer\Project;

use EmergencyExplorer\Util\MediaUtil;

class ProjectController extends Controller
{
    /**
     * @var ProjectActivityUtil
     */
    protected $projectActivityUtil;

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * @var MediaRepository
     */
    protected $mediaRepository;

    /**
     * @var ActivityRepository
     */
    protected $activityRepository;

    /**
     * ProjectController constructor.
     *
     * @param NavigationHelper $navigationHelper
     * @param ProjectActivityUtil $projectActivityUtil
     * @param ProjectRepository $projectRepository
     * @param MediaRepository $mediaRepository
     * @param ActivityRepository $activityRepository
     */
    public function __construct(
        NavigationHelper $navigationHelper,
        ProjectActivityUtil $projectActivityUtil,
        ProjectRepository $projectRepository,
        MediaRepository $mediaRepository,
        ActivityRepository $activityRepository
    ) {
        $navigationHelper->setSection(NavigationHelper::PROJECTS);
        $this->projectActivityUtil = $projectActivityUtil;
        $this->projectRepository = $projectRepository;
        $this->mediaRepository = $mediaRepository;
        $this->activityRepository = $activityRepository;
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

    function show($id, $seo = null)
    {
        $project = Project::findOrFail($id);
        $slug = ProjectUtil::getProjectSlug($project);

        if (urldecode($seo) != urldecode($slug)) {
            return redirect(ProjectUtil::getProjectAction($project));
        }

        $project->load('members', 'releases', 'game', 'media', 'repositories', 'supportLinks');

        $activities = $this->activityRepository->getRecentActivities($project, 5);

        return view('project.show', compact('project', 'activities'));
    }

    function create()
    {
        $games = Game::all()->pluck('name', 'id');

        return view('project.create', compact('games'));
    }

    function store(Request $request)
    {
        $project = $this->projectRepository->createProject($request->only([
            'name',
            'description',
            'status',
            'game_id',
            'visible',
        ]));
        $project->users()->save($request->user(), ['role' => Project::PROJECT_ROLE_ADMIN]);

        return redirect(ProjectUtil::getProjectAction($project));
    }

    function edit($id)
    {
        $project = Project::findOrFail($id);
        $games = Game::all()->pluck('name', 'id');

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

    function storeMedia(Request $request, $id)
    {
        //Todo: Check permission
        $user = $request->user();
        $project = Project::findOrFail($id);
        $file = $request->file('media');
        if ($request->hasFile('media') && $file->isValid()) {
            //$media = MediaUtil::createMedia(, $file);
            $imageData = array_merge(
                $request->only('name', 'description', 'provider'),
                ['sizes' => ['xs', 'sm', 'md', 'lg']]
            );
            $this->mediaRepository->createImage($file, $imageData, $user, $project);
        }

        return redirect(ProjectUtil::getProjectAction($project));
    }

    public function delete(Request $request, $id)
    {
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

    public function toggleFollow(Request $request, Project $project)
    {
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