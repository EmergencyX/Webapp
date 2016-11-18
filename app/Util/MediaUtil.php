<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\Models\Media as MediaModel;

class MediaUtil
{
    /**
     * @param MediaModel $media
     * @param string $size
     *
     * @return string
     */
    public function getThumbnail(MediaModel $media, string $size = 'xs')
    {
        return 'url';
    }
}