<?php

namespace EmergencyExplorer\Media;

use EmergencyExplorer\Media as MediaModel;
use EmergencyExplorer\User as UserModel;
use Illuminate\Http\UploadedFile;

interface Image
{
    /**
     * @param UploadedFile $file
     * @param UserModel $user
     *
     * @return MediaModel
     */
    public function uploadImage(UploadedFile $file, UserModel $user);

    public function deleteImage(MediaModel $media);
}