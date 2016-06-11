<?php

namespace EmergencyExplorer\Util\Activity;

use EmergencyExplorer\Project;

interface ActivityAggregator
{
    /**
     * Update activities from the given $url
     *
     * @param Project $project
     * @param string $url
     */
    public function updateActivitiesForProject(Project $project, string $url, int $start = 0, int $limit = 10);

    /**
     * Get the identifier for the aggregator
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Check if the given link with type=aggregator can be processed by this activity aggregator
     *
     * @param string $url
     * @return bool
     */
    public function canFetchFromThread(string $url): bool;
}