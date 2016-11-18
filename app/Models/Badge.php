<?php

namespace EmergencyExplorer\Models;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    function users() {
        return $this->belongsToMany(User::class)->with('given_at');
    }
    
    function game() {
        return $this->belongsTo(Game::class);
    }
}
