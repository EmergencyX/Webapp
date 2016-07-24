<?php

namespace EmergencyExplorer\Http\Controllers;

use Carbon\Carbon;
use EmergencyExplorer\Appointment as AppointmentModel;
use EmergencyExplorer\GameVersion;
use EmergencyExplorer\Profile;
use EmergencyExplorer\Project;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('appointment.create', ['profiles' => Profile::all(), 'projects' => Project::all()->random(2)]);
    }

    public function store(Request $request)
    {
        $appointment            = new AppointmentModel();
        $appointment->name      = $request->get('name');
        $appointment->voicechat = $request->get('voicechat');
        $appointment->profile()->associate(Profile::first());
        $appointment->gameVersion()->associate(GameVersion::first());
        $appointment->visible = $request->get('visible');
        $appointment->date_at = Carbon::parse($request->get('date_at'));

        $appointment->save();

        return $appointment;
    }

    public function edit(AppointmentModel $appointment)
    {
        $profiles = Profile::all();

        return view('appointment.edit', compact('profiles', 'appointment'));
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
