<?php

namespace EmergencyExplorer\Util\Media;

use EmergencyExplorer\Media as MediaModel;
use EmergencyExplorer\User as UserModel;
use Illuminate\Http\UploadedFile;

class LocalImage implements Image
{
    protected $imageSizes = ['xs', 'sm', 'md', 'lg'];

    const IDENTIFIER = 'local';


    /**
     * LocalImage constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get a unique identifier for this provider
     *
     * @return string
     */
    public function getIdentifier()
    {
        return self::IDENTIFIER;
    }

    /**
     * @param MediaModel $media
     * @param string $size
     *
     * Get a link for a given size from the given media model
     *
     * @return string
     */
    public function getImageLink(MediaModel $media, string $size = 'xs')
    {
        $imageData = json_decode($media->extra, true);

        return asset('storage/' . $imageData[$size]['token'] . '-' . $size . '.jpg');
    }

    /**
     * @param string $size
     *
     * Check if this provider can offer the requested image size
     *
     * @return bool
     */
    public function providesImageSize(string $size)
    {
        return in_array($size, $this->imageSizes);
    }

    /**
     * Tell if this provider should be called asynchronous
     *
     * @return bool
     */
    public function shouldQueue()
    {
        return false;
    }


    /**
     * @param MediaModel $media
     * @param string $size
     *
     * Delete if possible
     *
     * @return bool
     */
    public function deleteImage(MediaModel $media, string $size = 'xs')
    {

    }

    /**
     * @param string $filename
     * @param array $sizes
     *
     * Takes an image file and returns the resulting link
     *
     * @return array
     */
    public function processImage(string $filename, array $sizes = ['xs'])
    {
        //Heads up! destroy() does not delete the image, as the previous save() might suggest.
        //Instead the used image instance is destroyed and therefore memory freed.
        $created = [];
        $token = sha1(time() . json_encode($sizes) . e($filename) . str_random(8));

        foreach ($sizes as $size) {
            $this->openAndFit($filename, $size)->save($this->getPath($token, $size))->destroy();

            //It would be possible to return null here and skip this step. I.e. if the given image was to small for lg.
            $created[$size] = ['provider' => $this->getIdentifier(), 'token' => $token];
        }

        logger()->info('Generated thumbnails for media', $created);

        return $created;
    }

    /**
     * @param $filename
     * @param $size
     *
     * @return mixed <- what is this class :(
     */
    protected function openAndFit($filename, $size)
    {
        if (! $this->providesImageSize($size)) {
            throw new \InvalidArgumentException("Invalid size: $size");
        }

        $image = \Image::make($filename);

        switch ($size) {
            case 'xs':
                $image->fit(128, 128);
                break;
            case 'sm':
                $image->fit(320, 180);
                break;
            case 'md':
                $image->fit(640, 360);
                break;
            case 'lg':
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
     * Get a storage path for a given token and size.
     * Pro tip: Do not use this for 'original' size.
     *
     * @param string $token
     * @param string $size
     *
     * @return string
     */
    protected function getPath(string $token, string $size)
    {
        if (! $this->providesImageSize($size)) {
            throw new \InvalidArgumentException("Invalid size: $size");
        }

        return public_path('storage/' . $token . '-' . $size . '.jpg');
    }
}