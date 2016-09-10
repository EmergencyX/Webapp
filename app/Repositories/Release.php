<?php

namespace EmergencyExplorer\Repositories;

use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\Project;
use EmergencyExplorer\Release as ReleaseModel;
use EmergencyExplorer\User as UserModel;
use EmergencyExplorer\Util\ProjectRepositoryUtil;
use EmergencyExplorer\Util\Release\LocalRelease;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class Release
{
    /**
     * @var ReleaseModel
     */
    protected $release;

    protected $providers;

    /**
     * Release constructor.
     *
     * @param ReleaseModel $release
     */
    public function __construct(ReleaseModel $release)
    {
        $this->release = $release;

        $this->providers = [
            'local' => new LocalRelease,
        ];
    }

    /**
     * @param Project $project
     * @param array $attributes
     *
     * @param File $file
     *
     * @return ReleaseModel
     */
    public function store(Project $project, array $attributes, File $file)
    {
        /** @var \EmergencyExplorer\Util\Release\Release $provider */
        $provider = $this->providers[$attributes['provider']];
        $fileinfo = $provider->store($file);
        //$provider->publish($project, $fileinfo);

        $modelAttributes = [
            'provider' => [
                'provider' => $attributes['provider'],
                'fileinfo' => $fileinfo,
            ],

            'name'    => $attributes['name'],
            'beta'    => $attributes['beta'],
            'visible' => $attributes['visible'],
        ];

        $release = $this->release->create($modelAttributes);
        $project->releases()->save($release);

        return $release;
    }

    /**
     * @param ReleaseModel $release
     */
    public function remove(ReleaseModel $release)
    {
        /** @var \EmergencyExplorer\Util\Release\Release $provider */
        $provider = $this->providers[$release->provider['provider']];
        $provider->unpublish($release);
        $release->delete();
    }
}