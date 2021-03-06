<?php

namespace EmergencyExplorer\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    const PROJECT_ROLE_NONE    = 0;
    const PROJECT_ROLE_WATCHER = 1;
    const PROJECT_ROLE_TESTER  = 2;
    const PROJECT_ROLE_MEMBER  = 3;
    const PROJECT_ROLE_ADMIN   = 9;

    protected $fillable = [
        'name',
        'description',
        'status',
        'game_id',
        'visible',
    ];

    function game()
    {
        return $this->belongsTo(Game::class);
    }

    function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    function admins()
    {
        return $this->users()->wherePivot('role', self::PROJECT_ROLE_ADMIN);
    }

    function watchers()
    {
        return $this->users()->wherePivot('role', self::PROJECT_ROLE_WATCHER);
    }

    function members()
    {
        $memberRoles = [self::PROJECT_ROLE_MEMBER, self::PROJECT_ROLE_ADMIN];

        return $this->users()->whereIn('project_user.role', $memberRoles);
    }

    function usersWithoutWatchers()
    {
        $withoutWatchers = [self::PROJECT_ROLE_TESTER, self::PROJECT_ROLE_MEMBER, self::PROJECT_ROLE_ADMIN];

        return $this->users()->whereIn('project_user.role', $withoutWatchers);
    }

    function images()
    {
        return $this->morphMany(Image::class, 'owner')->where('type', Image::TYPE_IMAGE);
    }

    function repositories()
    {
        return $this->hasMany(ProjectRepository::class);
    }

    function releases()
    {
        return $this->hasMany(Release::class);
    }
}
