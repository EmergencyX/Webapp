<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $fillable = ['name', 'visible', 'beta', 'game_version_id', 'provider'];

    protected $casts = [
        'provider' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gameVersion()
    {
        return $this->belongsTo(GameVersion::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('progress');
    }
}