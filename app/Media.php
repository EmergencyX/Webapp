<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    function projects() {
        return $this->belongsToMany(Project::class);
    }
    
    function users() {
        return $this->belongsToMany(User::class);
    }
}
