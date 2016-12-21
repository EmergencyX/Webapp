<?php

namespace EmergencyExplorer\Http\Controllers\Project;

use EmergencyExplorer\Http\Controllers\Controller;
use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Util\Image\ImageUtil;
use EmergencyExplorer\Util\Project\ProjectUtil;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * @var ImageUtil
     */
    protected $imageUtil;

    /**
     * @var ProjectUtil
     */
    protected $projectUtil;

    /**
     * ImageController constructor.
     *
     * @param ImageUtil $imageUtil
     * @param ProjectUtil $projectUtil
     */
    public function __construct(ImageUtil $imageUtil, ProjectUtil $projectUtil)
    {
        $this->imageUtil   = $imageUtil;
        $this->projectUtil = $projectUtil;
    }

    public function remove(Project $project, Image $image, Request $request)
    {
        abort_unless($request->user()->can('edit', $project), 401);
        if ($image->owner->getKey() !== $project->getKey()) {
            abort(403, 'Image does not belong to given project');
        }

        $this->imageUtil->removeImage($image);

        return redirect($this->projectUtil->url($project));
    }

    public function create(Project $project)
    {
        return view('project.create_image', compact('project'));
    }

    public function store(Project $project, Request $request)
    {
        $image       = $this->imageUtil->fromFile($request->file('image'), []);
        $image->type = Image::TYPE_IMAGE;

        $project->images()->save($image);

        return redirect($this->projectUtil->url($project));
    }
}
