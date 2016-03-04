<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    function projects() {
        return $this->hasMany(Project::class);
    }
    
    function users() {
        return $this->hasMany(User::class);
    }
}
