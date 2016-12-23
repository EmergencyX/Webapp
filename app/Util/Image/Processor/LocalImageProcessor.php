<?php

namespace EmergencyExplorer\Util\Image\Processor;

use EmergencyExplorer\Models\Image as ImageModel;
use Illuminate\Http\UploadedFile;

class LocalImageProcessor implements ImageProcessor
{
    const IDENTIFIER = 'loc';

    protected $storagePath;

    /**
     * LocalImageProcessor constructor.
     */
    public function __construct()
    {
        $this->storagePath = public_path('/storage');
    }


    /**
     * @param ImageModel $image
     * @param string $size
     *
     * Get a link for a given size from the given media model
     *
     * @return string
     */
    public function getImageLink(ImageModel $image, string $size = ImageModel::SIZE_MD)
    {
        return asset($this->relativePath($image, $size));
    }

    /**
     * @param ImageModel $image
     * @param string $size
     *
     * @param string $extension
     *
     * @return string
     */
    public function filename(ImageModel $image, string $size, string $extension = 'jpg')
    {
        return $image->provider['t'] . '_' . $size . '.' . $extension;
    }

    /**
     * @param ImageModel $image
     * @param string $size
     *
     * Delete if possible
     *
     * @return bool
     */
    public function deleteImage(ImageModel $image, string $size)
    {
        $filename = public_path(
            $size === ImageModel::SIZE_OG ?
                $this->relativePath($image, $size, $image->provider['f']) :
                $this->relativePath($image, $size)
        );

        return unlink($filename);
    }

    public function relativePath(ImageModel $image, string $size, string $extension = 'jpg', bool $withName = true)
    {
        $filename = $this->filename($image, $size, $extension);
        $bucket   = substr($filename, 0, 2);

        return $withName ? 'storage/' . $bucket . '/' . $filename : 'storage/' . $bucket;
    }

    /**
     * @param ImageModel $image
     * @param string $size
     *
     * @return ImageModel
     */
    public function generateImage(ImageModel &$image, string $size)
    {
        $filename = public_path($this->relativePath($image, ImageModel::SIZE_OG, $image->provider['f']));

        $this->resizeInstance($filename, $size)
            ->save(public_path($this->relativePath($image, $size)))
            ->destroy(); //destroys (memory) instance, not image

        return $image;
    }

    /**
     * @param $filename
     * @param $size
     *
     * @return mixed <- what is this class :(
     */
    protected function resizeInstance($filename, $size)
    {
        $image = \Image::make($filename);

        switch ($size) {
            case ImageModel::SIZE_XS:
                $image->fit(128, 128);
                break;
            case ImageModel::SIZE_SM:
                $image->fit(320, 180);
                break;
            case ImageModel::SIZE_MD:
                $image->fit(640, 360);
                break;
            case ImageModel::SIZE_LG:
                if ($image->height() > $image->width()) {
                    $image->fit(1080, 1920, function ($constraint) {
                        $constraint->upsize();
                    });
                } else {
                    $image->fit(1920, 1080, function ($constraint) {
                        $constraint->upsize();
                    });
                }
                break;
        }

        return $image;
    }

    /**
     * @param ImageModel $image
     * @param UploadedFile $file
     *
     * Store initial upload
     *
     * @return void
     */
    public function putOriginalImage(ImageModel &$image, UploadedFile $file)
    {
        $image->provider = array_merge($image->provider, ['f' => $file->extension(), 'p' => self::IDENTIFIER]);

        $path = public_path($this->relativePath($image, ImageModel::SIZE_OG, '', false));
        $name = $this->filename($image, ImageModel::SIZE_OG, $file->extension());

        $file->move($path, $name);

        //Todo: clean this up
        $this->generateImage($image, ImageModel::SIZE_XS);
        $this->generateImage($image, ImageModel::SIZE_SM);
        $this->generateImage($image, ImageModel::SIZE_MD);
        $this->generateImage($image, ImageModel::SIZE_LG);
    }
}