<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    function projects() {
        return $this->hasMany(Project::class);
    }
}
