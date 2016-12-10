<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Models\User;
use EmergencyExplorer\Util\Image\ImageUtil;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function getCaller() : User
    {
        $user = request()->user('api');
        abort_unless($user instanceof User, 401);

        return $user;
        /*abort_unless($user->can('show', $project), 401);
        abort_unless($user->tokenCan('show-project'), 401);

        return \Response::json($project);
       */
    }
}
