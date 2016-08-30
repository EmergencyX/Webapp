<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Game;

class MultiplayerController extends Controller
{
     public function index(Game $gameSlug)
    {
        return view('multiplayer.browser', ['game' => $gameSlug]);
    }
}
