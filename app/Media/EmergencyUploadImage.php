<?php

namespace EmergencyExplorer\Media;

use EmergencyExplorer\Media as MediaModel;
use EmergencyExplorer\User as UserModel;
use Illuminate\Http\UploadedFile;

class EmergencyUploadImage implements Image
{
    /**
     * EmergencyUploadImage constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param UploadedFile $file
     * @param UserModel $user
     *
     * @return MediaModel
     */
    public function uploadImage(UploadedFile $file, UserModel $user)
    {
        // TODO: Implement uploadImage() method.
    }

    public function deleteImage(MediaModel $media)
    {
        // TODO: Implement deleteImage() method.
    }
}