<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    function user() {
        return $this->belongsTo(User::class);
    }
    
    function profile() {
        return $this->belongsTo(Profile::class);
    }
}
