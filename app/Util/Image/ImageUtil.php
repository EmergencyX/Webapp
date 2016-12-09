<?php

namespace EmergencyExplorer\Util\Image;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Util\Image\Processor\LocalImageProcessor;

class ImageUtil
{
    protected $providers = [];

    /**
     * ImageUtil constructor.
     *
     */
    public function __construct()
    {
        $this->providers = [
            'loc' => new LocalImageProcessor,
        ];
    }


    public function url(Image $image, string $size = Image::SIZE_XS)
    {
        $provider = json_decode($image->provider)->p;

        return $this->providers[$provider]->getImageLink($image, $size);
    }

    public function forProject(Project $project)
    {
        //Todo(rs) Fetch images here
        //Permission check?
        return $project->images();
    }
}