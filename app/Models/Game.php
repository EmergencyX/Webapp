<?php

namespace EmergencyExplorer\Models;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    function badges()
    {
        return $this->hasMany(Badge::class);
    }

    function versions()
    {
        return $this->hasMany(GameVersion::class)->orderBy('sequence', 'asc');
    }
}
