<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    function users() {
        return $this->hasMany(User::class)->with('given_at');
    }
}
