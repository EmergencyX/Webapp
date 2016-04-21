<?php

if (! function_exists('notification')) {
    /**
     * @param array $notification
     */
    function notification(string $token, array $notification)
    {
        $notification['token'] = $token;
        logger('Got notification', $notification);
    }
}