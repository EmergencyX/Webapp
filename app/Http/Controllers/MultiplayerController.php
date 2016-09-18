<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Game;
use phpcent\Client as CentrifugalClient;

class MultiplayerController extends Controller
{
     public function index(Game $gameSlug)
    {
        $config = ['timestamp' => time(), 'user' => 'anon'];
        $client = new CentrifugalClient(env('CENT_HOST'));
        $client->setSecret(env('CENT_SECRET'));
        $config['token'] = $client->generateClientToken($config['user'], $config['timestamp']);
        $config['url'] = str_replace('http', 'ws', env('CENT_HOST')) . '/connection/websocket';
        $config['timestamp'] =  (string)$config['timestamp'];

        return view('multiplayer.browser', ['game' => $gameSlug, 'config' => $config]);
    }
}
