<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    function game() {
        return $this->belongsTo(Game::class);
    }
    
    function users() {
        return $this->hasMany(User::class);
    }
}
