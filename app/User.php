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
        'name', 'email', 'password',
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
        return $this->hasMany(Badge::class)->with('given_at');
    }
    
    function media() {
        return $this->hasMany(Media::class);
    }
    
    function projects() {
        return $this->hasMany(Project::class)->with('role');
    }
}
