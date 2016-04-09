<?php

namespace EmergencyExplorer\Util;

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
}