<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Models\User;
use EmergencyExplorer\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * @return User|null
     */
    public function getCaller()
    {
        return request()->user('api');
        /*abort_unless($user->can('show', $project), 401);
        abort_unless($user->tokenCan('show-project'), 401);

        return \Response::json($project);
       */
    }
}
