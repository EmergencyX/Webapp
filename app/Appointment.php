<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    function gameVersion() {
        return $this->belongsTo(GameVersion::class);
    }
    
    function profile() {
        return $this->belongsTo(Profile::class);
    }
}
