<?php

namespace EmergencyExplorer\Util\Project;

use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Models\Release;
use EmergencyExplorer\Util\Project\Processor\HashedLocalReleaseProcessor;
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
            LocalReleaseProcessor::IDENTIFIER       => new LocalReleaseProcessor,
            HashedLocalReleaseProcessor::IDENTIFIER => new HashedLocalReleaseProcessor,
        ];
    }

    /**
     * @param Release $release
     *
     * @return ReleaseProcessor
     */
    protected function getProcessor(Release $release): ReleaseProcessor
    {
        return $this->getProcessorByName($release->provider['p']);
    }

    /**
     * @param string $name
     *
     * @return ReleaseProcessor
     */
    public function getProcessorByName(string $name): ReleaseProcessor
    {
        if (in_array($name, array_keys($this->processor))) {
            return $this->processor[$name];
        }

        throw new \InvalidArgumentException(sprintf('Lookup for release processor %s failed', $name));
    }

    /**
     * @return ReleaseProcessor
     */
    public function getLocalProcessor(): ReleaseProcessor
    {
        return new LocalReleaseProcessor;
    }

    /**
     * @param Release $toRelease
     * @param Release $fromRelease
     *
     * @return string
     */
    public function url(Release $toRelease, Release $fromRelease = null)
    {
        return $this->getProcessor($toRelease)->url($toRelease, $fromRelease);
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

    /**
     * @param array $releases
     *
     * @return array
     */
    public function checkUpdates(array $releases)
    {
        $releases = Release::whereIn('id', $releases)->get();
        $mostRecent = [];

        foreach ($releases as $release) {
            $recent = Release::where('project_id', $release->project_id)
                ->where('updated_at', '>', $release->updated_at)
                ->whereNot('id', $release->id)
                ->orderBy('updated_at', 'desc')
                ->first();

            if ($recent && $release->updated_at) {
                $mostRecent[(int)$release->id] = $recent;
            }
        }

        return $mostRecent;
    }
}