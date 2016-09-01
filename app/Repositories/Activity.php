<?php

namespace EmergencyExplorer\Repositories;

use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\Util\Activity\EmergencyForumActivityAggregator;

class Activity
{
    /**
     * @param string $description
     * @param string|null $name
     * @param string|null $url
     */
    public function createActivity(string $description, string $name = null, string $url = null)
    {
        
    }

    /**
     * Get available aggregators
     *
     * @return array
     */
    public function getActivityAggregators()
    {
        return [
            new EmergencyForumActivityAggregator,
        ];
    }

    public function getRecentActivities(ProjectModel $project, int $limit = 4)
    {
        $fuu = app(\EmergencyExplorer\Util\Activity\Project::class);
        return $fuu->getActivities($project);
    }
}