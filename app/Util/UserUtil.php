<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\User;

class UserUtil
{
    /**
     * @param User $user
     *
     * @return string
     */
    public static function getUserSlug(User $user)
    {
        $slug = str_slug($user->name);

        if ($slug === "") {
            $slug = strtolower(urlencode($user->name));
        }

        return $slug;
    }

    /**
     * Get a URL with inserted SEO for a user
     *
     * @param User $user
     *
     * @return string
     */
    public static function getUserAction(User $user)
    {
        return action('UserController@show', ['id' => $user->id, 'seo' => self::getUserSlug($user)]);
    }
}