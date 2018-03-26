<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;

class TusController extends Controller
{
    public function hook(Request $request) {
        $request->toArray();
    }
}
