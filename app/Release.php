<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $fillable = ['name'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repository()
    {
        return $this->belongsTo(ProjectRepository::class);
    }
}