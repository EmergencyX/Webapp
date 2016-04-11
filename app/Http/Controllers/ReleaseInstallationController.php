<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Release;
use Illuminate\Http\Request;
use EmergencyExplorer\Project;

class ReleaseInstallationController extends Controller
{
    public function index(Request $request, Project $project)
    {
        $user = $request->user();

        $user->load(['installedReleases']);
        $project->load(['releases', 'releases.users', 'releases.gameVersion', 'releases.gameVersion.game']);

        $installedReleases = $user->installedReleases->keyBy('id');
        return view('project.installation.index', compact('user', 'project', 'installedReleases'));
    }

    public function postInstall(Request $request, Release $release)
    {
        $request->user()->installedReleases()->save($release, ['progress' => min(mt_rand(90, 110), 100)]);
        return back();
    }

    public function postUninstall(Request $request, Release $release)
    {
        $request->user()->installedReleases()->detach($release);
        return back();
    }

    public function postCancel(Request $request, Release $release)
    {
        $request->user()->installedReleases()->detach($release);
        return back();
    }

    public function postPlay(Request $request, Release $release)
    {
        return "It's me, Mario";
    }
}
