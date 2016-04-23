<?php

namespace EmergencyExplorer\Util;
// (/^-^)/ //
use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\Repositories\Project as ProjectRepository;

class Elektrokardiogramm
{
    /**
     * @var \EmergencyExplorer\Repositories\Project
     */
    private $projectRepository;

    /**
     * Elektrokardiogramm constructor.
     *
     * @param \EmergencyExplorer\Repositories\Project $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getHeartRate(ProjectModel $project)
    {
        //Todo:
        //Count downloads in the current week
        //Count active multiplayer downloads
        //Check activity within the last week
        //Add any other information about the "patient" project
        //Map to a heart rate between 0 and max(220 - (age of project in weeks), 168)
        //    where
        //    0 - 40     should be a dying project
        //    40 - 50    should be an actively played project, however without recent activity (sleeping)
        //    50 - 60    put more active projects here
        //    60 - max   this is for hyperactive projects
        //Offer features based on the heart rate
    }

}