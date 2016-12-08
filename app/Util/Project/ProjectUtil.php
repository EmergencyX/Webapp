<?php

namespace EmergencyExplorer\Util\Project;

use EmergencyExplorer\Models\Project;

class ProjectUtil
{
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
}