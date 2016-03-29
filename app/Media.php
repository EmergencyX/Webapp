<?php

namespace EmergencyExplorer;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'name', 'description', 'meta'
    ];
    
    function projects() {
        return $this->belongsToMany(Project::class);
    }
    
    function users() {
        return $this->belongsToMany(User::class);
    }
    
    function getThumbnail($size = 'xs') {
        return asset('storage/'.$this->id.'-'.$size.'.jpg');
    }
}