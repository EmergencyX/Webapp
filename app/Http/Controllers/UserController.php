<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use EmergencyExplorer\Util\MediaUtil;
use EmergencyExplorer\Util\UserUtil;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

use EmergencyExplorer\User;
use EmergencyExplorer\Project;

class UserController extends Controller
{
    /**
     * UserController constructor.
     *
     * @param \EmergencyExplorer\Http\View\Helper\NavigationHelper $navigationHelper
     */
    public function __construct(NavigationHelper $navigationHelper)
    {
        $navigationHelper->setSection(NavigationHelper::USERS);
    }

    function index()
    {
        $users = User::all(); //Todo: Pagination

        return view('user.index', compact('users'));
    }

    function show($id, $seo = null)
    {
        $user = User::findOrFail($id);

        $slug = str_slug($user->name);
        if ($seo != $slug) {
            return redirect(action('UserController@show', ['id' => $id, 'seo' => $slug]));
        }

        //Todo: Order by fame
        $projects = $user->projects->take(5);

        //Todo: Optimize or move into a Util Class?
        $projectRoles = [];
        foreach ($projects as $project) {
            $projectRoles[$project->id] = $project->users->find($user)->pivot->role;
        }

        return view('user.show', compact('user', 'projects', 'projectRoles'));
    }

    function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit', compact('user'));
    }

    function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            abort_unless($file->isValid(), 400);

            $user = $request->user();
            $project = Project::findOrFail($id);
            if ($request->hasFile('media') && $file->isValid()) {
                $imageData = ['sizes' => ['xs', 'sm'], 'provider' => 'local', 'visible' => 1];
                $this->mediaRepository->createImage($file, $imageData, $user, $project);
            }
        }
        
        return redirect(UserUtil::getUserAction($user));
    }
}
