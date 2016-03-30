<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\Project;

class ProjectUtil
{
    public static function getProjectSlug(Project $project)
    {
        $slug = str_slug($project->name);

        if ($slug === "") {
            $slug = strtolower(urlencode($project->name));
        }

        return $slug;
    }

    public static function getProjectAction(Project $project)
    {
        return action('ProjectController@show', ['id' => $project->id, 'seo' => self::getProjectSlug($project)]);
    }
}