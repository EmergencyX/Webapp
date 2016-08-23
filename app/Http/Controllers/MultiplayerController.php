<?php

namespace EmergencyExplorer\Http\Controllers;

class MultiplayerController extends Controller
{
     public function index($gameSlug)
    {
        return view('multiplayer.browser', ['game']);
    }
}
