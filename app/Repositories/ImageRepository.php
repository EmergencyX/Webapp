<?php

namespace EmergencyExplorer\Repositories;

use EmergencyExplorer\Models\Project;

class ImageRepository
{
    /**
     * @param Project $project
     *
     * @return \Illuminate\Support\Collection
     */
    public function forProject(Project $project)
    {
        //Todo(rs) Fetch images here
        //Permission check?
        return $project->images();
    }
}