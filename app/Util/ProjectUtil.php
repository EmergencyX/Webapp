<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\Project;

class ProjectUtil
{
    /**
     * Get the project slug
     *
     * @param \EmergencyExplorer\Project $project
     *
     * @return string
     */
    public static function getProjectSlug(Project $project)
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
     * @param \EmergencyExplorer\Project $project
     *
     * @return string
     */
    public static function getProjectAction(Project $project)
    {
        return action('ProjectController@show', ['id' => $project->id, 'seo' => self::getProjectSlug($project)]);
    }
}