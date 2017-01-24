<?php

namespace EmergencyExplorer\Util;

class TokenUtil
{
    public static function getTokens()
    {
        return [
            //Image
            'access-images'   => trans('token.access-images'),

            //Project
            'access-projects' => trans('token.access-projects'),

            //Release
            'access-release'  => trans('token.access-release'),
        ];
    }
}