<?php

namespace EmergencyExplorer\Util\Release;

use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\Release as ReleaseModel;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

interface Release
{
    /**
     * @param string $provider
     *
     * @return boolean
     */
    public function is(string $provider);

    /**
     * @param File $file
     *
     * @return array
     */
    public function store(File $file);

    /**
     * @param ProjectModel $project
     * @param $file
     *
     * @return ReleaseModel
     */
    public function publish(ProjectModel $project, array $file = null);

    /**
     * @param \EmergencyExplorer\Release $release
     *
     * @return boolean
     */
    public function unpublish(ReleaseModel $release);
}