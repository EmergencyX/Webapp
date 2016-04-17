<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\Project;
use EmergencyExplorer\ProjectRepository;

class ProjectRepositoryUtil
{
    /**
     * Check if the repository can be build
     *
     * @param ProjectRepository $projectRepository
     *
     * @return bool
     */
    public static function canBeBuild(ProjectRepository $projectRepository)
    {
        return $projectRepository->repository_type != ProjectRepository::REPOSITORY_TYPE_BIN;
    }

    /**
     * Get a list of all available repository types (could be upgraded to a db)
     *
     * @return array
     */
    public static function getRepositoryTypes()
    {
        return [ProjectRepository::REPOSITORY_TYPE_BIN];
    }

    /**
     * @param Project $project
     *
     * @return ProjectRepository
     */
    public static function newMainRepository(Project $project)
    {
        $repository = new ProjectRepository([
            'repository_type' => ProjectRepository::REPOSITORY_TYPE_FLL,
            'visible'         => 1,
            'name'            => "$project->id-main",
        ]);

        //Todo: Spawn job to create repository directory

        return $repository;
    }
}