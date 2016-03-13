<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    const RELEASE_TYPE_EMX = 1;
    const RELEASE_TYPE_DIRECT_REMOTE = 2;
    const RELEASE_TYPE_OTHER_REMOTE = 3;
}