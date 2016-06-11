<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public function projects()
    {
        return $this->belongsTo(Project::class);
    }
}
