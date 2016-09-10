<?php

namespace EmergencyExplorer\Util\Release;

use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\Release as ReleaseModel;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class LocalRelease implements Release
{
    /**
     * @param string $provider
     *
     * @return boolean
     */
    public function is(string $provider)
    {
        return $provider === 'local';
    }

    /**
     * @param File $file
     *
     * @return array
     */
    public function store(File $file)
    {
        $name = str_random(64);
        $frag = 'mods/' . substr($name, 0, 2);
        $path = storage_path($frag);
        $file->move($path, $name);

        return [
            'path' => $frag,
            'name' => $name,
        ];
    }

    /**
     * @param ProjectModel $project
     * @param $file
     *
     * @return ReleaseModel
     */
    public function publish(ProjectModel $project, array $file = null)
    {

    }

    /**
     * @param \EmergencyExplorer\Release $release
     *
     * @return boolean
     */
    public function unpublish(ReleaseModel $release)
    {
        $provider = $release->provider['fileinfo'];
        $path     = storage_path($provider['path']) . '/' . $provider['name'];
        unlink($path);
    }
}