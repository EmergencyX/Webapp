<?php
/**
 * Created by PhpStorm.
 * User: rstahl
 * Date: 18.11.16
 * Time: 19:51
 */

namespace EmergencyExplorer\Http\View\Helper;


use EmergencyExplorer\Models\Project;

class ProjectHelper
{
    public function url(Project $project)
    {
        return action('ProjectController@show', ['id' => $project->getKey(), 'seo' => $this->slug($project)]);
    }

    public function slug(Project $project)
    {
        $slug = str_slug($project->name);

        if ($slug === "") {
            $slug = strtolower(urlencode($project->name));
        }

        return $slug;
    }
}