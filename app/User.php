<?php

namespace EmergencyExplorer;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    function badges() {
        return $this->belongsToMany(Badge::class)->withPivot('given_at');
    }
    
    function media() {
        return $this->belongsToMany(Media::class);
    }
    
    function projects() {
        return $this->belongsToMany(Project::class)->withPivot('role');
    }

    function getThumbnail() {
        return asset('storage/user-' . $this->id . '.jpg');
    }
}
