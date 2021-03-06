<?php

namespace EmergencyExplorer\Models;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    const INVITATION_TYPE_PROJECT = 1;
    
    const INVITATION_STATE_PENDING  = 1;
    const INVITATION_STATE_REJECTED = 2;
    const INVITATION_STATE_ACCEPTED = 3;

    function fromUser() {
        return $this->belongsTo(User::class, 'from_user_id');
    }
    
    function forUser() {
        return $this->belongsTo(User::class, 'for_user_id');
    }
    
    //We will see if this works out as expected.
    //Hopefully the ORM catches the hint - would love to not have to store the full class name for each entry (@see laravel morphMany())
    function relatedTarget() {
        switch ($this->invitation_type) {
            case INVITATION_TYPE_PROJECT:
                return $this->belongsTo(Project::class);
        }

        return null;
    }
}
