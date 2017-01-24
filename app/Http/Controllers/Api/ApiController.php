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
    }
}
