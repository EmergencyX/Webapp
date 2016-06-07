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
     * @param array $mediaInfo
     * @param UploadedFile $file
     *
     * @return Media
     */
    public static function createMedia(array $mediaInfo, UploadedFile $file)
    {
        ///** @var Media\EmergencyUploadImage $testEmUpload */
        //$testEmUpload = app(Media\EmergencyUploadImage::class);
        //$testEmUpload->uploadImage($file, Auth::user());
        //return;

        $media = Media::create($mediaInfo);
        $filename = $media->id . '.' . $file->getClientOriginalExtension();
        
        $file->move(storage_path('app'), $filename);
        $filepath = storage_path('app/'. $filename);
        
        //Heads up! destroy() does not delete the image, as the previous save() might suggest.
        //Instead the used image instance is destroyed and therefore memory freed.
        Image::make($filepath)->fit(128, 128)->save(public_path('storage/' . $media->id . '-xs.jpg'))->destroy();
        Image::make($filepath)->fit(320, 180)->save(public_path('storage/' . $media->id . '-sm.jpg'))->destroy();
        Image::make($filepath)->fit(640, 360)->save(public_path('storage/' . $media->id . '-md.jpg'))->destroy();

        $imageLg = Image::make($filepath);
        if ($imageLg->height() > 1920 || $imageLg->width() > 1920) {
            if ($imageLg->height() > $imageLg->width()) {
                $imageLg->fit(1080, 1920, function ($constraint) {
                    $constraint->upsize();
                });
            } else {
                $imageLg->fit(1920, 1080, function ($constraint) {
                    $constraint->upsize();
                });
            }
            $imageLg->save(public_path('storage/' . $media->id . '-lg.jpg'));
        }
        $imageLg->destroy();
        
        logger()->info('Generated thumbnails for media', $media->toArray());

        //unlink($filePath); //Todo: Keep the original file for later re-processing?
        return $media;
    }


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