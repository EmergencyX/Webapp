<?php

namespace EmergencyExplorer\Http\Controllers\User;

use EmergencyExplorer\Http\Controllers\Controller;
use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\User;
use EmergencyExplorer\Util\Image\ImageUtil;
use EmergencyExplorer\Util\UserUtil;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserUtil
     */
    protected $userUtil;

    /**
     * @var ImageUtil
     */
    protected $imageUtil;

    /**
     * UserController constructor.
     *
     * @param NavigationHelper $navigationHelper
     * @param UserUtil $userUtil
     * @param ImageUtil $imageUtil
     */
    public function __construct(NavigationHelper $navigationHelper, UserUtil $userUtil, ImageUtil $imageUtil)
    {
        $navigationHelper->setSection(NavigationHelper::USERS);
        $this->userUtil = $userUtil;
        $this->imageUtil = $imageUtil;
    }

    function index()
    {
        $users = User::all(); //Todo: Pagination

        return view('user.index', compact('users'));
    }

    function show(User $user, $seo = null)
    {
        $slug = $this->userUtil->slug($user);
        if ($seo != $slug) {
            return redirect($this->userUtil->url($user));
        }

        //Todo: Order by ekg
        $projects = $user->projects->take(5);

        //Todo: Optimize or move into a Util Class?
        $projectRoles = [];
        foreach ($projects as $project) {
            $projectRoles[$project->id] = $project->users->find($user)->pivot->role;
        }

        return view('user.show', compact('user', 'projects', 'projectRoles'));
    }

    function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    function update(User $user, Request $request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            abort_unless($file->isValid(), 400);
            $user->images()->where('type', Image::TYPE_AVATAR)->delete();

            $image       = $this->imageUtil->fromFile($file, []);
            $image->type = Image::TYPE_AVATAR;

            $user->images()->save($image);
        }

        return redirect($this->userUtil->url($user));
    }
}
