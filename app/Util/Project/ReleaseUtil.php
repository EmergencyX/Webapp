<?php

namespace EmergencyExplorer\Util\Project;

use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Models\Release;
use EmergencyExplorer\Util\Project\Processor\LocalReleaseProcessor;
use EmergencyExplorer\Util\Project\Processor\ReleaseProcessor;

class ReleaseUtil
{
    protected $processor = [];

    /**
     * ReleaseUtil constructor.
     */
    public function __construct()
    {
        $this->processor = [
            LocalReleaseProcessor::IDENTIFIER => new LocalReleaseProcessor,
        ];
    }

    /**
     * @param Release $release
     *
     * @return ReleaseProcessor
     */
    protected function getProcessor(Release $release): ReleaseProcessor
    {
        return $this->processor[$release->provider['p']];
    }

    /**
     * @return ReleaseProcessor
     */
    public function getLocalProcessor(): ReleaseProcessor
    {
        return new LocalReleaseProcessor;
    }

    /**
     * @param Release $release
     *
     * @return string
     */
    public function url(Release $release)
    {
        return $this->getProcessor($release)->url($release);
    }

    /**
     * @param Project $project
     *
     * @return mixed
     */
    public function forProject(Project $project)
    {
        $project->load('releases');

        return $project->releases;
    }

    /**
     * @param Release $release
     *
     * @return bool
     */
    public function remove(Release $release)
    {
        $processor = $this->getProcessor($release);
        $processor->unpublish($release);
        return $processor->remove($release);
    }
}