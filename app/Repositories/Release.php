<?php

namespace EmergencyExplorer\Repositories;

use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\Release as ReleaseModel;
use EmergencyExplorer\User as UserModel;
use EmergencyExplorer\Util\ProjectRepositoryUtil;
use EmergencyExplorer\Util\Release\LocalRelease;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

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
     * @param array $attributes
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return ReleaseModel
     */
    public function create(array $attributes, UploadedFile $file)
    {
        /** @var \EmergencyExplorer\Util\Release\Release $provider */
        $provider = $this->providers[$attributes['provider']['name']];

        $identifier = str_random(60);
        $provider->publish($attributes['provider'], $identifier, $file);

        $modelAttributes = [
            'provider' => json_encode([
                'token'    => $identifier,
                'provider' => $attributes['provider']['name'],
            ]),

            'name'    => $attributes['name'],
            'beta'    => $attributes['beta'],
            'visible' => $attributes['visible'],
            //'project_id'            => $attributes['project_id'],
            //'game_version_id'       => $attributes['game_version_id'],
            //'project_repository_id' => null,
        ];

        return $this->release->create($modelAttributes);
    }
}