<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\Media;

use EmergencyExplorer\User;
use Gate;
use Auth;
use Image; //Todo: Use DIJ instead of facade
use Illuminate\Http\UploadedFile;

class MediaUtil
{

    /**
     * @param \EmergencyExplorer\User $user
     * @param \Illuminate\Http\UploadedFile $file
     */
    public static function createUserMedia(User $user, UploadedFile $file)
    {
        $file->move(storage_path('app'), $user->id . '.' . $file->getClientOriginalExtension());
        Thumbnail::open(storage_path('app/' . $user->id . '.' . $file->getClientOriginalExtension()))
            ->thumbnail(new \Imagine\Image\Box(128, 128), \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND)
            ->save(public_path('storage/user-' . $user->id . '.jpg'));
    }

    /**
     * Returns a thumbnail for the given $media in the given $size or a placeholder if not present
     *
     * @param \EmergencyExplorer\Media|null $media
     * @param string $size
     *
     * @return string
     */
    public static function getThumbnail(Media $media = null, $size = 'xs')
    {

        if ($media) {
            return $media->getImageLink($size);

            //return asset('storage/' . $media->id . '-' . $size . '.jpg');
        }

        return asset('storage/26-' . $size . '.jpg');
    }


    public static function deleteMedia(Media $media)
    {
        //The thumbnailing really needs optimization
        unlink(public_path('storage/' . $media->id . '-lg.jpg'));
        unlink(public_path('storage/' . $media->id . '-md.jpg'));
        unlink(public_path('storage/' . $media->id . '-xs.jpg'));

        return $media->delete();
    }
}