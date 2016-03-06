<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    const PROJECT_ROLE_NONE = 0;
    const PROJECT_ROLE_WATCHER = 1;
    const PROJECT_ROLE_MEMBER = 2;
    const PROJECT_ROLE_ADMIN = 3;
    
    protected $fillable = [
        'name', 'description', 'status',
    ];
    
    function game() {
        return $this->belongsTo(Game::class);
    }
    
    function users() {
        return $this->belongsToMany(User::class)->withPivot('role');
    }
    
    function admins() {
        return $this->users()->wherePivot('role', self::PROJECT_ROLE_ADMIN);
    }
    
    function watchers() {
        return $this->users()->wherePivot('role', self::PROJECT_ROLE_WATCHER);
    }
    
    function members() {
        return $this->users()->wherePivot('role', self::PROJECT_ROLE_ADMIN)
        ->orWherePivot('role', self::PROJECT_ROLE_MEMBER);
    }
    
    function media() {
        return $this->belongsToMany(Media::class);
    }
}
