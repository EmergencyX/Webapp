<?php

namespace EmergencyExplorer\Util\Activity;

use EmergencyExplorer\Media as MediaModel;
use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\User as UserModel;
use EmergencyExplorer\User;

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

    public function createActivity(ProjectModel $project, array $data)
    {
        $projectFeed = $this->activityManager->getFeed(self::PROJECT_FEED, $project->getKey());

        return $projectFeed->addActivity($data);
    }

    /**
     * @param User $user
     * @param ProjectModel $project
     *
     * @return mixed
     */
    public function projectCreatedActivity(UserModel $user, ProjectModel $project)
    {
        return $this->createActivity($project,
            [
                'verb'   => 'project_created',
                'actor'  => $user->getKey(),
                'object' => $project->getKey(),
            ]
        );
    }

    /**
     * @param UserModel $user
     * @param ProjectModel $project
     * @param MediaModel $media
     *
     * @return mixed
     */
    public function mediaUploadedActivity(UserModel $user, ProjectModel $project, MediaModel $media)
    {
        return $this->createActivity($project,
            [
                'verb'   => 'media_uploaded',
                'actor'  => $user->getKey(),
                'object' => $media->getKey(),
            ]
        );
    }

    /**
     * @param ProjectModel $project
     *
     * @return mixed
     */
    public function getActivities(ProjectModel $project)
    {
        return $this->activityManager->cached(
            $this->identifier($project),
            function () use ($project) {
                $projectFeed = $this->activityManager->getFeed(self::PROJECT_FEED, $project->getKey());

                return $projectFeed->getActivities()['results'];
            }
        );
    }

    /**
     * @param ProjectModel $project
     * @param string $guid
     */
    public function removeActivity(ProjectModel $project, string $guid)
    {
        $this->activityManager->flushCache($this->identifier($project));
    }

    /**
     * @param ProjectModel $project
     *
     * @return string
     */
    protected function identifier(ProjectModel $project)
    {
        return self::PROJECT_FEED . $project->getKey();
    }
}