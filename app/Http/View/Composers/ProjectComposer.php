<?php

namespace EmergencyExplorer\Http\View\Composers;

use EmergencyExplorer\Util\Project\ProjectUtil;
use Illuminate\View\View;

class ProjectComposer
{
    public function __construct(ProjectUtil $projectUtil)
    {
        $this->projectUtil = $projectUtil;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('projectUtil', $this->projectUtil);
    }
}
