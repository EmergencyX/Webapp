<?php

namespace EmergencyExplorer\Util\Project;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Util\Image\ImageUtil;

class ProjectUtil
{
    /**
     * @var ImageUtil
     */
    protected $imageUtil;

    /**
     * ProjectUtil constructor.
     *
     * @param ImageUtil $imageUtil
     */
    public function __construct(ImageUtil $imageUtil)
    {
        $this->imageUtil = $imageUtil;
    }

    /**
     * Get the project slug
     *
     *
     * @param Project $project
     *
     * @return string
     */
    public function slug(Project $project)
    {
        $slug = str_slug($project->name);

        if ($slug === "") {
            $slug = strtolower(urlencode($project->name));
        }

        return $slug;
    }

    /**
     * Get a URL with inserted SEO for a project
     *
     * @param Project $project
     *
     * @return string
     */
    public function url(Project $project)
    {
        return action('Project\ProjectController@show', [$project, 'seo' => $this->slug($project)]);
    }

    public function cover(Project $project)
    {
        $image = $project->images()->where('type', Image::TYPE_IMAGE)->first();

        return $this->imageUtil->url($image, Image::SIZE_MD);
    }
}