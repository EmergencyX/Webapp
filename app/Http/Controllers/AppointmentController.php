<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Appointment;
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
        $appointment            = new Appointment;
        $appointment->content   = '[{"id":1,"enabled":true}]';
        $appointment->name      = $request->get('name');
        $appointment->voicechat = $request->get('voicechat');
        $appointment->profile->;

    }
}
