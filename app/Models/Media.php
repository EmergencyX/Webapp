<?php

namespace EmergencyExplorer\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'name',
        'description',
        'meta',
    ];

    function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    function users()
    {
        return $this->belongsToMany(User::class);
    }

    function getThumbnail($size = 'xs')
    {
        return asset('storage/' . $this->id . '-' . $size . '.jpg');
    }

    function getImageLink($size = 'xs')
    {
        $imageData = json_decode($this->meta, true);
        if (isset($imageData[$size])) {
            /** @var Repositories\Media $repository */
            $repository = app(Repositories\Media::class);

            return $repository->getImageProvider($imageData[$size]['provider'])->getImageLink($this, $size);
        } else {
            return $this->getThumbnail($size);
        }
    }
}
