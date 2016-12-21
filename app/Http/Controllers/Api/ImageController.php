<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Models\User;
use EmergencyExplorer\Util\Image\ImageUtil;
use Illuminate\Http\Request;

class ImageController extends ApiController
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

    public function show(Project $project, Image $image)
    {
        return response()->json($image);
    }

    public function store(Project $project, Request $request)
    {
        $this->authorize(Image::class);

        $image       = $this->imageUtil->fromFile($request->file('image'), []);
        $image->type = Image::TYPE_IMAGE;

        $project->images()->save($image);

        return response()->json(array_merge($image->provider, ['id' => $image->id]));
    }

    public function index(Project $project)
    {
        $project->load('images');

        return \Response::json($project->images->map(function ($image) {
            return array_merge($image->provider, ['id' => $image->id]);
        }));
    }

    public function remove(Project $project, Image $image)
    {
        //Check if user may edit project
        $user = $this->getCaller();
        abort_unless($user->can('edit', $project) || $user->tokenCan('edit-project'), 401);
        if ($image->owner->getKey() !== $project->getKey()) {
            abort(403, 'Image does not belong to given project');
        }

        $this->imageUtil->removeImage($image);

        return response()->make();
    }
}
