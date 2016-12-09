<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Models\User;
use EmergencyExplorer\Util\Image\ImageUtil;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Controllers\Controller;

class ImageController extends Controller
{
    /**
     * @var ImageUtil
     */
    protected $imageUtil;

    /**
     * ImageController constructor.
     *
     * @param ImageUtil $imageUtil
     */
    public function __construct(ImageUtil $imageUtil)
    {
        $this->imageUtil = $imageUtil;
    }

    public function recent(Request $request)
    {
        //$projects = $this->projectRepository->recentProjects($request->user());
        $projects = collect();

        return \Response::json($projects);
    }

    public function show(Project $project)
    {
        /* $user = request()->user('api');
         abort_unless($user instanceof User, 401);
         abort_unless($user->can('show', $project), 401);
         abort_unless($user->tokenCan('show-project'), 401);

         return \Response::json($project);
        */
    }

    public function store(Project $project, Request $request)
    {
        $this->authorize(Image::class);

        $image       = $this->imageUtil->fromFile($request->file('image'), []);
        $image->type = Image::TYPE_IMAGE;

        $project->images()->save($image);

        return \Response::make($image->provider, 200,
            ['Content-Type' => 'application/json']);
    }

    public function index(Project $project)
    {
        $project->load('images');

        return \Response::make('[' . $project->images->pluck('provider')->implode(',') . ']', 200,
            ['Content-Type' => 'application/json']);
    }
}
