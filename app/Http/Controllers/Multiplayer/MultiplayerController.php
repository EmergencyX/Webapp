<?php

namespace EmergencyExplorer\Http\Controllers\Multiplayer;

use EmergencyExplorer\Http\Controllers\Controller;
use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use EmergencyExplorer\Models\Game as GameModel;
use phpcent\Client as CentrifugalClient;

class MultiplayerController extends Controller
{
    /**
     * MultiplayerController constructor.
     *
     * @param NavigationHelper $navigationHelper
     */
    public function __construct(NavigationHelper $navigationHelper)
    {
        $navigationHelper->setSection(NavigationHelper::MULTIPLAYER);
    }

    public function index(GameModel $gameSlug)
    {
        $client = new CentrifugalClient(env('CENT_HOST'));
        $client->setSecret(env('CENT_SECRET'));

        $config              = ['timestamp' => time(), 'user' => 'browser'];
        $config['token']     = $client->generateClientToken($config['user'], $config['timestamp']);
        $config['url']       = str_replace('http:', 'ws:', env('CENT_HOST') . '/connection/websocket');
        $config['timestamp'] = (string) $config['timestamp'];

        return view('multiplayer.browser', ['game' => $gameSlug, 'config' => $config]);
    }
}