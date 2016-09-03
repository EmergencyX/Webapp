<?php

namespace EmergencyExplorer\Http\Controllers\Api;

use EmergencyExplorer\Project;
use EmergencyExplorer\Release;
use EmergencyExplorer\User;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Controllers\Controller;

class StorageController extends Controller
{
    public function download(Request $request, Release $release)
    {
        $user = $request->user('api');
        abort_unless($user instanceof User, 401);
        abort_unless($user->can('show', $release), 401);
        abort_unless($user->tokenCan('show-release'), 401);


    }
}
