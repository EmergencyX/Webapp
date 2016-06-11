<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
