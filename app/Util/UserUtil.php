<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\User;
use EmergencyExplorer\Util\Image\ImageUtil;

class UserUtil
{
    /**
     * @var ImageUtil
     */
    protected $imageUtil;

    /**
     * UserUtil constructor.
     * @param ImageUtil $imageUtil
     */
    public function __construct(ImageUtil $imageUtil)
    {
        $this->imageUtil = $imageUtil;
    }

    /**
     * @param User $user
     *
     * @return string
     */
    public function slug(User $user)
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
    public function url(User $user)
    {
        return action('User\UserController@show', [$user, 'seo' => $this->slug($user)]);
    }
    
    public function avatar(User $user, string $size = Image::SIZE_SM)
    {
        return $this->imageUtil->url($user->avatar(), $size);
    }
}