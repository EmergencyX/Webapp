<?php

namespace EmergencyExplorer\Util\Image;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Util\Image\Processor\LocalImageProcessor;
use Illuminate\Http\UploadedFile;
use League\Flysystem\Adapter\Local;

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
            LocalImageProcessor::IDENTIFIER => new LocalImageProcessor,
        ];
    }


    public function url(Image $image, string $size = Image::SIZE_XS)
    {
        if (! $image) {
            return "https://placekitten.com/g/640/360";
        }

        $provider = json_decode($image->provider)->p;

        return $this->providers[$provider]->getImageLink($image, $size);
    }

    public function forProject(Project $project)
    {
        //Todo(rs) Fetch images here
        //Permission check?
        return $project->images();
    }


    public function newImage(array $imageInfo)
    {
        $image           = new Image($imageInfo);
        $image->provider = json_encode(['t' => md5(random_bytes(12))]);

        return $image;
    }

    /**
     * @param $file
     * @param string $processor
     *
     * @return Image
     */
    public function fromFile(
        UploadedFile $file,
        array $imageInfo,
        string $processor = LocalImageProcessor::IDENTIFIER
    ) : Image
    {
        $image = $this->newImage($imageInfo);
        $this->providers[$processor]->putOriginalImage($image, $file);

        return $image;
    }
}