<?php

namespace EmergencyExplorer\Util\Activity;

use EmergencyExplorer\Project as ProjectModel;

class Project
{
    const PROJECT_FEED = 'project';
    /**
     * @var StreamActivityManager
     */
    protected $activityManager;

    /**
     * Project constructor.
     *
     * @param StreamActivityManager $activityManager
     */
    public function __construct(StreamActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
    }

    public function createActivity()
    {

    }

    public function getActivities(ProjectModel $project)
    {
        $projectFeed = $this->activityManager->getFeed(self::PROJECT_FEED, $project->id);
        $projectFeed->addActivity(['verb' => 'created', 'actor' => 'noblubb', 'object' => $project->id]);

        $activities = $projectFeed->getActivities();
        var_dump($activities);

        return $activities;
    }

    public function removeActivity()
    {

    }
}