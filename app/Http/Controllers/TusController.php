<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;

class TusController extends Controller
{
    public function hook(Request $request)
    {
        $event = $request->header('hook-name');
        if ($event === null) {
            logger()->error('invalid hookname in ' . TusController::class);
            return response('', 403);
        }
        logger()->error('invalid hookname in ' . TusController::class);
        return response('', 403);
        logger()->debug('header', $request->headers->all());
        logger()->debug('hey', $request->toArray());
    }
}
