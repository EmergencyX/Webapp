<?php

namespace EmergencyExplorer\Http\View\Composers;

use EmergencyExplorer\Http\View\Helper\ProjectHelper;
use Illuminate\View\View;

class ProjectComposer
{
    /**
     * @var ProjectHelper
     */
    protected $projectHelper;

    /**
     * ProjectComposer constructor.
     *
     * @param ProjectHelper $projectHelper
     */
    public function __construct(ProjectHelper $projectHelper)
    {
        $this->projectHelper = $projectHelper;
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
        $view->with('projectHelper', $this->projectHelper);
    }
}
