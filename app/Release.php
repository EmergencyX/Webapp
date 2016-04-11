<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $fillable = ['name', 'visible', 'beta', 'game_version_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repository()
    {
        return $this->belongsTo(ProjectRepository::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gameVersion()
    {
        return $this->belongsTo(GameVersion::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('progress');
    }
}