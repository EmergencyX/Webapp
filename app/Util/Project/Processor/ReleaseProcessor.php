<?php

namespace EmergencyExplorer\Util\Project\Processor;

use EmergencyExplorer\Models\Release;
use Symfony\Component\HttpFoundation\File\File;

interface ReleaseProcessor
{
    /**
     * Get a download link for a release
     *
     * @param Release $release
     *
     * @return string
     */
    public function url(Release $release) : string;

    /**
     * @param File $file
     *
     * @return Release
     */
    public function store(File $file) : Release;

    /**
     * @param Release $release
     *
     * @return bool
     */
    public function remove(Release $release) : bool;

    /**
     * @param Release $release
     *
     * @return bool
     */
    public function publish(Release $release) : bool;

    /**
     * @param Release $release
     *
     * @return bool
     */
    public function unpublish(Release $release) : bool;
}