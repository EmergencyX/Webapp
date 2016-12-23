<?php

namespace EmergencyExplorer\Http\View\Composers;

use EmergencyExplorer\Util\UserUtil;
use Illuminate\View\View;

class UserComposer
{
    public function __construct(UserUtil $userUtil)
    {
        $this->userUtil = $userUtil;
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
        $view->with('userUtil', $this->userUtil);
    }
}
