<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Profile;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('appointment.create', ['profiles' => Profile::all()]);
    }

    public function store(Request $request)
    {
        $profile = new Profile;
        $profile->
    }
}
