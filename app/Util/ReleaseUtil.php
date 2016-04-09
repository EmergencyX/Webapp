<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\Release;

use Gate;

class ReleaseUtil {
    public static function getDownloadLink(Release $release) {
        /*if (Gate::denies('download', $release)) {
            abort(403);
        }*/
        /*
        $extra = json_decode($release->extra);
        if (isset($extra->url)) {
            return $extra->url;
        }
        */
        return '';
    }
}