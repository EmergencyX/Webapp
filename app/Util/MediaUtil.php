<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\Media;

use Gate;
use Thumbnail; //Todo: Use DIJ instead of facade
use Illuminate\Http\UploadedFile;

class MediaUtil
{
    /**
     * @param array $mediaInfo
     * @param UploadedFile $file
     *
     * @return Media
     */
    public static function createMedia(array $mediaInfo, UploadedFile $file)
    {
        $media = Media::create(array_merge($mediaInfo, ['meta' => '{}']));
        $file->move(storage_path('app'), $media->id . '.' . $file->getClientOriginalExtension());

        $filePath = storage_path('app/' . $media->id . '.' . $file->getClientOriginalExtension());
        $imagine = Thumbnail::open($filePath);
        $imagine->thumbnail(new \Imagine\Image\Box(128, 128), \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND)
            ->save(public_path('storage/' . $media->id . '-xs.jpg'));
        $imagine->thumbnail(new \Imagine\Image\Box(720, 256), \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND)
            ->save(public_path('storage/' . $media->id . '-md.jpg'));
        $imagine->resize($imagine->getSize()->widen(1920))->save(public_path('storage/' . $media->id . '-lg.jpg'));
        logger()->info('Generated thumbnails for media', $media->toArray());

        //unlink($filePath); //Todo: Keep the original file for later re-processing?
        return $media;
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
            return asset('storage/' . $media->id . '-' . $size . '.jpg');
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