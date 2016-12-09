<?php

namespace EmergencyExplorer\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    function badges()
    {
        return $this->belongsToMany(Badge::class)->withPivot('given_at');
    }

    function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('role');
    }

    function installedReleases()
    {
        return $this->belongsToMany(Release::class)->withPivot('progress');
    }

    function avatar()
    {
        return $this->images()->where('type', Image::TYPE_AVATAR)->first();
    }

    function images()
    {
        $this->morphMany(Image::class, 'owner');
    }


    function isFollowingProject($project)
    {
        return $project->users->contains($this);
    }

    public function findForPassport(string $name)
    {
        return $this->where('name', $name)->first();
    }
}
