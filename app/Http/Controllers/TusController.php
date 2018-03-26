<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Util\TokenUtil;
use Illuminate\Http\Request;

class TusController extends Controller
{
    private const HOOK_NAME_HEADER = 'hook-name';
    private const META_DATA_FIELD = 'MetaData';
    /**
     * @var TokenUtil
     */
    private $tokenUtil;

    /**
     * TusController constructor.
     * @param TokenUtil $tokenUtil
     */
    public function __construct(TokenUtil $tokenUtil)
    {
        $this->tokenUtil = $tokenUtil;
    }

    public function hook(Request $request)
    {
        $event = $request->header(self::HOOK_NAME_HEADER);
        if ($event === null) {
            logger()->error('invalid hookname in ' . TusController::class);
            return response()->json([], 403);
        }

        $metadata = $request->json()->get(self::META_DATA_FIELD);
        if ($metadata === null || !isset($metadata['token'])) {
            logger()->error('invalid metadata in ' . TusController::class);
            return response()->json([], 403);
        }

        logger()->debug('metadata', $metadata);
        $user = $this->tokenUtil->decodeTusToken($metadata['token']);
        if ($user === null) {
            logger()->error('invalid token in metadata ' . TusController::class);
            return response()->json([], 403);
        }

        logger()->debug('user', $user->toArray());

        return response()->json([], 200);
    }


}
