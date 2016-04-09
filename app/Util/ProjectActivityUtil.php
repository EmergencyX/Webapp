<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\Media;
use EmergencyExplorer\Project;
use EmergencyExplorer\User;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection as Collection;

class ProjectActivityUtil
{
    const TOPIC_CACHE_TTL = 10;

    const TOPIC_RELEASE = 1;
    const TOPIC_MEDIA   = 'media';

    /**
     * @var CacheRepository
     */
    protected $cacheRepository;

    /**
     * ProjectActivityUtil constructor.
     *
     * @param CacheRepository $cacheRepository
     */
    public function __construct(CacheRepository $cacheRepository)
    {
        $this->cacheRepository = $cacheRepository;
    }


    /**
     * @param \EmergencyExplorer\Project $project
     * @param int $count
     * @param array $topics
     *
     * @return Collection
     */
    public function getRecentActivities(Project $project, int $count = 5, array $topics = [self::TOPIC_MEDIA])
    {
        $activities = $this->cacheRepository->remember($this->getCacheKey($project), self::TOPIC_CACHE_TTL,
            function () use ($project) {
                return $this->getActivityRecords($project);
            });

        return $activities->whereIn('topic', $topics)->take($count);
    }

    /**
     * @param \EmergencyExplorer\Project $project
     */
    public function clearRecentActivities(Project $project)
    {
        $this->cacheRepository->forget($this->getCacheKey($project));
    }

    /**
     * @param Project $project
     *
     * @return Collection
     */
    protected function getActivityRecords(Project $project)
    {
        /** @var \Illuminate\Database\Eloquent\Collection $result */
        $mediaResult     = $project->media()->orderBy('updated_at', 'desc')->get();
        $mediaActivities = $mediaResult->map(function (Media $media) {
            return $this->createActivity(self::TOPIC_MEDIA,
                [
                    'url'  => $media->getThumbnail(),
                    'name' => User::findOrFail($media->pivot->user_id)->name,
                ], $media->updated_at);
        });

        //$fuuResult
        //$fuuActivities

        return collect($mediaActivities /*+ $fuuActivities */)->sortByDesc('timestamp');
    }

    /**
     * @param $type
     * @param $meta
     * @param $timestamp
     *
     * @return array
     */
    protected function createActivity($topic, $meta, $timestamp)
    {
        return compact('topic', 'meta', 'timestamp');
    }

    /**
     * @param Project $project
     *
     * @return string
     */
    protected function getCacheKey(Project $project)
    {
        return "project_activites_$project->id";
    }
}