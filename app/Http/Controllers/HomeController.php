<?php

namespace EmergencyExplorer\Http\Controllers;

use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

class HomeController extends Controller
{
    function index() {
        return view('home.index');
    }
}
