<?php

namespace EmergencyExplorer\Util\Project;

use EmergencyExplorer\Models\Image;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Models\User;
use EmergencyExplorer\Util\Image\ImageUtil;
use Illuminate\Http\UploadedFile;

class ProjectUtil
{
    /**
     * @var ImageUtil
     */
    protected $imageUtil;

    /**
     * ProjectUtil constructor.
     *
     * @param ImageUtil $imageUtil
     */
    public function __construct(ImageUtil $imageUtil)
    {
        $this->imageUtil = $imageUtil;
    }

    /**
     * Get the project slug
     *
     *
     * @param Project $project
     *
     * @return string
     */
    public function slug(Project $project)
    {
        $slug = str_slug($project->name);

        if ($slug === "") {
            $slug = strtolower(urlencode($project->name));
        }

        return $slug;
    }

    /**
     * Get a URL with inserted SEO for a project
     *
     * @param Project $project
     *
     * @return string
     */
    public function url(Project $project)
    {
        return action('Project\ProjectController@show', [$project, 'seo' => $this->slug($project)]);
    }

    public function cover(Project $project)
    {
        $image = $project->images()->where('type', Image::TYPE_IMAGE)->first();

        return $this->imageUtil->url($image, Image::SIZE_MD);
    }

    public function toggleFollow(Project $project, User $user)
    {
        if ($user = $project->users->where('id', $user->id)->first()) {
            if ($user->pivot->role != Project::PROJECT_ROLE_WATCHER) {
                throw new \Exception('User is a member, not only a watcher. Leave the project instead.');
            }
            $project->users()->detach($user);


            return back();
        } else {
            if (! $project->visible) {
                throw new \Exception('This is a hidden project. You are either in or out.');
            }

            $project->users()->save($user, ['role' => Project::PROJECT_ROLE_WATCHER]);

            return back();
        }
    }
}