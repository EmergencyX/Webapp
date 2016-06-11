<?php

namespace EmergencyExplorer\Jobs;

use EmergencyExplorer\Jobs\Job;
use EmergencyExplorer\Link;
use EmergencyExplorer\Repositories\Activity as ActivityRepository;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRemoteActivity extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @var Link
     */
    protected $link;

    /**
     * Create a new job instance.
     *
     * @param Link $link
     */
    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ActivityRepository $activityRepository)
    {
        foreach ($activityRepository->getActivityAggregators() as $activityAggregator) {
            if ($activityAggregator->canFetchFromThread($this->link->url))  {
                $activityAggregator->updateActivitiesFromThread($this->link->url);
            }
        }
    }
}
