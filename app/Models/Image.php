<?php

namespace EmergencyExplorer\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    const LOCAL = 'local';


    const TYPE_AVATAR = 1;
    const TYPE_IMAGE  = 2;

    const SIZE_XS = 'xs';
    const SIZE_SM = 'sm';
    const SIZE_MD = 'md';
    const SIZE_LG = 'lg';
    const SIZE_OG = 'og';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }
}
