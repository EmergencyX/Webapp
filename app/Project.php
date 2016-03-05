<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    const PROJECT_ROLE_NONE = 0;
    const PROJECT_ROLE_WATCHER = 1;
    const PROJECT_ROLE_MEMBER = 2;
    const PROJECT_ROLE_ADMIN = 3;
    
    function game() {
        return $this->belongsTo(Game::class);
    }
    
    function users() {
        return $this->belongsToMany(User::class)->withPivot('role');
    }
    
    function media() {
        return $this->belongsToMany(Media::class);
    }
}
