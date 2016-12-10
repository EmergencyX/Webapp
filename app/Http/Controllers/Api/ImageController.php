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
        return \Response::json(['success' => true]);
    }

    public function store(Project $project, Request $request)
    {
        $this->authorize(Image::class);

        $image       = $this->imageUtil->fromFile($request->file('image'), []);
        $image->type = Image::TYPE_IMAGE;

        $project->images()->save($image);

        return \Response::make([
            'success' => true,
            'data'    => array_merge(json_decode($image->provider, true), ['id' => $image->id]),
        ]);
    }

    public function index(Project $project)
    {
        $project->load('images');

        return \Response::json([
            'success' => true,
            'data'    => $project->images->map(function ($image) {
                return array_merge(json_decode($image->provider, true), ['id' => $image->id]);
            }),
        ]);
    }

    public function remove(Project $project, Image $image)
    {
        //Check if user may edit project
        if ($image->owner->getKey() !== $project->getKey()) {
            abort(403, 'Image does not belong to given project');
        }

        //$user = $this->getCaller();
        //abort_unless($user->can('edit', $project), 401);
        //abort_unless($user->tokenCan('edit-project'), 401);

        $this->imageUtil->removeImage($image);

        return \Response::json(['success' => $image->delete()]);
    }
}
