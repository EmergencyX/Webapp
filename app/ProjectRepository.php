<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class ProjectRepository extends Model
{
    const REPOSITORY_TYPE_BIN = 0;
    const REPOSITORY_TYPE_EMX = 1;
    const REPOSITORY_TYPE_GIT = 2;
    const REPOSITORY_TYPE_SVN = 3;

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
