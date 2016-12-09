<?php

namespace EmergencyExplorer\Util\Media;

use EmergencyExplorer\Media as MediaModel;
use EmergencyExplorer\User as UserModel;
use EmergencyExplorer\Util\EmergencyUploadApi;
use Illuminate\Http\UploadedFile;

class EmergencyUploadImage implements Image
{

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
        // TODO: Implement processImage() method.
    }

    /**
     * Tell if this provider should be called asynchronous
     *
     * @return bool
     */
    public function shouldQueue()
    {
        return true;
    }

    /**
     * Get a unique identifier for this provider
     *
     * @return string
     */
    public function getIdentifier()
    {
        // TODO: Implement getIdentifier() method.
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
        // TODO: Implement getImageLink() method.
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
        // TODO: Implement providesImageSize() method.
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
        // TODO: Implement deleteImage() method.
    }
}