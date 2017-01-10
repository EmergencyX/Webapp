<?php

namespace EmergencyExplorer\Util\Image;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Util\Image\Processor\LocalImageProcessor;
use Illuminate\Http\UploadedFile;

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


    public function url(Image $image = null, string $size = Image::SIZE_XS)
    {
        if (! $image) {
            return asset("storage/default/emergency-5_$size.jpg");
        }

        return $this->providers[$image->provider['p']]->getImageLink($image, $size);
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
        $image->provider = ['t' => md5(random_bytes(12) . (string)time())];

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
    ): Image {
        $image = $this->newImage($imageInfo);
        $this->providers[$processor]->putOriginalImage($image, $file);

        return $image;
    }

    public function removeImage(Image $image)
    {
        $processor = $image->provider['p'];
        $this->providers[$processor]->deleteImage($image, Image::SIZE_OG);
        $this->providers[$processor]->deleteImage($image, Image::SIZE_LG);
        $this->providers[$processor]->deleteImage($image, Image::SIZE_MD);
        $this->providers[$processor]->deleteImage($image, Image::SIZE_SM);
        $this->providers[$processor]->deleteImage($image, Image::SIZE_XS);

        if (! $image->delete()) {
            throw new \Exception('Could not delete image');
        }
    }
}