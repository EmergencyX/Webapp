<?php

namespace EmergencyExplorer\Util\View;

use EmergencyExplorer\Models\Media as MediaModel;

class MediaUtil
{
    /**
     * Returns a thumbnail for the given $media in the given $size or a placeholder if not present
     *
     * @param MediaModel $media
     * @param string $size
     *
     * @return string
     */
    public static function getThumbnail(MediaModel $media = null, $size = 'xs')
    {
        /** @var \EmergencyExplorer\Util\MediaUtil $mediaUtil */
        $mediaUtil = app(\EmergencyExplorer\Util\MediaUtil::class);

        return $mediaUtil->getThumbnail($media, $size);
    }
}