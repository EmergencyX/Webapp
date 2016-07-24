<?php

namespace EmergencyExplorer\Http\Controllers;

use Carbon\Carbon;
use EmergencyExplorer\Appointment as AppointmentModel;
use EmergencyExplorer\GameVersion;
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
        $appointment            = new AppointmentModel();
        $appointment->name      = $request->get('name');
        $appointment->voicechat = $request->get('voicechat');
        $appointment->profile()->associate(Profile::first());
        $appointment->gameVersion()->associate(GameVersion::first());
        $appointment->visible = true;
        $appointment->date_at = Carbon::now();

        $appointment->save();

        return $appointment;
    }

    public function edit(AppointmentModel $appointment)
    {
        return $appointment;
    }

    public function update(AppointmentModel $appointment, Request $request)
    {
        $appointment->content = '[{"id":1,"enabled":false}]';
        $appointment->save();
    }

    public function index()
    {
        return AppointmentModel::all();
    }

    public function show(AppointmentModel $appointment)
    {
        return $appointment;
    }
}
