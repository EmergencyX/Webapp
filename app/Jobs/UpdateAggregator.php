<?php

namespace EmergencyExplorer\Jobs;

use EmergencyExplorer\Link;
use EmergencyExplorer\Project;
use EmergencyExplorer\Repositories\Activity as ActivityRepository;
use EmergencyExplorer\Util\Activity\ActivityAggregator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAggregator extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @var Link
     */
    protected $link;

    /**
     * @var Project
     */
    protected $project;

    /**
     * Create a new job instance.
     *
     * @param Project $project
     * @param Link $link
     */
    public function __construct(Project $project, Link $link)
    {
        $this->link = $link;
        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ActivityRepository $activityRepository)
    {
        /** @var ActivityAggregator $activityAggregator */
        foreach ($activityRepository->getActivityAggregators() as $activityAggregator) {
            if ($activityAggregator->canFetchFromThread($this->link->url)) {
                $activityAggregator->updateActivitiesForProject($this->project, $this->link->url, 0, 50);
            }
        }
    }
}
