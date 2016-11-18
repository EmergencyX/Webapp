<?php

namespace EmergencyExplorer\Models;
use Illuminate\Database\Eloquent\Model;

class ProjectRepository extends Model
{
    //Projects do have one "main" repository that stores the full project
    const REPOSITORY_TYPE_FLL = 1;

    //Reserved 2,3,4

    //Projects can add further repositories. Those are mirrors of code.
    //We will disable them in v0.1, as custom build rules are not yet supported and they'll therefore lack usage.
    const REPOSITORY_TYPE_BIN = 5;
    const REPOSITORY_TYPE_EMX = 6;
    const REPOSITORY_TYPE_GIT = 7;
    const REPOSITORY_TYPE_SVN = 8;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'visible'         => 'boolean',
        'repository_type' => 'int',
    ];

    protected $fillable = ['name', 'visible', 'repository_type'];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function releases()
    {
        return $this->hasMany(Release::class);
    }
}
