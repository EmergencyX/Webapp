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
        return asset($this->filename($image, $size));
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
        $provider = json_decode($image->provider);

        return $provider->t . '_' . $size . '.' . $extension;
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
        $filename = $this->filename($image, $size);
        dd($filename);
        unlink($filename);
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
    public function generateImage(ImageModel $image, string $size)
    {
        $filename = public_path($this->filename($image, ImageModel::SIZE_OG, json_decode($image->provider)->f));

        $this->resizeInstance($filename, $size)
            ->save(public_path($this->filename($image, $size)))
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
    public function putOriginalImage(ImageModel $image, UploadedFile $file)
    {
        $provider        = json_decode($image->provider);
        $provider->f     = $file->extension();
        $image->provider = json_encode($provider);


        $path = $this->relativePath($image, ImageModel::SIZE_OG);
        $name = $this->filename($image, ImageModel::SIZE_OG, $file->extension());


        $file->move($path, $name);

        $file->storeAs(public_path('storage/'), $this->filename($image, ImageModel::SIZE_OG, $file->extension()));

        $this->generateImage($image, ImageModel::SIZE_XS);
        $this->generateImage($image, ImageModel::SIZE_SM);
        $this->generateImage($image, ImageModel::SIZE_MD);
        $this->generateImage($image, ImageModel::SIZE_LG);
    }
}