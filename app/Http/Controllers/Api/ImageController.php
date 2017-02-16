<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Util\Image\ImageUtil;
use Illuminate\Http\JsonResponse;
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

    /**
     * @param Project $project
     * @param Image $image
     *
     * @return JsonResponse
     */
    public function show(Project $project, Image $image)
    {
        //abort_unless($this->getCaller()->tokenCan('access-images'), 401);
        //$this->authorizeForUser($this->getCaller(), 'show', $image);

        return \Response::json($image);
    }

    /**
     * @param Project $project
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Project $project, Request $request)
    {
        //abort_unless($this->getCaller()->tokenCan('access-images'), 401);
        //$this->authorizeForUser($this->getCaller(), Image::class);

        $image       = $this->imageUtil->fromFile($request->file('image'), []);
        $image->type = Image::TYPE_IMAGE;

        $project->images()->save($image);

        return \Response::json($image->provider + ['id' => $image->id]);
    }

    /**
     * @param Project $project
     *
     * @return JsonResponse
     */
    public function index(Project $project)
    {
        //abort_unless($this->getCaller()->tokenCan('access-images'), 401);
        //$this->authorizeForUser($this->getCaller(), 'show', $project);

        $project->load('images');

        return \Response::json($project->images->map(function ($image) {
            return $image->provider + ['id' => $image->id];
        }));
    }

    /**
     * @param Project $project
     * @param Image $image
     *
     * @return JsonResponse
     */
    public function remove(Project $project, Image $image)
    {
        //abort_unless($this->getCaller()->tokenCan('access-images'), 401);
        //$this->authorizeForUser($this->getCaller(), $image);

        if ($image->owner->getKey() !== $project->getKey()) {
            abort(403, 'Image does not belong to given project');
        }

        $this->imageUtil->removeImage($image);

        return \Response::json(['success' => true]);
    }
}
