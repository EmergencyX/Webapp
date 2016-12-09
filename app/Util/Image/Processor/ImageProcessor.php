<?php

namespace EmergencyExplorer\Util\Image\Processor;

use EmergencyExplorer\Models\Image as ImageModel;

interface ImageProcessor
{
    /**
     * @param ImageModel $image
     * @param string $size
     *
     * Get a link for a given size from the given media model
     *
     * @return string
     */
    public function getImageLink(ImageModel $image, string $size);

    /**
     * @param ImageModel $image
     * @param string $size
     *
     * Delete if possible
     *
     * @return bool
     */
    public function deleteImage(ImageModel $image, string $size);

    /**
     * @param ImageModel $image
     * @param string $size
     *
     * Create image in the given size
     *
     * @return mixed
     */
    public function generateImage(ImageModel $image, string $size);
}