<?php

namespace EmergencyExplorer\Media;

use EmergencyExplorer\Media as MediaModel;
use EmergencyExplorer\User as UserModel;

interface Image
{
    /**
     * @param string $filename
     * @param array $sizes
     *
     * Takes an image file and returns the resulting link
     *
     * @return array
     */
    public function processImage(string $filename, array $sizes = ['xs']);

    /**
     * Tell if this provider should be called asynchronous
     *
     * @return bool
     */
    public function shouldQueue();

    /**
     * Get a unique identifier for this provider
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * @param MediaModel $media
     * @param string $size
     *
     * Get a link for a given size from the given media model
     *
     * @return string
     */
    public function getImageLink(MediaModel $media, string $size = 'xs');

    /**
     * @param string $size
     * 
     * Check if this provider can offer the requested image size
     *
     * @return bool
     */
    public function providesImageSize(string $size);

    /**
     * @param MediaModel $media
     * @param string $size
     *
     * Delete if possible
     *
     * @return bool
     */
    public function deleteImage(MediaModel $media, string $size = 'xs');
}